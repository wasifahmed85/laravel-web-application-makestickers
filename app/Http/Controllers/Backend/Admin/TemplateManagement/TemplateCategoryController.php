<?php

namespace App\Http\Controllers\Backend\Admin\TemplateManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateManagement\TemplateCategoryRequest;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;
use League\Uri\UriTemplate\Template;

class TemplateCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        
        // Define permissions for each method
        $this->middleware('permission:template-category-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:template-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:template-category-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:template-category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:template-category-trash', ['only' => ['trash', 'restore']]);
        $this->middleware('permission:template-category-restore', ['only' => ['restore']]);
        $this->middleware('permission:template-category-force-delete', ['only' => ['forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templateCategories = TemplateCategory::latest()->get();
        return view('backend.admin.templateManagement.templateCategory.index', compact('templateCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.templateManagement.templateCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TemplateCategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = admin()->id;
        TemplateCategory::create($validated);
        session()->flash('success', 'Template Category created successfully');
        return redirect()->route('am.template-category.index')
            ->with('success', 'Template Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $template_category = TemplateCategory::findOrFail(decrypt($id));
        return view('backend.admin.templateManagement.templateCategory.view', compact('template_category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template_category = TemplateCategory::findOrFail(decrypt($id));
        return view('backend.admin.templateManagement.templateCategory.edit', compact('template_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TemplateCategoryRequest $request, string $id)
    {
        $template_category = TemplateCategory::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['updated_by'] = admin()->id;
        $template_category->update($validated);

        session()->flash('success', 'Template Category updated successfully');
        return redirect()->route('am.template-category.index')
            ->with('success', 'Template Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template_category = TemplateCategory::findOrFail(decrypt($id));
        $template_category->update([
            'deleted_by' => admin()->id
        ]);

        $template_category->delete();
        session()->flash('success', 'Template Category deleted successfully');
        return redirect()->route('am.template-category.index');
    }

    public function status(string $id, string $status)
    {
        $template_category = TemplateCategory::findOrFail(decrypt($id));
        $template_category->status = decrypt($status);
        $template_category->save();
        session()->flash('success', 'Template category status updated successfully');
        return redirect()->route('am.template-category.index');
    }

    public function trash()
    {
        $template_categories = TemplateCategory::onlyTrashed()->get();
        return view('backend.admin.templateManagement.templateCategory.trash', compact('template_categories'));
    }
    public function restore(string $id)
    {
        $templateCategory = TemplateCategory::onlyTrashed()->findOrFail(decrypt($id));
        $templateCategory->update(['deleted_by' => null, 'deleted_at' => null, 'updated_by' => admin()->id]);
        $templateCategory->restore();
        session()->flash('success', 'Template Category restored successfully');
        return redirect()->route('am.template-category.trash');
    }
    public function forceDelete(string $id)
    {
        $templateCategory = TemplateCategory::onlyTrashed()->findOrFail(decrypt($id));
        $templateCategory->forceDelete();
        session()->flash('success', 'Template Category deleted permanently.');
        return redirect()->route('am.template-category.trash');
    }
}
