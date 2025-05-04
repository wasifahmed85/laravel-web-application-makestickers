@extends('backend.admin.layouts.app', ['page_slug' => 'sticker_type_material'])
@section('title', 'View Sticker Type Material')

@section('content')
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Sticker Type Material Details</h4>
                    <div>
                        <a href="{{ route('am.sticker-type-material.edit', encrypt($sticker_type_material->id)) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('am.sticker-type-material.index') }}" class="btn btn-info">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>{{ __('Sort Order') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $sticker_type_material->sort_order }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Sticker Type') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $sticker_type_material->stickerType->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Material') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $sticker_type_material->material->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Created At') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ timeFormat($sticker_type_material->created_at) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Created By') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $sticker_type_material->created_by_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Updated At') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ updatedDate($sticker_type_material->created_at, $sticker_type_material->updated_at) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Updated By') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $sticker_type_material->updated_by_name }}</td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
