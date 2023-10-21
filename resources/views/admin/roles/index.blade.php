@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Roles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Roles</li>
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
                                <a href="{{ route('create.role') }}" class="pull-right btn btn-primary" >Add</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="rolesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="subj_name">Id</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td class="subj_name">{{ $role->id }}</td>
                                        <td>{{ $role->role_name }}</td>
                                        <td>{{ \App\Models\Admin\Role::roleStatus[$role->status] }}</td>
                                        <td>{{ $role->created_at }}</td>
                                        <td>
                                            @php
                                                $buttons = [
//                                                    'trash' => [
//                                                        'label' => 'Delete',
//                                                        'attributes' => [
//                                    //                        'id' => $property->id.'_view',
//                                                            'href' => route('delete.role', ['role' => $role->id]),
//                                                            'class' => 'ConfirmDelete'
//                                                        ]
//                                                    ],
                                                    'edit' => [
                                                        'label' => 'Edit',
                                                        'attributes' => [
                                                            'href' => route('edit.role', ['role' => $role->id]),
                                                        ]
                                                    ]
                                                ];
                                            @endphp
                                            {!! table_buttons($buttons, false) !!}
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
@endsection
@section('pageScript')
<script>
    var roleSuccessMsg = "{{ session('roleSuccessMsg') }}";
    var roleErrorMsg = "{{ session('roleErrorMsg') }}";
    if(roleSuccessMsg){
        messages.saved("Role", roleSuccessMsg);
    }

    if(roleErrorMsg){
        messages.error("Role", roleErrorMsg);
    }

    $(function () {
    $("#rolesTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#rolesTable_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection
