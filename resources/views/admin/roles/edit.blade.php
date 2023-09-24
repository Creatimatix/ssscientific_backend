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
                            <h5>Edit Roles</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="roleForm" id="customerForm" action="{{ route('update.role') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <input type="hidden" name="role_id" value="{{ $model->id }}">
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4">
                                            <label for="role_name">Name:</label>
                                            <input type="text" name="role_name" id="role_name" value="{{ $model->role_name }}" class="form-control fixedOption">
                                            @error('role_name')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="status">Status:<span class="validateClass">*</span></label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="1" {{ $model->status == 1?'selected':'' }}>Active</option>
                                                <option value="2" {{ $model->status == 2?'selected':'' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right roleFormBtn" id="roleFormBtn" data-type="save">Submit</button>
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
    <script src="{{ asset('/js/pages/customer.js') }}"></script>
    <script>

        var roleSuccessMsg = "{{ session('roleSuccessMsg') }}";
        var roleErrorMsg = "{{ session('roleErrorMsg') }}";
        if(roleSuccessMsg){
            messages.saved("Role", roleSuccessMsg);
        }

        if(roleErrorMsg){
            messages.error("Role", roleErrorMsg);
        }

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
