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
                            <h5>Edit {{ $model->po_no }}</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="poForm" id="poForm" action="{{ route('update.purchaseOrder',['purchaseOrder' => $model->id]) }}" method="POST" autocomplete="off">
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
                                                @if(isset($model->vendor))
                                                    <option value="{{$model->vendor->id}}"
                                                            selected>{{$model->vendor->company_name}}
                                                        ({{$model->vendor->email}})
                                                    </option>
                                                @endif
                                            </select>
                                            @error('vendor')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone_number">ATTN:</label>
                                            <input type="text" name="attn_no" id="attn_no" value="{{ $model->attn_no }}" class="form-control fixedOption">
                                            @error('attn_no')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Status:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="1" {{ $model->status ==  1?'selected': '' }}>Active</option>
                                                <option value="2" {{ $model->status ==  2?'selected': '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
{{--                                    <div class="row  " style=" margin-top: 19px;">--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <label class="">Select Product</label>--}}
{{--                                            <select class="form-control select2bs4" data-resource="product" data-parent="#addVendorProduct" style="width: 100%;" name="product[]" id="ddlVendorProducts" onchange="return searchVendorProduct(this.value,1)" multiple>--}}
{{--                                                <option value="">Select Product</option>--}}
{{--                                                @if(isset($model->products))--}}
{{--                                                    @foreach($model->products as $product)--}}
{{--                                                        <option value="{{$product->product->id}}"--}}
{{--                                                                selected>{{$product->product->name}}--}}
{{--                                                        </option>--}}
{{--                                                    @endforeach--}}
{{--                                                @endif--}}
{{--                                            </select>--}}
{{--                                            @error('product')--}}
{{--                                            <div class="error">{{ $message }}</div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="row " style=" margin-top: 19px;">
                                        <div class="col-md-12">
                                            <label class="">Terms & Condition</label>
                                            <textarea id="summernote" name="term_n_condition">{{ $model->terms_n_condition }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="panel panel-default" style="margin-top: 20px; margin-left: 10px;">
                                            <div class="panel-heading">
                                                <label for="relation">Product Accessories</label>
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
                                                <div id="education_fields"></div>
                                                @if($model->products)
                                                    @php
                                                        $totalProducts = $model->products->count();
                                                    @endphp
                                                    @foreach($model->products as $key => $product)
                                                        <div class="row removeclass{{ $key  }}">
                                                            <div class="col-sm-5 nopadding">
                                                                <div class="form-group">
                                                                    <select class="form-control select2bs4" data-resource="product" data-parent="#addVendorProduct" style="width: 100%;" name="product[]" id="ddlVendorProducts" onchange="return searchVendorProduct(this.value,1)">
                                                                        <option value="{{$product->product->id}}"
                                                                   selected>{{$product->product->name}} </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 nopadding">
                                                                    <div class="form-group">
                                                                        <input type="number " class="form-control" id="quantity" name="quantity[]" value="{{ $product->quantity }}" placeholder="Quantity">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 nopadding">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-btn">
                                                                            <button
                                                                                class="btn btn-danger" type="button" onclick="remove_product({{ $key++ }});">
                                                                                <span class="fa fa-minus" aria-hidden="true"></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <div class="clear"></div>
                                                        @endforeach
                                                    @endif
                                                </div>
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
            var room = "{{ $totalProducts }}";
            var poSuccessMsg = "{{ session('poSuccessMsg') }}";
            var poErrorMsg = "{{ session('poErrorMsg') }}";
            if(poSuccessMsg){
                messages.saved("Purchase Order", poSuccessMsg);
            }
            if(poErrorMsg){
                messages.error("Purchase Order", poErrorMsg);
            }
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
