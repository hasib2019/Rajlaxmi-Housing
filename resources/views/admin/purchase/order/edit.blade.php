@extends('layouts.app')

<?php

$moduleName = __('root.purchase_order.purchase_order_manage');
$createItemName = __('root.common.edit') . ' ' . $moduleName;

$breadcrumbMainName = $moduleName;
$breadcrumbCurrentName = __('root.common.edit');

$breadcrumbMainIcon = 'fas fa-shopping-cart';
$breadcrumbCurrentIcon = 'archive';

$ModelName = 'App\PurchaseOrder';
$ParentRouteName = 'purchase_order';

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
            </ol>
            <!-- Inline Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{ $createItemName }}
                                <small>Put {{ $moduleName }} Information</small>
                            </h2>
                            <div class="body">
                                <form class="form" id="form_validation" method="post"
                                    action="{{ route($ParentRouteName . '.update', ['id' => $item->id]) }}">
                                    {{ csrf_field() }}
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <label class="form-label">Project Name <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-line">
                                                    <select hidden data-live-search="true" class="form-control show-tick"
                                                        name="branch_id">
                                                        <option value="0">Select Project Name</option>
                                                        @foreach ($branches as $branch)
                                                            <option
                                                                @if ($branch->id == $item->branch_id) )
                                                                    selected @endif
                                                                value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <label class="form-label">Vendor Name <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-line">
                                                    <select data-live-search="true" class="form-control show-tick"
                                                        name="vendor_id">
                                                        <option value="0">Select Vendor Name</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option @if ($vendor->id == $item->vendor_id) selected @endif
                                                                value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <label class="form-label">Media Name <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-line">
                                                    <input placeholder="Media Name " autocomplete="off" value="{{ $item->media_name }}"
                                                        name="media_name" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container">
                                                    <input autocomplete="off" value="{{ $item->issuing_date }}"
                                                        name="issuing_date" type="text" class="form-control"
                                                        placeholder=" Issuing Date *">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input autocomplete="off" value="{{ $item->contract_person_1 }}"
                                                        name="contract_person_1" type="text" class="form-control">
                                                    <label class="form-label">Contract Person 1</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input autocomplete="off" value="{{ $item->contract_person_2 }}"
                                                        name="contract_person_2" type="text" class="form-control">
                                                    <label class="form-label">Contract Person 2</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input autocomplete="off" value="{{ $item->note }}" name="note"
                                                        type="text" class="form-control">
                                                    <label class="form-label">Note</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input autocomplete="off" value="{{ $item->subject }}" name="subject"
                                                        type="text" class="form-control">
                                                    <label class="form-label">Subject <span
                                                            class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 field_area">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container">
                                                    <input autocomplete="off" value="{{ $item->date_of_delevery }}"
                                                        name="date_of_delevery" type="text" class="form-control"
                                                        placeholder=" Date of Delevery *">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <textarea class="form-control" name="message_body" id="">{{ $item->message_body }} This is an reference to your discussion had with us today, we are pleased to place an order for supplying Work order for Sylhet Sand at our project under the following terms & conditions.</textarea>
                                                    <label class="form-label">Message Body</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="card">
                                                <div class="header body">
                                                    <h5>Requisition Confirmed ID <span class="text-danger">*</span></h5>
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <select id="requisition_id" data-live-search="true"
                                                                        class="form-control show-tick"
                                                                        name="requisition_id">
                                                                        <option value="0">Select Requisition Confirmed
                                                                            ID
                                                                        </option>
                                                                        @if ($item->requisition_id)
                                                                            <option selected
                                                                                value="{{ $item->requisition_id }}">
                                                                                {{ $item->requisition_id }}
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="items" class="body">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Item</th>
                                                                        <th>Unit</th>
                                                                        <th>Description</th>
                                                                        <th>Qty.</th>
                                                                        <th>Rate ( {{ Helper::getCurrencyCode() }}
                                                                            )
                                                                        </th>
                                                                        <th>Total Price
                                                                            ( {{ Helper::getCurrencyCode() }} )
                                                                        </th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th colspan="5" class="text-right">Total Amount
                                                                        </th>
                                                                        <th>
                                                                            <span>0</span>
                                                                            <input value="0" type="hidden"
                                                                                name="totalAmount">
                                                                        </th>
                                                                        <td></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-line">
                                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">
                                                    {{ __('root.common.update') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <!-- Multi Select Css -->
    <link href="{{ asset('asset/plugins/multi-select/css/multi-select.css') }}" rel="stylesheet">
    <!-- Bootstrap Spinner Css -->
    <link href="{{ asset('asset/plugins/jquery-spinner/css/bootstrap-spinner.css') }}" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('asset/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('asset/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet" />
    <!-- Bootstrap DatePicker Css -->
    <link href="{{ asset('asset/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
@endpush

@push('include-js')
    <!-- Moment Plugin Js -->
    <script src="{{ asset('asset/plugins/momentjs/moment.js') }}"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('asset/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>
    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="{{ asset('asset/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <!-- Autosize Plugin Js -->
    <script src="{{ asset('asset/plugins/autosize/autosize.js') }}"></script>
    <script src="{{ asset('asset/js/pages/forms/basic-form-elements.js') }}"></script>
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
        var Model = (function() {
            let csrf_token = function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            };
            let branchIdGetRequisitionId = function(id) {
                csrf_token();
                let response = null;
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: "{{ route('purchase_order.branch.change') }}",
                    data: {
                        id: id
                    },
                    async: false,
                    success: function(data) {
                        response = data;
                    }
                });
                return response;
            };
            let requisitonConfirmedIdChangedGetItems = function(requisitionConfirmedId) {
                csrf_token();
                let response = null;
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    url: "{{ route('purchase_order.requisition_id.change') }}",
                    data: {
                        id: requisitionConfirmedId
                    },
                    success: function(data) {
                        if (data != null) {
                            response = data;
                        }
                    }
                });
                return response;
            };
            let purchaseOrderItemsByRequisitionID = function(requisitionID) {
                csrf_token();
                let response = null;
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    url: "{{ route('purchase_order.requisition_id') }}",
                    data: {
                        id: requisitionID
                    },
                    success: function(data) {
                        if (data != null) {
                            response = data;
                        }
                    }
                });
                return response;
            };
            return {
                loadCsrf: function() {
                    return csrf_token();
                },
                getRequisitionId: function(id) {
                    return branchIdGetRequisitionId(id);
                },
                getRequisitionConfirmedItems: function(id) {
                    return requisitonConfirmedIdChangedGetItems(id);
                },
                getItemsByPurchaseOrderId: function(id) {
                    return purchaseOrderItemsByRequisitionID(id);
                }
            };
        })();

        // Validation and calculation
        var UiController = (function() {
            var DOMString = {
                submit_form: 'form.form',
                field_area: '.field_area',
                items: 'items',
                project_id: 'select[name=branch_id]',
                requisition_id: 'select[name=requisition_id]',
                vendor_id: 'select[name=vendor_id]',
                media_name: 'input[name=media_name]',
                subject: 'input[name=subject]',
                message_body: 'textarea[name=message_body]',
                issuing_date: 'input[name=issuing_date]',
                date_of_delevery: 'input[name=date_of_delevery]',
                totalAmount: 'input[name=totalAmount]',
            };

            let emptyItem = function() {
                var item = `<tr>
                                <td class="text-center text-danger" colspan="7">No Items Found Or Please Select Requisition Confirmed ID</td>
                            </tr>`;
                return item;
            };
            let purchasedAll = function() {
                var item = `<tr>
                                <td class="text-center text-danger" colspan="7">Items Already Purchased. Select Another Requisition</td>
                            </tr>`;
                return item;
            };

            let item = function(data) {
                let unit = data.unit;
                if (unit == null) {
                    unit = '';
                }
                let description = data.description;
                if (description == null) {
                    description = '';
                }
                var item = `<tr id="${data.income_expense_head_id}">
                                <td>
                                    <input class="form-control income_expense_head_id"
                                           name="income_expense_head_id[]" type="hidden"
                                           value="${data.income_expense_head_id}">
                                    <input class="form-control"
                                           name="income_expense_head_name[]" type="hidden"
                                           value="${data.income_expense_head_name}">
                                    ${data.income_expense_head_name}
                                </td>
                                <td>
                                    ${unit}
                                    <input  name="unit[]" type="hidden" value="${unit}">
                                </td>
                                <td>
                                    <input class="form-control" type="text"
                                           value="${description}"
                                           name="description[]">
                                </td>
                                <td>
                                    <input min="1" max="${data.qntity}" class="form-control qntity" type="number"
                                           value="${data.qntity}" name="qntity[]">
                                </td>
                                <td>
                                    <input readonly class="form-control rate"
                                           type="number" value="${data.rate}" name="rate[]">
                                </td>
                                <td>
                                    <input readonly class="form-control amount"
                                           type="number" value="${data.amount}"
                                           name="amount[]">
                                </td>
                                <td>
                                    <i class="fas fa-minus btn btn-sm btn-info removeItem"></i>
                                </td>
                            </tr>`;
                return item;
            };

            let addTotalAmount = function() {
                var amount = document.querySelectorAll('.amount');
                var items = document.getElementById('items');
                var spanTag = items.querySelector('tfoot th span');
                var inputTag = items.querySelector('tfoot th input');
                var totalAmount = 0;
                for (var i = 0; i < amount.length; i++) {
                    if (amount[i].closest('tr').style.display != 'none') {
                        totalAmount += amount[i].value == '' ? 0 : parseFloat(amount[i].value);
                    }
                }
                spanTag.innerText = totalAmount;
                inputTag.value = totalAmount;
            };
            let refreshRequisitionConfirmedId = function() {
                $("#requisition_id").empty();
                let option = `<option value="0">Select Requisition Confirmed ID</option>`;
                $("#requisition_id").html(option);
                $("#requisition_id").selectpicker('refresh');
            };
            let loadRequisitionId = function(data) {
                $("#requisition_id").empty();
                let option = `<option value="0">Select Requisition Confirmed ID</option>`;
                for (var key in data) {
                    option +=
                        `<option value="${data[key].requisition_id}">${data[key].requisition_id}</option>`;
                }
                $("#requisition_id").html(option);
                $("#requisition_id").selectpicker('refresh');
            };
            return {
                getDOMString: function() {
                    return DOMString;
                },
                getFields: function() {
                    return {
                        get_form: document.querySelector(DOMString.submit_form),
                        get_project_id: document.querySelector(DOMString.project_id),
                        get_vendor_id: document.querySelector(DOMString.vendor_id),
                        get_requisition_id: document.querySelector(DOMString.requisition_id),
                        get_media_name: document.querySelector(DOMString.media_name),
                        get_subject: document.querySelector(DOMString.subject),
                        get_message_body: document.querySelector(DOMString.message_body),
                        get_issuing_date: document.querySelector(DOMString.issuing_date),
                        get_date_of_delevery: document.querySelector(DOMString.date_of_delevery),
                        get_totalAmount: document.querySelector(DOMString.totalAmount),
                        get_items: document.getElementById(DOMString.items),
                    }
                },
                getValues: function() {
                    var Fields = this.getFields();
                    return {
                        project_id: Fields.get_project_id.value == "" ? 0 : parseFloat(Fields.get_project_id
                            .value),
                        requisition_id: Fields.get_requisition_id.value == "" ? 0 : Fields.get_requisition_id
                            .value,

                        vendor_id: Fields.get_vendor_id.value == "" ? 0 : parseFloat(Fields.get_vendor_id
                            .value),
                        media_name: Fields.get_media_name.value == "" ? 0 : Fields.get_media_name.value,
                        subject: Fields.get_subject.value == "" ? 0 : Fields.get_subject.value,
                        message_body: Fields.get_message_body.value == "" ? 0 : Fields.get_message_body.value,
                        issuing_date: Fields.get_issuing_date.value == "" ? 0 : Fields.get_issuing_date.value,
                        date_of_delevery: Fields.get_date_of_delevery.value == "" ? 0 : Fields
                            .get_date_of_delevery.value,

                        totalAmount: Fields.get_totalAmount.value == "" ? 0 : parseFloat(Fields.get_totalAmount
                            .value),
                    }
                },

                createEmptyItem: function() {
                    return emptyItem();
                },
                getEmptyMsg: function() {
                    return purchasedAll();
                },
                createItem: function(data) {
                    return item(data);
                },
                getTotalAmount: function() {
                    return addTotalAmount();
                },
                refreshConfirmedId: function() {
                    return refreshRequisitionConfirmedId();
                },
                loadRequisiton: function(data) {
                    return loadRequisitionId(data);
                },
            };

        })();

        var MainController = (function(Model, UICnt) {

            var DOMString = UICnt.getDOMString();
            var Fields = UICnt.getFields();
            var setUpEventListner = function() {
                Fields.get_form.addEventListener('submit', validation);
                Fields.get_project_id.addEventListener('change', branch_changed);
                Fields.get_requisition_id.addEventListener('change', requisition_id_changed);
            };

            var afterEventListner = function() {
                // Remove items
                var RemoveItem = document.querySelectorAll('.removeItem');
                for (var i = 0; i < RemoveItem.length; i++) {
                    RemoveItem[i].addEventListener('click', removeItem)
                }
                // Change Qntity
                var qntity = document.querySelectorAll('.qntity');
                for (var i = 0; i < qntity.length; i++) {
                    qntity[i].addEventListener('keyup', changeQntity);
                }
            };

            let removeItem = function(e) {
                var tr = e.target.closest('tr');
                tr.style.display = 'none';
                var incomeExpenseHead = tr.querySelector('.income_expense_head_id');
                incomeExpenseHead.value = 0;
                UICnt.getTotalAmount();
            };

            let changeQntity = function(e) {
                var changeValue = e.target.value == '' ? 0 : parseFloat(e.target.value);
                var rate = parseFloat(e.target.closest('tr').querySelector('.rate').value);
                var amount = e.target.closest('tr').querySelector('.amount');
                var maxValue = e.target.max;
                if (maxValue < changeValue) {
                    e.target.value = maxValue;
                    amount.value = maxValue * rate;
                    toastr["error"](`You can not put more than ${maxValue}`);
                } else if (changeValue <= 0) {
                    e.target.value = 1;
                    amount.value = 1 * rate;
                    toastr["error"](`You can not put less than 1`);
                } else {
                    var amount = e.target.closest('tr').querySelector('.amount');
                    // update new amount
                    amount.value = changeValue * rate;
                }
                UICnt.getTotalAmount();
            };

            let branch_changed = function(e) {
                let branch_id = parseFloat(e.target.value);
                // Refresh Items
                var item_tbody = Fields.get_items.querySelector('tbody');
                item_tbody.innerHTML = UICnt.createEmptyItem();
                if (branch_id == 0) {
                    return 0;
                }
                // Empty Requisition Id Field and refresh
                UiController.refreshConfirmedId();
                var requisitonID = Model.getRequisitionId(branch_id);
                if (requisitonID.length != 0) {
                    UiController.loadRequisiton(requisitonID);
                }
            };
            let setItems = function(requisition_id) {
                var items = Fields.get_items;
                var item_tbody = items.querySelector('tbody');
                var allitems = Model.getRequisitionConfirmedItems(requisition_id);
                var puchaseOrder = Model.getItemsByPurchaseOrderId(requisition_id);
                var createdItems = '';
                var allItemOrdered = false;
                for (var [key, value] of Object.entries(allitems)) {
                    if (puchaseOrder.length == 0) {
                        createdItems += UICnt.createItem(value);
                        allItemOrdered = true;
                    } else {
                        var hasItem = false;
                        var purhcaseOrderIndex = '';
                        for (var [index, item] of Object.entries(puchaseOrder)) {
                            if (value.income_expense_head_id == item.income_expense_head_id) {
                                hasItem = true;
                                purhcaseOrderIndex = index;
                                break;
                            }
                        }
                        if (hasItem) {
                            if (value.qntity != puchaseOrder[purhcaseOrderIndex].qntity) {
                                value.qntity = value.qntity - puchaseOrder[purhcaseOrderIndex].qntity;
                                value.amount = value.amount - puchaseOrder[purhcaseOrderIndex].amount;

                                createdItems += UICnt.createItem(value);
                                allItemOrdered = true;
                            }

                        } else {
                            createdItems += UICnt.createItem(value);
                            allItemOrdered = true;
                        }
                    }
                }
                if (!allItemOrdered) {
                    item_tbody.innerHTML = UICnt.getEmptyMsg();
                }
                if (createdItems != '') {
                    item_tbody.innerHTML = createdItems;
                    afterEventListner();
                }
                UICnt.getTotalAmount();
            };
            let requisition_id_changed = function(e) {
                let requisition_id = e.target.value;
                var items = Fields.get_items;
                var item_tbody = items.querySelector('tbody');
                item_tbody.innerHTML = UICnt.createEmptyItem();
                if (requisition_id == 0) {
                    item_tbody.innerHTML = UICnt.createEmptyItem();
                    UICnt.getTotalAmount();
                    return 0;
                }
                setItems(requisition_id);
            };

            var validation = function(e) {
                var Values, Fields;
                Values = UICnt.getValues();
                Fields = UICnt.getFields();
                if (Values.project_id == 0) {
                    toastr["error"]('Select  Project Name');
                    e.preventDefault();
                }
                if (Values.vendor_id == 0) {
                    toastr["error"]('Select  Vendor Name');
                    e.preventDefault();
                }
                if (Values.media_name == 0) {
                    toastr["error"]('Set Media Name');
                    e.preventDefault();
                }
                if (Values.issuing_date == 0) {
                    toastr["error"]('Issuing date is required');
                    e.preventDefault();
                }
                if (Values.subject == 0) {
                    toastr["error"]('Subject is required');
                    e.preventDefault();
                }
                if (Values.date_of_delevery == 0) {
                    toastr["error"]('Date of delevery is required');
                    e.preventDefault();
                }
                if (Values.message_body == 0) {
                    toastr["error"]('Message body is required');
                    e.preventDefault();
                }
                if (Values.requisition_id == 0) {
                    toastr["error"]('Select Requisiton Confirmed Id');
                    e.preventDefault();
                }
                if (Values.totalAmount == 0) {
                    toastr["error"]('Add at lest one quantity of item');
                    e.preventDefault();
                }
            };
            return {
                init: function() {
                    setUpEventListner();
                    var itemsDom = Fields.get_items;
                    var item_tbody = itemsDom.querySelector('tbody');
                    var items = <?php echo $item->item; ?>;
                    var createdItems = '';
                    for (var [key, value] of Object.entries(items.items)) {
                        createdItems += UICnt.createItem(value);
                    }
                    item_tbody.innerHTML = createdItems;
                    UICnt.getTotalAmount();
                    if (createdItems != '') {
                        afterEventListner();
                    }
                }
            }
        })(Model, UiController);
        MainController.init();
    </script>
@endpush
