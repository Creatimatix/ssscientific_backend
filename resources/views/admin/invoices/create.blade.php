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
                        <li class="breadcrumb-item active">{{ $invoiceType  }}</li>
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
                            <h5>Add {{ $invoiceType  }}</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="invoiceForm" id="invoiceForm" action="{{ route('store.invoice') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="{{ $type }}">
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4" style="text-align: left;">
                                            <label class="">Select Quote<span class="validateClass">*</span></label>
                                            <select data-resource="quote"
                                                    class="form-control"
                                                    style="width: 100%;"
                                                    name="quote_id"
                                                    id="quoteNo"
{{--                                                    data-parent="#invoiceForm"--}}
{{--                                                    onchange="return getQuoteDetails(this.value,1)"--}}
                                                    >
                                                <option value="">Select Quote</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" style="text-align: left;">
                                            <label class="">Select Purchase Order<span class="validateClass">*</span></label>
                                            <select data-resource="po_id"
                                                    class="form-control"
                                                    style="width: 100%;"
                                                    name="po_id"
                                                    id="poNo"
                                                    data-parent="#invoiceForm"
{{--                                                    onchange="return getQuoteDetails(this.value,1)"--}}
                                                    required>
                                                <option value="">Select Purchase Order</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pan_no">Pan No:</label>
                                            <input type="text" name="pan_no" id="pan_no" class="form-control fixedOption">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="freight">Freight Rate:</label>
                                            <input type="text" name="freight" id="freight" class="form-control fixedOption">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="installation">Installation</label>
                                            <input type="text" name="installation" id="installation" value="" class="form-control fixedOption">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="relation">Status:</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
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
    <script src="{{ asset('/js/pages/invoice.js') }}"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
