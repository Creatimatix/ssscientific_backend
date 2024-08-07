@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Purchase Order</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Purchase Order</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if($errors->any())
                                {!!
                                    implode('', $errors->all('<div class="error">:message</div>'))
                                !!}
                            @endif

                            <form name="poForm" id="poForm" action="{{ route('store.purchaseOrder') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4" style="text-align: left;">
                                            <label class="">Select Vendor<span class="validateClass">*</span></label>
                                            <select data-resource="vendor"
                                                    class="form-control"
                                                    style="width: 100%;"
                                                    name="vendor"
                                                    id="vendorUser"
                                                    data-parent="#poForm"
                                                    onchange="return getVendorDetails(this.value,1)"
                                                    required>
                                                <option value="">Select Vendor</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone_number">ATTN:</label>
                                            <input type="text" name="attn_no" id="attn_no" class="form-control fixedOption" value="{{ old('attn_no') }}" required>
                                        </div>
{{--                                        <div class="col-md-4">--}}
{{--                                            <label for="relation">Status:</label>--}}
{{--                                            <select name="status" id="status" class="form-control" required>--}}
{{--                                                <option value="">Select Option</option>--}}
{{--                                                <option value="1">Active</option>--}}
{{--                                                <option value="2">Inactive</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
                                    </div>
{{--                                    <div class="row  " style=" margin-top: 19px;">--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <label class="">Select Product</label>--}}
{{--                                            <select class="form-control select2bs4" data-resource="product" data-parent="#addVendorProduct" style="width: 100%;" name="product[]" id="ddlVendorProducts" onchange="return searchVendorProduct(this.value,1)" multiple>--}}
{{--                                                <option value="">Select Product</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="row  " style=" margin-top: 19px;">
                                        <div class="col-md-12">
                                            <label class="">Terms & Condition</label>
                                            <textarea id="summernote" name="term_n_condition"></textarea>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="width: 60em;">
                                        <div class="row">
                                            <div class="col-sm-5 nopadding">
                                                <div class="form-group">
                                                    <select class="form-control select2bs4" data-resource="product" data-parent="#addVendorProduct" style="width: 100%;" name="product[]" id="ddlVendorProducts" onchange="return searchVendorProduct(this.value,1)">
                                                        <option value="">Select Product</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 nopadding">
                                                <div class="form-group">
                                                    <input type="number " class="form-control" id="quantity" name="quantity[]" value="" placeholder="Quantity">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 nopadding">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-success" type="button" onclick="addProduct();"> <span class="fa fa-plus" aria-hidden="true"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div id="education_fields">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right customerFormBtn" id="customerFormBtn" data-type="save">Submit</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('pageScript')
    <script src="{{ asset('/js/pages/purchase_order.js') }}"></script>
    <script>
        var room = 0;
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        $('#summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
                ['view', ['fullscreen']]
            ],
            height: 200 // Set the height of the editor as needed
        })
    </script>
@endsection
