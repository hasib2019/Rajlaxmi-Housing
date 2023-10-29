@extends('layouts.app')


{{-- Important Variables --}}

<?php

$moduleName = __('root.product.product_manage');
$createItemName = __('root.common.trash') . $moduleName;

$breadcrumbMainName = $moduleName;
$breadcrumbCurrentName = __('root.common.trash');

$breadcrumbMainIcon = 'fas fa-boxes';
$breadcrumbCurrentIcon = 'archive';

$ModelName = 'App\Product';
$ParentRouteName = 'product';

$all = config('role_manage.Product.All');
$create = config('role_manage.Product.Create');
$delete = config('role_manage.Product.Delete');
$edit = config('role_manage.Product.Edit');
$pdf = config('role_manage.Product.Pdf');
$permanently_delete = config('role_manage.Product.PermanentlyDelete');
$restore = config('role_manage.Product.Restore');
$show = config('role_manage.Product.Show');
$trash_show = config('role_manage.Product.TrashShow');

$curency_symble = config('settings.is_code') == 'code' ? config('settings.currency_code') : config('settings.currency_symbol');

$transaction = new \App\Transaction();

?>
@section('title')
    {{ $moduleName }}->{{ $createItemName }}
@stop

@section('top-bar')
    @include('includes.top-bar')
@stop
@section('left-sidebar')
    @include('includes.left-sidebar')
