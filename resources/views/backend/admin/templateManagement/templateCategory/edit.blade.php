@extends('backend.admin.layouts.app', ['page_slug' => 'template_category'])
@section('title', 'Edit Tempalate Category')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Tempalate Category</h4>
                    <div>
                        <a href="{{ route('am.template-category.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('am.template-category.update', encrypt($template_category->id)) }}') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ $template_category->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ $template_category->slug }}">
                                    @error('slug')
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
