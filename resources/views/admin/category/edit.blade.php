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
                        <li class="breadcrumb-item active">Brand</li>
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
                            <h5>Add Brand</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="categoryForm" id="categoryForm" action="{{ route('update.category') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4">
                                            <input type="hidden" name="id_category" value="{{ $category->id }}">
                                            <label for="category_name">Name:</label>
                                            <input type="text" name="category_name" id="category_name" class="form-control fixedOption" value="{{ $category->category_name }}">
                                            @error('category_name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="id_parent">Parent Category:</label>
                                            <select name="id_parent" id="id_parent" class="form-control">
                                                <option value="">Select Parent Category</option>
                                                @foreach($parentCategories as $parentCategory)
                                                    <option value="{{ $parentCategory->id }}" {{ $parentCategory->id == $category->id_parent?'selected':'' }}>{{ $parentCategory->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_parent')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">Status:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="1" {{ $category->status == 1?'selected':'' }}>Active</option>
                                                <option value="2" {{ $category->status == 2?'selected':'' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right categoryFormBtn" id="categoryFormBtn" data-type="save">Submit</button>
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
        var categorySuccessMsg = "{{ session('categorySuccessMsg') }}";
        var categoryErrorMsg = "{{ session('categoryErrorMsg') }}";
        if(categorySuccessMsg){
            messages.saved("category", categorySuccessMsg);
        }

        if(categoryErrorMsg){
            messages.error("category", categoryErrorMsg);
        }
    </script>
@endsection
