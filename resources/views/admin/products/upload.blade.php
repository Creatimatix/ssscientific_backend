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
                            <span class="card-header-text">Upload Zipcodes</span>
                            <a href="{{ url('products.csv') }}" class="pull-right" style="margin-left: 75%; display: inline-block">Download Sample</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.upload') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="action" value="uploadProduct">
                                <input type="file" name="import_file" required accept=".xlsx, .xls, .csv" />
                                <button class="btn btn-primary">Upload File</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('pageScript')
    <script>
        var productUploadSuccessMsg = "{{ session('productUploadSuccessMsg') }}";
        var productUploadErrorMsg = "{{ session('productUploadErrorMsg') }}";
        if(productUploadSuccessMsg){
            messages.saved("Product", productUploadSuccessMsg);
        }

        if(productUploadErrorMsg){
            messages.error("Product", productUploadErrorMsg);
        }

        $(function () {
            $("#productTable").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#productTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
