@php
    $totalAccessories = 0;
@endphp
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
                        <li class="breadcrumb-item active">Edit > Product</li>
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
                            <form name="productForm" id="productForm" action="{{ route('update.product') }}" method="POST" autocomplete="off"  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_product" value="{{ $product->id }}">
                                <h6 class="title_in_caps" style="margin-bottom: 9px !important;">Product Information:</h6>
                                <div class="proposal-boxx--View">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name">Model No:</label>
                                            <input type="text" name="name" id="productName" value="{{ $product->name }}" class="form-control fixedOption">
                                            @error('name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
{{--                                        <div class="col-md-4">--}}
{{--                                            <label for="product_id">SKU</label>--}}
{{--                                            <input type="text" name="sku" id="sku" value="{{ $product->sku }}"  class="form-control fixedOption">--}}
{{--                                            @error('sku')--}}
{{--                                            <div class="error">{{ $message }}</div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
                                        <div class="col-md-4">
                                            <label for="relation">Brand:<span class="validateClass">*</span></label>
                                            <select name="category" id="category" class="form-control" required>
                                                <option value="">Select Option</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $category->id == $product->id_category?'selected':'' }}>{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
{{--                                        <div class="col-md-4">--}}
{{--                                            <label for="name">SR. No.:</label>--}}
{{--                                            <input type="text" name="sr_no" value="{{ $product->sr_no }}" id="sr_no" class="form-control fixedOption" required>--}}
{{--                                        </div>--}}
                                        <div class="col-md-4">
                                            <label for="product_id">P/N</label>
                                            <input type="text" name="pn_no" value="{{ $product->pn_no }}" id="pn_no" class="form-control fixedOption">
                                            @error('pn_no')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="product_id">HSN No.</label>
                                            <input type="text" name="hsn_no" value="{{ $product->hsn_no }}" id="hsn_no" class="form-control fixedOption">
                                            @error('hsn_no')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Sale Price:<span class="validateClass">*</span></label>
                                            <input type="text" name="sale_price" class="form-control" id="salePrice" value="{{ $product->sale_price }}">
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
                                                    <span class="input-group-text input-group-addon" id="alighaddon1">www.ssscientif.net/</span>
                                                    <?php
                                                    $readOnly = (true) ? 'readonly' : '';
                                                    ?>
                                                    <input type="text" name="slug" class="form-control" id="txtSlug" value="{{ $product->slug }}" >
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
                                                    <textarea class="form-control" name="short_description" id="short_description">{{ $product->short_description }}</textarea>
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
                                                <label for="slug" class="form-control-label"> Description</label>
                                                <textarea class="form-control" name="description" id="description">{{ $product->description }}</textarea>
                                                @error('description')
                                                <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="relation">Upload Product Image:</label>
                                            <input type="file"  class="form-control product_image" id="product_image" name="images">
                                            @error('images')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="document">Upload Product Catelog:</label>
                                            <input type="file"  class="form-control document" id="document" name="document">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Status:<span class="validateClass">*</span></label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="1" {{ $product->status == 1?'selected':'' }}>Active</option>
                                                <option value="2" {{ $product->status == 2?'selected':'' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="gallery" style="display: flex">
                                            @if($product->images)
                                                @foreach($product->images as $image)
                                                    @if($image->type == 0)
                                                        <div class="imageDiv" id="p_image_{{ $image->id }}">
                                                            <img src="{{ asset("images\products\/").$image->image_name }}" />
                                                            <span class="deleteImg" onclick="return product.deleteImage({{ $image->id }})">X</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
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
                                                            <textarea class="form-control" id="modelname" name="modelname[]" placeholder="Model Name"></textarea>
                                                        </div>
                                                    </div>
{{--                                                    <div class="col-sm-3 nopadding">--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <input type="text" class="form-control" id="acc_sku" name="acc_sku[]" value="" placeholder="SKU">--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                    <div class="col-sm-2 nopadding">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="acc_pn_no" name="acc_pn_no[]" value="" placeholder="P/N">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2 nopadding">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="acc_hsn_no" name="acc_hsn_no[]" value="" placeholder="HSN No">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 nopadding">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="acc_sale_price" name="acc_sale_price[]" value="" placeholder="Sale Price">
                                                                <div class="input-group-btn">
                                                                    <button class="btn btn-success" type="button"  onclick="accessories();"> <span class="fa fa-plus" aria-hidden="true"></span> </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                                <div id="education_fields">
                                                @if($product->accessories)
                                                    @php
                                                        $totalAccessories = $product->accessories->count();
                                                    @endphp
                                                    @foreach($product->accessories as $key => $accessory)
                                                        <div class="row removeclass{{ $key  }}">
                                                            <div class="col-sm-5 nopadding">
                                                                <div class="form-group">
                                                                    <textarea class="form-control" id="modelname" name="modelname[]" placeholder="Model Name" >{{$accessory->name}}</textarea>
                                                                </div>
                                                            </div>
{{--                                                            <div class="col-sm-3 nopadding">--}}
{{--                                                                <div class="form-group">--}}
{{--                                                                    <input type="text" class="form-control" id="acc_sku" name="acc_sku[]"  value="{{ $accessory->sku }}" placeholder="SKU">--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
                                                            <div class="col-sm-2 nopadding">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="acc_pn_no" name="acc_pn_no[]"  value="{{ $accessory->pn_no }}" placeholder="P/N">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 nopadding">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="acc_hsn_no" name="acc_hsn_no[]" value="{{ $accessory->hsn_no }}"  placeholder="HSN No">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 nopadding">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="acc_sale_price" name="acc_sale_price[]" value="{{ $accessory->sale_price }}"  placeholder="Sale Price">
                                                                        <div class="input-group-btn">
                                                                            <button
                                                                                class="btn btn-danger" type="button" onclick="remove_accessories({{ $key++ }});">
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
    <script>

        var room = "{{ $totalAccessories }}";
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

        $('#description').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
                ['view', ['fullscreen']]
            ],
            height: 200,
            weight: 1000,
        });
    </script>
    <script src="{{ asset('/js/pages/product.js') }}"></script>

@endsection
