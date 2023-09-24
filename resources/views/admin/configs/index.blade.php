@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Configs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Configs</li>
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
                                <a href="{{ route('create.config') }}" class="pull-right btn btn-primary" >Add</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="configTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="subj_name">Id</th>
                                        <th>Config Name</th>
                                        <th>Config Value</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($configs as $config)
                                    <tr>
                                        <td class="subj_name">{{ $config->id }}</td>
                                        <td>{{ $config->name }}</td>
                                        <td>{{ $config->value }}</td>
                                        <td>{{ \App\Models\Admin\Role::roleStatus[$config->status] }}</td>
                                        <td>{{ $config->created_at }}</td>
                                        <td>
                                            @php
                                                $buttons = [
                                                    'trash' => [
                                                        'label' => 'Delete',
                                                        'attributes' => [
                                    //                        'id' => $property->id.'_view',
                                                            'href' => route('delete.config', ['config' => $config->id]),
                                                        ]
                                                    ],
                                                    'edit' => [
                                                        'label' => 'Edit',
                                                        'attributes' => [
                                                            'href' => route('edit.config', ['config' => $config->id]),
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
    var configSuccessMsg = "{{ session('configSuccessMsg') }}";
    var configErrorMsg = "{{ session('configErrorMsg') }}";
    if(configSuccessMsg){
        messages.saved("Config", configSuccessMsg);
    }

    if(configErrorMsg){
        messages.error("Config", configErrorMsg);
    }

    $(function () {
    $("#configTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#rolesTable_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection
