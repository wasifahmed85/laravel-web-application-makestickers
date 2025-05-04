<?php

namespace App\Http\Controllers\Backend\Admin\MaterialManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialManagement\MaterialAttributeValueRequest;
use App\Models\Material;
use App\Models\MaterialAttribute;
use App\Models\MaterialAttributeValue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MaterialAttributeValueController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        
        // Define permissions for each method
        $this->middleware('permission:meterial-attribute-value-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:meterial-attribute-value-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:meterial-attribute-value-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:meterial-attribute-value-delete', ['only' => ['destroy']]);
        $this->middleware('permission:meterial-attribute-value-trash', ['only' => ['trash', 'restore']]);
        $this->middleware('permission:meterial-attribute-value-restore', ['only' => ['restore']]);
        $this->middleware('permission:meterial-attribute-value-force-delete', ['only' => ['forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $material_attribute_values = MaterialAttributeValue::with('material', 'materialAttribute')->latest()->get();

        return view('backend.admin.materialManage.materialAttributeValue.index', compact('material_attribute_values'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $data['material_attribute_values'] = MaterialAttributeValue::active()->latest()->get();
        $data['materials'] = Material::active()->latest()->get();
        $data['material_attributes'] = MaterialAttribute::active()->latest()->get();
        return view('backend.admin.materialManage.materialAttributeValue.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialAttributeValueRequest $request)
    {
        $material_attribute_value = new MaterialAttributeValue();
        $material_attribute_value->material_id = $request->material_id;
        $material_attribute_value->material_attribute_id = $request->material_attribute_id;
        $material_attribute_value->value = $request->value;
        $material_attribute_value->created_by = auth()->guard('admin')->user()->id;

        $material_attribute_value->save();
        session()->flash('success', 'Material Attribute Value created successfully');
        return redirect()->route('am.material-attribute-value.index')->with('success', 'Material Attribute Value created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material_attribute_values = MaterialAttributeValue::with('material', 'materialAttribute')->latest()->get();
        return view('backend.admin.materialManage.materialAttributeValue.view', compact('material_attribute_values'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['material_attribute_value'] = MaterialAttributeValue::findOrFail(decrypt($id));
        $data['materials'] = Material::active()->latest()->get();
        $data['material_attributes'] = MaterialAttribute::active()->latest()->get();
        return view('backend.admin.materialManage.materialAttributeValue.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialAttributeValueRequest $request, string $id)
    {
        $material_attribute_value = MaterialAttributeValue::findOrFail(decrypt($id));
        $material_attribute_value->material_id = $request->material_id;
        $material_attribute_value->material_attribute_id = $request->material_attribute_id;
        $material_attribute_value->value = $request->value;
        $material_attribute_value->updated_by = auth()->guard('admin')->user()->id;

        $material_attribute_value->update();
        session()->flash('success', 'Material Attribute Value updated successfully');
        return redirect()->route('am.material-attribute-value.index')->with('success', 'Material Attribute Value updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material_attribute_value = MaterialAttributeValue::findOrFail(decrypt($id));
        $material_attribute_value->update([
            'deleted_by' => admin()->id
        ]);

        $material_attribute_value->delete();
        session()->flash('success', 'Material Attribute Value deleted successfully');
        return redirect()->route('am.material-attribute-value.index')->with('success', 'Material Attribute Value deleted successfully');
    }

    public function status(string $id, string $status)
    {
        $material_attribute_value = MaterialAttributeValue::findOrFail(decrypt($id));
        $material_attribute_value->status = decrypt($status);
        $material_attribute_value->save();
        return redirect()->route('am.material-attribute-value.index');
    }

    public function trash()
    {
        $material_attribute_values = MaterialAttributeValue::with('material', 'materialAttribute')->onlyTrashed()->latest()->get();
        return view('backend.admin.materialManage.materialAttributeValue.trash', compact('material_attribute_values'));
    }
    public function restore(string $id)
    {
        $material_attribute_value = MaterialAttributeValue::onlyTrashed()->findOrFail(decrypt($id));
        $material_attribute_value->restore();

        session()->flash('success', 'Material Attribute Value restored successfully.');
        return redirect()->route('am.material-attribute-value.index');
    }
    public function forceDelete(string $id)
    {
        $material_attribute_value = MaterialAttributeValue::onlyTrashed()->findOrFail(decrypt($id));
        $material_attribute_value->forceDelete();

        session()->flash('success', 'Material Attribute Value deleted permanently.');
        return redirect()->route('am.material-attribute-value.index');
    }
}
