@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Purchase Order</h1>
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
                            <div class="pull-right">
                                <a href="{{ route('create.purchase-order') }}" class="pull-right btn btn-primary" >Add Purchase Order</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="poTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="subj_name">Id</th>
                                        <th>PO No.</th>
                                        <th>Vendor</th>
                                        <th>Attn</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @if($purchaseOrders)
                                    @foreach($purchaseOrders as $purchaseOrder)
                                        <tr>
                                            <td>{{ $purchaseOrder->id }}</td>
                                            <td>{{ $purchaseOrder->po_no }}</td>
                                            <td>{{ ($purchaseOrder->vendor)?$purchaseOrder->vendor->full_name:'NA' }}</td>
                                            <td>{{ $purchaseOrder->attn_no }}</td>
                                            <td>{{ status($purchaseOrder->status) }}</td>
{{--                                            <td>{{ $purchaseOrder->created_at }}</td>--}}
                                            <td>{{ date('d-M-Y', strtotime($purchaseOrder->created_at)) }}</td>
                                            <td>
                                                @php
                                                    $buttons = [
                                                        'trash' => [
                                                            'label' => 'Delete',
                                                            'attributes' => [
                                        //                        'id' => $property->id.'_view',
                                                                'href' => route('delete.purchaseOrder', ['purchaseOrder' => $purchaseOrder->id]),
                                                                'class' => 'ConfirmDelete'
                                                            ]
                                                        ],
                                                        'edit' => [
                                                            'label' => 'Edit',
                                                            'attributes' => [
                                                                'href' => route('edit.purchaseOrder', ['purchaseOrderId' => $purchaseOrder->id]),
                                                            ]
                                                        ],
                                                        'download' => [
                                                            'label' => 'Download',
                                                            'attributes' => [
                                                                'href' => route('po.download',['po_id' => $purchaseOrder->id,'type'=>'pdf']),
                                                                'target' => '_blank'
                                                            ]
                                                        ]
                                                    ];

                                                    if(auth()->user()->role_id != \App\Models\Admin\Role::ROLE_ADMIN){
                                                        unset($buttons['trash']);
                                                    }

                                                @endphp
                                                {!! table_buttons($buttons, false) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                 @endif
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
<script>

    var poSuccessMsg = "{{ session('poSuccessMsg') }}";
    var poErrorMsg = "{{ session('poErrorMsg') }}";
    if(poSuccessMsg){
        messages.saved("Purchase Order", poSuccessMsg);
    }
    if(poErrorMsg){
        messages.error("Purchase Order", poErrorMsg);
    }

    $(function () {
        $("#poTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#poTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
