@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Brands</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
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
                                <a href="{{ route('create.category') }}" class="pull-right btn btn-primary" >Add</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="rolesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="subj_name">Id</th>
                                        <th>Name</th>
                                        <th>Parent Brand</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td class="subj_name">{{ $category->id }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ ($category->parentCategory)?$category->parentCategory->category_name:'NA' }}</td>
                                        <td>{{ status($category->status) }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>
                                            @php
                                                $buttons = [
                                                    'trash' => [
                                                        'label' => 'Delete',
                                                        'attributes' => [
                                    //                        'id' => $property->id.'_view',
                                                            'href' => route('delete.category', ['category' => $category->id]),
                                                            'class' => 'ConfirmDelete'
                                                        ]
                                                    ],
                                                    'edit' => [
                                                        'label' => 'Edit',
                                                        'attributes' => [
                                                            'href' => route('edit.category', ['category' => $category->id]),
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
    var categorySuccessMsg = "{{ session('categorySuccessMsg') }}";
    var categoryErrorMsg = "{{ session('categoryErrorMsg') }}";
    if(categorySuccessMsg){
        messages.saved("category", categorySuccessMsg);
    }

    if(categoryErrorMsg){
        messages.error("category", categoryErrorMsg);
    }

    $(function () {
    $("#rolesTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#rolesTable_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection
