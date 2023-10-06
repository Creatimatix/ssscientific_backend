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
                        <li class="breadcrumb-item active">Edit > Accessories</li>
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
                            <h5>Accessories Form</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="productForm" id="productForm" action="{{ route('update.product') }}" method="POST" autocomplete="off"  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="{{ $accessory->type }}">
                                <input type="hidden" name="id_product" value="{{ $accessory->id }}">
                                <h6 class="title_in_caps" style="margin-bottom: 9px !important;">Product Information:</h6>
                                <div class="proposal-boxx--View">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name" id="productName" value="{{ $accessory->name }}" class="form-control fixedOption" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="product_id">SKU</label>
                                            <input type="text" name="sku" id="sku" value="{{ $accessory->sku }}"  class="form-control fixedOption" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Brand:<span class="validateClass">*</span></label>
                                            <select name="category" id="category" class="form-control" required>
                                                <option value="">Select Option</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $category->id == $accessory->id_category?'selected':'' }}>{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="product_id">PN. No.</label>
                                            <input type="text" name="pn_no" value="{{ $accessory->pn_no }}" id="pn_no" class="form-control fixedOption" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="product_id">HSN No.</label>
                                            <input type="text" name="hsn_no" value="{{ $accessory->hsn_no }}" id="hsn_no" class="form-control fixedOption" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Sale Price:<span class="validateClass">*</span></label>
                                            <input type="text" name="sale_price" class="form-control" id="salePrice" value="{{ $accessory->sale_price }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="slug" class="form-control-label">Short Description
                                                </label>
                                                <div class="input-group">
                                                    <textarea class="form-control" name="short_description" id="short_description">{{ $accessory->short_description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="slug" class="form-control-label"> Description</label>
                                                <div class="input-group">
                                                    <textarea class="form-control" name="description" id="description">{{ $accessory->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label for="relation">Status:<span class="validateClass">*</span></label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="1" {{ $accessory->status == 1?'selected':'' }}>Active</option>
                                                <option value="2" {{ $accessory->status == 2?'selected':'' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 21px;margin-left: 2px;">
                                        <button type="submit" class="btn btn-primary pull-right customerFormBtn" id="customerFormBtn" data-type="save">Submit</button>
                                    </div>
                                </div>
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
    <script src="{{ asset('/js/pages/product.js') }}"></script>
    <script>
        var productSuccessMsg = "{{ session('productSuccessMsg') }}";
        var productErrorMsg = "{{ session('productErrorMsg') }}";
        //
        // if(productSuccessMsg){
        //     messages.saved("Product", productSuccessMsg);
        // }
        // if(productErrorMsg){
        //     messages.error("Product", productErrorMsg);
        // }

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
