@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->

    <style>
        .form-popup {
            display: none;
            position: absolute;
            bottom: 2;
            left: 740px;
            border: 3px solid #f1f1f1;
            border-radius: 15px;
            z-index: 2;
            max-width: 300px;
            padding: 10px;
            background-color: white;
            margin-top: -40px;
        }

        .desc-text{
            font-size: 10px;
            font-family : calibri;
        }
    </style>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quotes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quotes</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--  card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="pull-right">
                                <a href="{{ route('quote.add') }}" class="pull-right btn btn-primary" >Add</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="quoteTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="subj_name">SR No</th>
                                        <th>Created Date</th>
                                        <th>Quotation No</th>
                                        <th>Company Name</th>
                                        <th>Contact Person</th>
{{--                                        <th>Description</th>--}}
                                        <th>Products</th>
                                        <th>Total Price</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="10" style="text-align:center;">Please wait...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('pageScript')
<script>
    var quoteAjax = "{{ route('ajax.quotes') }}";

    var quoteSuccessMsg = "{{ session('quoteSuccessMsg') }}";
    var quoteErrorMsg = "{{ session('quoteErrorMsg') }}";
    if(quoteSuccessMsg){
        messages.saved("quote", quoteSuccessMsg);
    }

    if(quoteErrorMsg){
        messages.error("quote", quoteErrorMsg);
    }
</script>
    <script src="{{ asset('js/pages/quote.js') }}"></script>
@endsection
