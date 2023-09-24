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
                            <h5>Edit {{ $invoiceType  }}</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="invoiceForm" id="invoiceForm" action="{{ route('update.invoice') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $model->id }}" name="invoice_id">
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4" style="text-align: left;">
                                            <label class="">Select Quote {{  $model->quote->quote_no }}<span class="validateClass">*</span></label>
                                            <select data-resource="quote_id"
                                                    class="form-control"
                                                    style="width: 100%;"
                                                    name="quote_id"
                                                    id="quoteNo"
{{--                                                    data-parent="#invoiceForm"--}}
                                                    required>
                                                <option value="">Select Quote</option>
                                                @if(isset($model->quote))
                                                    <option value="{{$model->quote->id}}"
                                                            selected>{{ $model->quote->quote_no }}
                                                    </option>
                                                @endif
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
                                                @if(isset($model->purchaseOrder))
                                                    <option value="{{$model->purchaseOrder->id}}"
                                                            selected>{{ $model->purchaseOrder->po_no }}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="gst_no">GST NO:</label>
                                            <input type="text" name="gst_no" id="gst_no" value="{{ $model->gst_no }}" class="form-control fixedOption">
                                        </div>
                                        @if($type == \App\Models\Admin\Invoice::INVOICE)
                                        <div class="col-md-4">
                                            <label for="freight">Freight Rate:</label>
                                            <input type="text" name="freight" id="freight" value="{{ $model->freight }}" class="form-control fixedOption">
                                        </div>
                                        @endif
                                        <div class="col-md-4">
                                            <label for="relation">Status:</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="1" {{ $model->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="2" {{ $model->status == 2 ? 'selected' : '' }}>Inactive</option>
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
