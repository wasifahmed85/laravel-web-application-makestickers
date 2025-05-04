<?php

namespace App\Http\Controllers\Backend\Admin\MaterialManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialManagement\MaterialAttributeRequest;
use App\Http\Requests\MaterialManagement\MaterialRequest;
use App\Models\MaterialAttribute;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MaterialAttributeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        
        // Define permissions for each method
        $this->middleware('permission:material-attribute-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:material-attribute-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:material-attribute-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:material-attribute-delete', ['only' => ['destroy']]);
        $this->middleware('permission:material-attribute-trash', ['only' => ['trash', 'restore']]);
        $this->middleware('permission:material-attribute-restore', ['only' => ['restore']]);
        $this->middleware('permission:material-attribute-force-delete', ['only' => ['forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $material_attributes = MaterialAttribute::latest()->get();
        return view('backend.admin.materialManage.materialAttribute.index', compact('material_attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('backend.admin.materialManage.materialAttribute.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialAttributeRequest $request)
    {
        $material_attribute = new MaterialAttribute();
        $material_attribute->name = $request->name;
        $material_attribute->type = $request->type;

        $material_attribute->created_by = auth()->guard('admin')->user()->id;

        $material_attribute->save();
        session()->flash('success', 'Material Attribute created successfully');
        return redirect()->route('am.material-attribute.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material_attribute = MaterialAttribute::findOrFail(decrypt($id));
        return view('backend.admin.materialManage.materialAttribute.view', compact('material_attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $material_attribute = MaterialAttribute::findOrFail(decrypt($id));
        return view('backend.admin.materialManage.materialAttribute.edit', compact('material_attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialAttributeRequest $request, string $id)
    {
        $material_attribute = MaterialAttribute::findOrFail(decrypt($id));
        $material_attribute->name = $request->name;
        $material_attribute->type = $request->type;
        $material_attribute->updated_by = auth()->guard('admin')->user()->id;

        $material_attribute->update();
        session()->flash('success', 'Material Attribute updated successfully');
        return redirect()->route('am.material-attribute.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material_attribute = MaterialAttribute::findOrFail(decrypt($id));
        $material_attribute->update([
            'deleted_by' => admin()->id
        ]);
        
        $material_attribute->delete();
        session()->flash('success', 'Material Attribute deleted successfully');
        return redirect()->route('am.material-attribute.index');
    }

    public function status(string $id, string $status)
    {
        $material_attribute = MaterialAttribute::findOrFail(decrypt($id));
        $material_attribute->status = decrypt($status);
        $material_attribute->save();

        session()->flash('success', 'Material Attribute status updated successfully');
        return redirect()->route('am.material-attribute.index');
    }

    public function trash()
    {
        $material_attributes = MaterialAttribute::onlyTrashed()->get();
        return view('backend.admin.materialManage.materialAttribute.trash', compact('material_attributes'));
    }
    public function restore(string $id)
    {
        $material_attribute = MaterialAttribute::onlyTrashed()->findOrFail(decrypt($id));
        $material_attribute->restore();

        session()->flash('success', 'Material Attribute restored successfully.');
        return redirect()->route('am.material-attribute.index');
    }
    public function forceDelete(string $id)
    {
        $material_attribute = MaterialAttribute::onlyTrashed()->findOrFail(decrypt($id));
        $material_attribute->forceDelete();

        session()->flash('success', 'Material Attribute deleted permanently.');
        return redirect()->route('am.material-attribute.trash');
    }
}
