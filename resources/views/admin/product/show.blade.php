@extends('layouts.app')

{{--Important Variables--}}

<?php


$moduleName = __('root.product.product_manage');
$createItemName = "show" . $moduleName;

$breadcrumbMainName = $moduleName;
$breadcrumbCurrentName = " show";

$breadcrumbMainIcon = "fas fa-boxes";
$breadcrumbCurrentIcon = "archive";

$ModelName = 'App\Product';
$ParentRouteName = 'product';



$curency_symble=(config('settings.is_code') == 'code') ? config('settings.currency_code') : config('settings.currency_symbol');

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
                <li><a href="{{ route($ParentRouteName) }}"><i class="material-icons">home</i>
                        {{ __('root.common.home') }}</a></li>
                <li><a href="{{ route($ParentRouteName) }}"><i class="{{ $breadcrumbMainIcon }}"></i>
                        &nbsp;{{ $breadcrumbMainName }}</a>
                </li>
                <li class="active"><i class="material-icons">{{ $breadcrumbCurrentIcon }}</i>&nbsp;
                    {{ $breadcrumbCurrentName }}
                </li>
            </ol>            <!-- Inline Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                   
                                        <table class="table  table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Product Unique ID</td>
                                                    <td>{{ $items->product_unique_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Project Name</td>
                                                    <td>{{ App\Product::find($items->id)->branch->name }}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Flat Type</td>
                                                    <td>{{ $items->flat_type }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Floor Number</td>
                                                    <td>{{ $items->floor_number }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Flat Size</td>
                                                    <td>{{ $items->flat_size }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Unite Price ( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->unite_price) }}</td>
                                                </tr>

                                                <tr class="text-bold">
                                                    <td>Total Flat Price( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->total_flat_price) }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Car Parking Charge( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->car_parking_charge) }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Utility Charge( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->utility_charge) }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Additional Work Charge( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->additional_work_charge) }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Other Charge( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->other_charge) }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Discount Or Deduction( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->discount_or_deduction) }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Refund Additional Work Charge( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->refund_additional_work_charge) }}</td>
                                                </tr>

                                                <tr class="text-bold">
                                                    <td>Net Sells Price( {{ $curency_symble }} ) </td>
                                                    <td>{{ $transaction->convert_money_format($items->net_sells_price) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Description</td>
                                                    <td>{{ $items->description }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Product Image</td>
                                                <td><img width="50" height="50" src="{{ asset($items->product_img) }}" alt=""></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Inline Layout | With Floating Label -->
            </div>
        </div>
    </section>

@stop

@push('include-css')

    <!-- Colorpicker Css -->
    <link href="{{ asset('asset/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}" rel="stylesheet"/>

    <!-- Dropzone Css -->
    <link href="{{ asset('asset/plugins/dropzone/dropzone.css') }}" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="{{ asset('asset/plugins/multi-select/css/multi-select.css') }}" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="{{ asset('asset/plugins/jquery-spinner/css/bootstrap-spinner.css') }}" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="{{ asset('asset/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('asset/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/>



    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('asset/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
          rel="stylesheet"/>

    <!-- Bootstrap DatePicker Css -->
    <link href="{{ asset('asset/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet"/>


    <!-- noUISlider Css -->
    <link href="{{ asset('asset/plugins/nouislider/nouislider.min.css') }}" rel="stylesheet"/>

    <!-- Sweet Alert Css -->
    <link href="{{ asset('asset/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"/>


@endpush

@push('include-js')


    <!-- Moment Plugin Js -->
    <script src="{{ asset('asset/plugins/momentjs/moment.js') }}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('asset/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="{{ asset('asset/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>


    <!-- Sweet Alert Plugin Js -->
    <script src="{{ asset('asset/plugins/sweetalert/sweetalert.min.js') }}"></script>


    <!-- Autosize Plugin Js -->
    <script src="{{ asset('asset/plugins/autosize/autosize.js') }}"></script>

    <script src="{{ asset('asset/js/pages/forms/basic-form-elements.js') }}"></script>



@endpush

