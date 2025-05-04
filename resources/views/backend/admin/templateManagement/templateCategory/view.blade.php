@extends('backend.admin.layouts.app', ['page_slug' => 'template_category'])
@section('title', 'View Tempalate Category Details')

@section('content')
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Tempalate Category Details</h4>
                    <div>
                        <a href="{{ route('am.template-category.edit', encrypt($template_category->id)) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('am.template-category.index') }}" class="btn btn-info">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>{{ __('Sort Order') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $template_category->sort_order }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Name') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $template_category->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Slug') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $template_category->slug }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Status') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>
                                    <span class="badge badge-{{ $template_category->status_bg }}">
                                        {{ $template_category->status_text }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Created At') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ timeFormat($template_category->created_at) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Created By') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $template_category->created_by_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Updated At') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ updatedDate($template_category->created_at, $template_category->updated_at) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('Updated By') }}</th>
                                <td>{{ __(' : ') }} </td>
                                <td>{{ $template_category->updated_by_name }}</td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
