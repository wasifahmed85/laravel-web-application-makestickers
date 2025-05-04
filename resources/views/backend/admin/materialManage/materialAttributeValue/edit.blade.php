@extends('backend.admin.layouts.app', ['page_slug' => 'material_attribute_value'])
@section('title', 'Edit Material Attribute Value')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Matarial Attribute Value</h4>
                    <div>
                        <a href="{{ route('am.material-attribute.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('am.material-attribute-value.update', encrypt($material_attribute_value->id)) }}') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="material_id" class="form-label">Material</label>
                                    <select name="material_id" class="form-control" id="material_id">
                                        <option value="{{ $material_attribute_value->material_id }}" selected hidden>{{ optional($material_attribute_value->material)->name }}</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material->id }}" {{ old('material_id') == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('material_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="material_attribute_id" class="form-label">Material Attribute</label>
                                    <select name="material_attribute_id" class="form-control" id="material_attribute_id">
                                        <option value="{{ $material_attribute_value->material_attribute_id }}" selected hidden>{{ optional($material_attribute_value->materialAttribute)->name }}</option>
                                        @foreach ($material_attributes as $material_attribute)
                                            <option value="{{ $material_attribute->id }}" {{ old('material_attribute_id') == $material_attribute->id ? 'selected' : '' }}>{{ $material_attribute->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('material_attribute_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="value" class="form-label">Value</label>
                                    <input type="text" class="form-control @error('value') is-invalid @enderror"
                                        id="value" name="value" value="{{ $material_attribute_value->value }}">
                                    @error('value')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
