@extends('backend.admin.layouts.app', ['page_slug' => 'sticker_type_material'])
@section('title', 'Create Sticker Type Material')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card mx-auto w-50">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Create Sticker Type Material</h4>
                    <div>
                        <a href="{{ route('am.sticker-type-material.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('am.sticker-type-material.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="sticker_type_id" class="form-label">Sticker Type</label>
                                    <select name="sticker_type_id" class="form-control" id="sticker_type_id">
                                        <option value="" selected hidden>Select Sticker Type</option>
                                        @foreach ($sticker_types as $sticker_type)
                                            <option value="{{ $sticker_type->id }}" {{ old('sticker_type_id') == $sticker_type->id ? 'selected' : '' }}>{{ $sticker_type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sticker_type_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="material_id" class="form-label">Material</label>
                                    <select name="material_id" class="form-control" id="material_id">
                                        <option value="" selected hidden>Select Material</option>
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
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
