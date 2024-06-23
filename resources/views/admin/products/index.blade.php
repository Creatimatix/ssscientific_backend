@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
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
                            <div class="pull-left">
                                <a href="{{ route('create.product') }}" class="btn btn-primary" >Add</a>
                                <a href="{{ route('product.upload') }}" class="btn btn-primary" >Upload</a>
                            </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="category_filter" class="form-control-label">Category</label>
                                    <select class="form-control" id="category_filter">
                                        <option value="All">All</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <table id="productTable" class="table dt-responsive table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th class="subj_name">Id</th>
                                        <th>Model No</th>
                                        <th>Brand</th>
                                        <th>Short Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
{{--                                    @foreach($products as $product)--}}
{{--                                    <tr>--}}
{{--                                            <td class="subj_name">{{ $product->id }}</td>--}}
{{--                                            <td>{{ $product->name }}</td>--}}
{{--                                            <td>{{ $product->category?$product->category->category_name:'NA' }}</td>--}}
{{--                                            <td>{{ $product->short_description }}</td>--}}
{{--                                            <td>{{ status($product->status) }}</td>--}}
{{--                                            <td>--}}
{{--                                                @php--}}
{{--                                                    $buttons = [--}}
{{--                                                        'trash' => [--}}
{{--                                                            'label' => 'Delete',--}}
{{--                                                            'attributes' => [--}}
{{--                                        //                        'id' => $property->id.'_view',--}}
{{--                                                                'href' => route('delete.product', ['product' => $product->id]),--}}
{{--                                                                'class' => 'ConfirmDelete'--}}
{{--                                                            ]--}}
{{--                                                        ],--}}
{{--                                                        'edit' => [--}}
{{--                                                            'label' => 'Edit',--}}
{{--                                                            'attributes' => [--}}
{{--                                                                'href' => route('edit.product', ['id_product' => $product->id]),--}}
{{--                                                            ]--}}
{{--                                                        ]--}}
{{--                                                    ];--}}
{{--                                                    if(auth()->user()->role_id != \App\Models\Admin\Role::ROLE_ADMIN){--}}
{{--                                                        unset($buttons['trash']);--}}
{{--                                                    }--}}
{{--                                                @endphp--}}
{{--                                                {!! table_buttons($buttons, false) !!}--}}
{{--                                            </td>--}}
{{--                                    </tr>--}}
{{--                                    @endforeach--}}
                                    <tr>
                                        <td colspan="6" style="text-align:center">Please wait loading....</td>
                                    </tr>
                                </tbody>
                            </table>
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

    var productAjax = "{{ route('ajax.product-list') }}";
    var productSuccessMsg = "{{ session('productSuccessMsg') }}";
    var productErrorMsg = "{{ session('productErrorMsg') }}";
    if(productSuccessMsg){
        messages.saved("Product", productSuccessMsg);
    }

    if(productErrorMsg){
        messages.error("Product", productErrorMsg);
    }

  // $(function () {
  //   $("#productTable").DataTable({
  //     "responsive": true, "lengthChange": false, "autoWidth": false,
  //   //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  //   }).buttons().container().appendTo('#productTable_wrapper .col-md-6:eq(0)');
  // });
</script>
@endsection