@stop
@section('content')
    <section @if ($is_rtl) dir="rtl" @endif class="content">
        <div class="container-fluid">
            <div class="block-header @if ($is_rtl) pull-right @else pull-left @endif">
                <a class="btn btn-sm btn-info waves-effect" href="{{ url()->previous() }}">{{ __('root.common.back') }}</a>
            </div>
            <ol class="breadcrumb breadcrumb-col-cyan @if ($is_rtl) pull-left  @else pull-right @endif">
                <li><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> {{ __('root.common.home') }}</a>
                </li>
                <li><a href="{{ route($ParentRouteName) }}"><i class="{{ $breadcrumbMainIcon }}"></i>
                        &nbsp;{{ $breadcrumbMainName }}</a></li>
                <li class="active"><i class="material-icons">{{ $breadcrumbCurrentIcon }}</i>&nbsp;
                    {{ $breadcrumbCurrentName }}
                </li>
            </ol>
            <!-- Hover Rows -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <a class="btn btn-xs btn-success waves-effect text-black"
                                href="{{ route($ParentRouteName) }}">{{ __('root.common.all') }}
                                ({{ $total_products }})</a>
                            <a class="btn btn-xs btn-danger waves-effect"
                                href="{{ route($ParentRouteName) }}">{{ __('root.common.trash') }}
                                ({{ $total_trashed_products }})
                            </a>
                            <ul class="header-dropdown m-r--5">
                                <form class="search" action="{{ route($ParentRouteName . '.trashed.search') }}"
                                    method="get">
                                    {{ csrf_field() }}
                                    <input type="search" name="search" class="form-control input-sm "
                                        placeholder="{{ __('root.common.search') }}" />
                                </form>
                            </ul>
                        </div>
                        <form class="actionForm" action="{{ route($ParentRouteName . '.trashed.action') }}" method="get">
                            <div class="pagination-and-action-area body">
                                <div>
                                    <div class="select-and-apply-area">
                                        <div class="form-group width-300">
                                            <div class="form-line">
                                                <select class="form-control" name="apply_comand_top" id="">
                                                    <option value="0">{{ __('root.common.select_action') }}</option>
                                                    @if ($restore == 1)
                                                        <option value="1">{{ __('root.common.restore') }}</option>
                                                    @endif
                                                    @if ($permanently_delete == 1)
                                                        <option value="2">{{ __('root.common.permanently_delete') }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input class="btn btn-sm btn-info waves-effect" type="submit"
                                                value="{{ __('root.common.apply') }}" name="ApplyTop">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="custom-paginate">
                                        {{ $items->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="body table-responsive w-full">
                                {{ csrf_field() }}
                                @if (count($items) > 0)
                                    <table class="table table-hover table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th class="checkbox_custom_style text-center width-100">
                                                    <input name="selectTop" type="checkbox" id="md_checkbox_p"
                                                        class="chk-col-cyan" />
                                                    <label for="md_checkbox_p"></label>
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.unique_id_details') }}">
                                                    {{ __('root.product.unique_id') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.name_details') }}">
                                                    {{ __('root.product.name') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.size_details') }}">
                                                    {{ __('root.product.size') }}</th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.price_details') }} ( {{ $curency_symble }} )">
                                                    {{ __('root.product.price') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.total_details') }} ( {{ $curency_symble }} )">
                                                    {{ __('root.product.total') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.parking_details') }} ( {{ $curency_symble }} )">
                                                    {{ __('root.product.parking') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.utility_details') }} ( {{ $curency_symble }} ) ">
                                                    {{ __('root.product.utility') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.additional_details') }} ( {{ $curency_symble }} )">
                                                    {{ __('root.product.additional') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.other_details') }} ( {{ $curency_symble }} ) ">
                                                    {{ __('root.product.other') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.deduction_details') }} ( {{ $curency_symble }} )">
                                                    {{ __('root.product.deduction') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.refund_details') }} ( {{ $curency_symble }} )">
                                                    {{ __('root.product.refund') }}
                                                </th>
                                                <th data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('root.product.price_details') }} ( {{ $curency_symble }} )">
                                                    {{ __('root.product.price') }}
                                                </th>
                                                <th class="width-100 text-center">{{ __('root.product.options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <th class="text-center">
                                                        <input name="items[id][]" value="{{ $item->id }}"
                                                            type="checkbox" id="md_checkbox_{{ $i }}"
                                                            class="chk-col-cyan selects " />
                                                        <label for="md_checkbox_{{ $i }}"></label>
                                                    </th>
                                                    <td>{{ $item->product_unique_id }}</td>
                                                    <td>{{ $item->branch->name }}
                                                    </td>
                                                    <td>{{ $item->flat_size }}</td>
                                                    <td>{{ Helper::convertMoneyFormat($item->unite_price) }} </td>
                                                    <td class="text-bold">
                                                        {{ Helper::convertMoneyFormat($item->total_flat_price) }}
                                                    </td>
                                                    <td>{{ Helper::convertMoneyFormat($item->car_parking_charge) }}
                                                    </td>
                                                    <td>{{ Helper::convertMoneyFormat($item->utility_charge) }}
                                                    </td>
                                                    <td>{{ Helper::convertMoneyFormat($item->additional_work_charge) }}
                                                    </td>
                                                    <td>{{ Helper::convertMoneyFormat($item->other_charge) }}</td>
                                                    <td>{{ Helper::convertMoneyFormat($item->discount_or_deduction) }}
                                                    </td>
                                                    <td>{{ Helper::convertMoneyFormat($item->refund_additional_work_charge) }}
                                                    </td>
                                                    <td class="text-bold">
                                                        {{ Helper::convertMoneyFormat($item->net_sells_price) }}
                                                    </td>
                                                    <td class="tdAction text-center">
                                                        <a @if ($restore == 0) class="dis-none" @endif
                                                            class="btn btn-xs btn-info waves-effect m-b-3"
                                                            href="{{ route($ParentRouteName . '.restore', ['id' => $item->id]) }}"
                                                            data-toggle="tooltip" data-placement="top" title="Restore"><i
                                                                class="material-icons">restore</i></a>
                                                        <a data-target="#largeModal"
                                                            class="btn btn-xs btn-success waves-effect ajaxCall dis-none m-b-3"
                                                            href="#" data-toggle="tooltip" data-placement="top"
                                                            title="Preview"><i class="material-icons">pageview</i></a>
                                                        <a @if ($permanently_delete == 0) class="dis-none" @endif
                                                            class="btn btn-xs btn-danger waves-effect m-b-3"
                                                            href="{{ route($ParentRouteName . '.kill', ['id' => $item->id]) }}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Parmanently Delete?"> <i
                                                                class="material-icons">delete</i></a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            <thead>
                                                <tr>
                                                    <th class="checkbox_custom_style text-center">
                                                        <input name="selectBottom" type="checkbox"
                                                            id="md_checkbox_footer" class="chk-col-cyan" />
                                                        <label for="md_checkbox_footer"></label>
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.unique_id_details') }}">
                                                        {{ __('root.product.unique_id') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.name_details') }}">
                                                        {{ __('root.product.name') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.size_details') }}">
                                                        {{ __('root.product.size') }}</th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.price_details') }} ( {{ $curency_symble }} )">
                                                        {{ __('root.product.price') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.total_details') }} ( {{ $curency_symble }} )">
                                                        {{ __('root.product.total') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.parking_details') }} ( {{ $curency_symble }} )">
                                                        {{ __('root.product.parking') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.utility_details') }} ( {{ $curency_symble }} ) ">
                                                        {{ __('root.product.utility') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.additional_details') }} ( {{ $curency_symble }} )">
                                                        {{ __('root.product.additional') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.other_details') }} ( {{ $curency_symble }} ) ">
                                                        {{ __('root.product.other') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.deduction_details') }} ( {{ $curency_symble }} )">
                                                        {{ __('root.product.deduction') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.refund_details') }} ( {{ $curency_symble }} )">
                                                        {{ __('root.product.refund') }}
                                                    </th>
                                                    <th data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('root.product.price_details') }} ( {{ $curency_symble }} )">
                                                        {{ __('root.product.price') }}
                                                    </th>
                                                    <th class="width-100 text-center">{{ __('root.product.options') }}</th>
                                                </tr>
                                            </thead>
                                        </tbody>
                                    </table>
                                @else
                                    <div class="body">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-danger text-center">
                                                        {{ __('root.common.no_data_found') }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            <div class="pagination-and-action-area body">
                                <div>
                                    <div class="select-and-apply-area">
                                        <div class="form-group width-300">
                                            <div class="form-line">
                                                <select class="form-control" name="apply_comand_bottom" id="">
                                                    <option value="0">{{ __('root.common.select_action') }}</option>
                                                    @if ($restore == 1)
                                                        <option value="1">{{ __('root.common.restore') }}</option>
                                                    @endif
                                                    @if ($permanently_delete == 1)
                                                        <option value="2">{{ __('root.common.permanently_delete') }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input class="btn btn-sm btn-info waves-effect" type="submit"
                                                value="{{ __('root.common.apply') }}" name="ApplyTop">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="custom-paginate">
                                        {{ $items->links() }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- #END# Hover Rows -->
        </div>
    </section>

@stop

@push('include-css')
    <!-- Wait Me Css -->
    <link href="{{ asset('asset/plugins/waitme/waitMe.css') }}" rel="stylesheet" />

    <!-- Colorpicker Css -->
    <link href="{{ asset('asset/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="{{ asset('asset/plugins/dropzone/dropzone.css') }}" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="{{ asset('asset/plugins/multi-select/css/multi-select.css') }}" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="{{ asset('asset/plugins/jquery-spinner/css/bootstrap-spinner.css') }}" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="{{ asset('asset/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('asset/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@push('include-js')
    {{-- <script src="{{ asset('asset/js/pages/ui/modals.js') }}"></script> --}}
    <script src="{{ asset('asset/plugins/autosize/autosize.js') }}"></script>

    <!-- Moment Plugin Js -->
    <script src="{{ asset('asset/plugins/momentjs/moment.js') }}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('asset/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>

    <script src="{{ asset('asset/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    <script src="{{ asset('asset/js/pages/forms/basic-form-elements.js') }}"></script>
    <!-- Autosize Plugin Js -->


    <script>
        @if (Session::has('success'))
            toastr["success"]('{{ Session::get('success') }}');
        @endif

        @if (Session::has('error'))
            toastr["error"]('{{ Session::get('error') }}');
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr["error"]('{{ $error }}');
            @endforeach
        @endif
    </script>

    {{-- All datagrid --}}
    <script src="{{ asset('asset/js/dataTable.js') }}"></script>
    <script>
        BaseController.init();
    </script>
@endpush
