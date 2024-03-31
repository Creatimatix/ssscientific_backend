@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ \App\Models\User::userTypes[$type] }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                                <a href="{{ route('create.customer', ["type" => $type]) }}" class="pull-right btn btn-primary" >Add</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="customersTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="subj_name">Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        @if(in_array($type, ['user']))
                                            <th>Role</th>
                                        @endif
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $key => $customer)
                                        @php
                                            $zone = ($customer->zone)?' -'.$customer->zone:'';
                                        @endphp
                                    <tr>
                                            <td class="subj_name">{{ ++$key }}</td>
                                            <td>{{ $customer->full_name.' '.$zone }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone_number }}</td>
                                            <td>{{ status($customer->status) }}</td>
                                            @if(in_array($type, ['user']))
                                            <td>{{ $customer->role?$customer->role->role_name:'NA' }}</td>
                                           @endif
                                            <td>{{ date('d-m-Y' , strtotime($customer->created_at)) }}</td>
                                            <td style="text-align: center">
                                                @php
                                                    $buttons = [
                                                        'trash' => [
                                                            'label' => 'Delete',
                                                            'attributes' => [
                                        //                        'id' => $property->id.'_view',
                                                                'href' => route('delete.customer', ['user' => $customer->id]),
                                                                'class' => 'ConfirmDelete'
                                                            ]
                                                        ],
                                                        'edit' => [
                                                            'label' => 'Edit',
                                                            'attributes' => [
                                                                'href' => route('edit.customer', ['user' => $customer->id,'type'  => $type]),
                                                            ]
                                                        ]
                                                    ];

                                                    if(auth()->user()->role_id != \App\Models\Admin\Role::ROLE_ADMIN){
                                                        unset($buttons['trash']);
                                                    }
                                                @endphp
                                                {!! table_buttons($buttons, false) !!}
                                                <br />
                                                @if(in_array(auth()->user()->role_id, [\App\Models\Admin\Role::ROLE_ADMIN]))
                                                    @if(!in_array($type, ['customer','vendor']))
                                                    <a href="javascript:void(0)"
                                                       class="change_password"
                                                       data-id="{{ $customer->id }}"
                                                       id="change_password"
                                                    >
                                                        Change Password
                                                    </a>
                                                    @endif
{{--                                                @else--}}
{{--                                                    @if(auth()->user()->id == $customer->id)--}}
{{--                                                        @if(in_array(auth()->user()->role_id, [\App\Models\Admin\Role::ROLE_EXECUTIVE, \App\Models\Admin\Role::ROLE_BUSINESS_HEAD]))--}}
{{--                                                        <a href="javascript:void(0)"--}}
{{--                                                           class="change_password"--}}
{{--                                                           data-id="{{ $customer->id }}"--}}
{{--                                                           id="change_password"--}}
{{--                                                        >--}}
{{--                                                            Change Password--}}
{{--                                                        </a>--}}
{{--                                                        @endif--}}
{{--                                                    @endif--}}
                                                @endif
                                            </td>
                                    </tr>
                                    @endforeach
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


    <!--modal-->
    <div id="passwordChangeModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">
                                    <h6>Change Password</h6>
                                    <input type="hidden" id="id_customer" value="">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input class="form-control input-lg" placeholder="Password" name="password" id="password" type="text">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control input-lg" placeholder="Confirm Password" name="confirm_password" id="confirm_password" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12">
                            <button class="btn pull-left" id="savePasswordBtn" style="width: 70px;margin-right: 87px;">Save</button>
                            <button class="btn pull-right" data-dismiss="modal" aria-hidden="true" style="float: right;width: 70px;">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageScript')

<script src="{{ asset('/js/pages/customer.js') }}"></script>
<script>

    var isMessage = "{{ session('customerMsg') }}";
    if(isMessage){
        messages.saved("Customer", isMessage);
    }

  $(function () {
    $("#customersTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#customersTable_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection
