@extends('layouts.app')
@section('title', __('lang.manufacturers'))

@section('content')
<div class="container-fluid">

    <div class="col-md-12  no-print">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="print-title">@lang('lang.manufacturers_list')</h4>
            </div>
            <div class="card-header d-flex align-items-center">
{{--                    TODO add permissions--}}
{{--                @can('product_module.product_class.create_and_edit')--}}
                <a style="color: white" data-href="{{action('ManufacturerController@create')}}"
                    data-container=".view_modal" class="btn btn-modal btn-info"><i class="dripicons-plus"></i>
                    @lang('lang.add_manufacturer')</a>
{{--                @endcan--}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="category_table" class="table dataTable">
                        <thead>
                            <tr>
                                <th>@lang('lang.name')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($manufacturers as $manufacturer)
                            <tr>
                                <td>{{$manufacturer->name}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">@lang('lang.action')
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                            user="menu">
{{--                                            @can('product_module.category.create_and_edit')--}}
                                            <li>

                                                <a data-href="{{action('ManufacturerController@edit', $manufacturer->id)}}"
                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                        class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                            </li>
                                            <li class="divider"></li>
{{--                                            @endcan--}}
{{--                                            @can('product_module.category.delete')--}}
                                            <li>
                                                <a data-href="{{action('ManufacturerController@destroy', $manufacturer->id)}}"
                                                    data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                    class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                    @lang('lang.delete')</a>
                                            </li>
{{--                                            @endcan--}}
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection
