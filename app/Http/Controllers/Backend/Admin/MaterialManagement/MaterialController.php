<?php

namespace App\Http\Controllers\Backend\Admin\MaterialManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialManagement\MaterialRequest;
use App\Models\Material;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MaterialController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        
        // Define permissions for each method
        $this->middleware('permission:material-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:material-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:material-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:material-delete', ['only' => ['destroy']]);
        $this->middleware('permission:material-trash', ['only' => ['trash', 'restore']]);
        $this->middleware('permission:material-restore', ['only' => ['restore']]);
        $this->middleware('permission:material-force-delete', ['only' => ['forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $materials = Material::latest()->get();
        return view('backend.admin.materialManage.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('backend.admin.materialManage.materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        $material = new Material();
        $material->sort_order = $request->sort_order;
        $material->name = $request->name;
        $material->description = $request->description;
        $material->icons = $request->icons;
        $material->price_modifier = $request->price_modifier;
        $material->created_by = auth()->guard('admin')->user()->id;


        $material->save();

        return redirect()->route('am.material.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material = Material::findOrFail(decrypt($id));
        return view('backend.admin.materialManage.materials.view', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $material = Material::findOrFail(decrypt($id));
        return view('backend.admin.materialManage.materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialRequest $request, string $id)
    {
        $material = Material::findOrFail(decrypt($id));
        $material->name = $request->name;
        $material->description = $request->description;
        $material->icons = $request->icons;
        $material->price_modifier = $request->price_modifier;
        $material->updated_by = auth()->guard('admin')->user()->id;

        $material->save();
        session()->flash('success', 'Material updated successfully');
        return redirect()->route('am.material.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail(decrypt($id));
        $material->update([
            'deleted_by' => admin()->id
        ]);
        
        $material->delete();
        session()->flash('success', 'Material deleted successfully');
        return redirect()->route('am.material.index');
    }

    public function status(string $id, string $status)
    {
        $material = Material::findOrFail(decrypt($id));
        $material->status = decrypt($status);
        $material->save();
        return redirect()->route('am.material.index');
    }

    public function trash()
    {
        $materials = Material::onlyTrashed()->get();
        return view('backend.admin.materialManage.materials.trash', compact('materials'));
    }
    public function restore(string $id)
    {
        $material = Material::onlyTrashed()->findOrFail(decrypt($id));
        $material->update(['deleted_by' => null, 'deleted_at' => null, 'updated_by' => admin()->id]);
        $material->restore();

        session()->flash('success', 'Material restored successfully.');
        return redirect()->route('am.material.index');
    }
    public function forceDelete(string $id)
    {
        $material = Material::onlyTrashed()->findOrFail(decrypt($id));
        $material->forceDelete();
        
        session()->flash('success', 'Material deleted permanently.');
        return redirect()->route('am.material.trash');
    }
}
