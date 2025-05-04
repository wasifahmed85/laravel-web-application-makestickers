<?php

namespace App\Http\Controllers\Backend\Admin\MaterialManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialManagement\StickerTypeMaterialRequest;
use App\Models\Material;
use App\Models\StickerType;
use App\Models\StickerTypeMaterial;
use Illuminate\Http\Request;

class StickerTypeMaterialController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        
        // Define permissions for each method
        $this->middleware('permission:sticker-type-material-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:sticker-type-material-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sticker-type-material-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:sticker-type-material-delete', ['only' => ['destroy']]);
        $this->middleware('permission:sticker-type-material-trash', ['only' => ['trash', 'restore']]);
        $this->middleware('permission:sticker-type-material-restore', ['only' => ['restore']]);
        $this->middleware('permission:sticker-type-material-force-delete', ['only' => ['forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sticker_type_materials = StickerTypeMaterial::with('stickerType', 'material')->get();
        return view('backend.admin.materialManage.stickerTypeMaterial.index', compact('sticker_type_materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['sticker_types'] = StickerType::active()->get();
        $data['materials'] = Material::active()->get();
        return view('backend.admin.materialManage.stickerTypeMaterial.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StickerTypeMaterialRequest $request)
    {
        $sticker_type_material = new StickerTypeMaterial();
        $sticker_type_material->sticker_type_id = $request->sticker_type_id;
        $sticker_type_material->material_id = $request->material_id;
        $sticker_type_material->created_by = auth()->guard('admin')->user()->id;

        $sticker_type_material->save();
        session()->flash('success', 'Sticker Type Material created successfully');
        return redirect()->route('am.sticker-type-material.index')->with('success', 'Sticker Type Material created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['sticker_type_material'] = StickerTypeMaterial::findOrFail(decrypt($id));
        $data['sticker_types'] = StickerType::active()->get();
        $data['materials'] = Material::active()->get();
        return view('backend.admin.materialManage.stickerTypeMaterial.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['sticker_type_material'] = StickerTypeMaterial::findOrFail(decrypt($id));
        $data['sticker_types'] = StickerType::active()->get();
        $data['materials'] = Material::active()->get();
        return view('backend.admin.materialManage.stickerTypeMaterial.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StickerTypeMaterialRequest $request, string $id)
    {
        $sticker_type_material = StickerTypeMaterial::findOrFail(decrypt($id));
        $sticker_type_material->sticker_type_id = $request->sticker_type_id;
        $sticker_type_material->material_id = $request->material_id;
        $sticker_type_material->updated_by = auth()->guard('admin')->user()->id;

        $sticker_type_material->save();
        session()->flash('success', 'Sticker Type Material updated successfully');
        return redirect()->route('am.sticker-type-material.index')->with('success', 'Sticker Type Material updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sticker_type_material = StickerTypeMaterial::findOrFail(decrypt($id));
        $sticker_type_material->update([
            'deleted_by' => admin()->id
        ]);

        $sticker_type_material->delete();
        session()->flash('success', 'Sticker Type Material deleted successfully');
        return redirect()->route('am.sticker-type-material.index')->with('success', 'Sticker Type Material deleted successfully');
    }

    public function status(string $id, string $status)
    {
        //
    }

    public function trash()
    {
        $sticker_type_materials = StickerTypeMaterial::with('stickerType', 'material')->onlyTrashed()->get();
        return view('backend.admin.materialManage.stickerTypeMaterial.trash', compact('sticker_type_materials'));
    }
    public function restore(string $id)
    {
        $sticker_type_material = StickerTypeMaterial::withTrashed()->findOrFail(decrypt($id));
        $sticker_type_material->restore();
        session()->flash('success', 'Sticker Type Material restored successfully');
        return redirect()->route('am.sticker-type-material.index')->with('success', 'Sticker Type Material restored successfully');
    }
    public function forceDelete(string $id)
    {
        $sticker_type_material = StickerTypeMaterial::withTrashed()->findOrFail(decrypt($id));
        $sticker_type_material->forceDelete();
        session()->flash('success', 'Sticker Type Material force deleted successfully');
        return redirect()->route('am.sticker-type-material.index')->with('success', 'Sticker Type Material force deleted successfully');
    }
}
