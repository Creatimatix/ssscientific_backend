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
                        <li class="breadcrumb-item active">Add > Product</li>
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
                            <h5>Product Form</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="productForm" id="productForm" action="{{ route('store.product') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <h6 class="title_in_caps" style="margin-bottom: 9px !important;">Product Information:</h6>
                                <div class="proposal-boxx--View">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name" id="productName" class="form-control fixedOption" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sku">SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control fixedOption" value="{{ old('sku') }}">
                                            @error('sku')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Brand:<span class="validateClass">*</span></label>
                                            <select name="category" id="category" class="form-control" >
                                                <option value="">Select Option</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected': '' }}>{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
{{--                                        <div class="col-md-4">--}}
{{--                                            <label for="name">SR. No.:</label>--}}
{{--                                            <input type="text" name="sr_no" id="sr_no" class="form-control fixedOption" >--}}
{{--                                        </div>--}}
                                        <div class="col-md-4">
                                            <label for="product_id">PN. No.</label>
                                            <input type="text" name="pn_no" id="pn_no" class="form-control fixedOption"  value="{{ old('pn_no') }}">
                                            @error('pn_no')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="product_id">HSN No.</label>
                                            <input type="text" name="hsn_no" id="hsn_no" class="form-control fixedOption"  value="{{ old('hsn_no') }}">
                                            @error('hsn_no')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Sale Price:<span class="validateClass">*</span></label>
                                            <input type="text" name="sale_price" class="form-control" id="salePrice"  value="{{ old('sale_price') }}">
                                            @error('sale_price')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="slug" class="form-control-label">Product URL
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-addon" id="alighaddon1">www.ssscientific.com/</span>
                                                    <?php
                                                    $readOnly = (true) ? 'readonly' : '';
                                                    ?>
                                                    <input type="text" name="slug" class="form-control" id="txtSlug" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="slug" class="form-control-label">Short Description
                                                </label>
                                                <div class="input-group">
                                                    <textarea class="form-control" name="short_description" id="short_description">{{ old('short_description') }}</textarea>
                                                </div>
                                                @error('short_description')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="slug" class="form-control-label">Description</label>
                                                <div class="input-group">
                                                    <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                                                </div>
                                                @error('description')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="product_image">Upload Image:</label>
                                            <input type="file"  class="form-control product_image" id="product_image" name="images">
                                            @error('images')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="document">Upload Document:</label>
                                            <input type="file"  class="form-control document" id="document" name="document">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Status:<span class="validateClass">*</span></label>
                                            <select name="status" id="status" class="form-control" >
                                                <option value="">Select Option</option>
                                                <option value="1" {{ old('status') == 1 ? 'selected': '' }}>Active</option>
                                                <option value="2" {{ old('status') == 2 ? 'selected': '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="gallery"></div>
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
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
