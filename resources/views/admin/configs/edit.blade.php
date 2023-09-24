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
                        <li class="breadcrumb-item active">Config</li>
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
                            <h5>Update Config</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="roleForm" id="roleForm" action="{{ route('update.config') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4">
                                            <input type="hidden" name="id" value="{{ $model->id }}">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name"  value="{{ $model->name }}" id="name" class="form-control fixedOption">
                                            @error('name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="value">Value:</label>
                                            <input type="text" name="value"  value="{{ $model->value }}" id="value" class="form-control fixedOption">
                                            @error('value')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Status:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="1" {{ $model->status ==  1 ? 'selected': '' }}>Active</option>
                                                <option value="2" {{ $model->status ==  2 ? 'selected': '' }}>Inactive</option>
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
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
