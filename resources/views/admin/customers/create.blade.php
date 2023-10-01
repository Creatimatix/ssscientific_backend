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
                        <li class="breadcrumb-item active">{{ \App\Models\User::userTypes[$type] }}</li>
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
                            <h5>Add {{ \App\Models\User::userTypes[$type] }}</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="customerForm" id="customerForm" action="{{ route('store.customer') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <h6 class="title_in_caps" style="margin-bottom: 9px !important;">{{ \App\Models\User::userTypes[$type] }} Information:</h6>
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4">
                                            <label for="first_name">First Name:</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control fixedOption" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="last_name">Last Name:</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control fixedOption" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone_number">Phone Number:</label>
                                            <input type="number" name="phone_number" id="phone_number" class="form-control fixedOption" required>
                                        </div>
                                    </div>
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4" style="margin-top: 2px;">
                                            <label for="email">E-Mail Address:<span class="validateClass">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control fixedOption" value="{{ old('email') }}">
                                        </div>
                                        @if(!in_array($type, ['customer','vendor']))
                                            <div class="col-md-4">
                                                <label for="relation">Role:</label>
                                                <select name="role" id="role" class="form-control" required>
                                                    <option value="">Select Option</option>
                                                    @foreach($roles as $role)
                                                        @if(in_array($role->id, [\App\Models\Admin\Role::ROLE_ADMIN,\App\Models\Admin\Role::ROLE_BUSINESS_HEAD,\App\Models\Admin\Role::ROLE_EXECUTIVE]))
                                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 depend_on_executive" style="display: none">
                                                <label for="id_manager">Business Heads:</label>
                                                <select name="id_manager" id="id_manager" class="form-control">
                                                    <option value="">Business Head</option>
                                                    @foreach($businessHeads as $businessHead)
                                                        <option value="{{ $businessHead->id }}">{{ $businessHead->full_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden"
                                                   value="{{ ($type == 'customer' ? \App\Models\Admin\Role::ROLE_CUSTOMER: \App\Models\Admin\Role::ROLE_VENDOR) }}"
                                                   name="role">
                                        @endif

                                        <div class="col-md-4">
                                            <label for="gst_no">GST No:<span class="validateClass">*</span></label>
                                            <input type="gst_no" name="gst_no" id="gst_no" class="form-control fixedOption">
                                        </div>
                                    </div>
                                    <h6 class="" style="margin-top: 21px;display:flex;margin-bottom: -18px;">
                                        <span class="title_in_caps">Bill To:</span>
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-8 margin-bottom-20">
                                            <label for="billing_address">Address:</label>
                                            <input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="Address" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="billing_apt_no">Billing Apt No</label>
                                            <input type="text" class="form-control" name="billing_apt_no" id="billing_apt_no" placeholder="Billing Apt No">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="billing_city">Billing City<span class="validateClassOption">*</span></label>
                                            <input type="text" class="form-control" name="billing_city" id="billing_city" placeholder="Billing City" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="billing_zipcode">Billing Zipcode<span class="validateClassOption">*</span></label>
                                            <input type="text" class="form-control" name="billing_zipcode" id="billing_zipcode" placeholder="Billing Zipcode" required>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="">Billing State<span class="validateClassOption">*</span></label>
                                                <input type="text" name="billing_state" id="billing_state" class="form-control">
                                            </div>
                                            <span class="text-danger" id="billing_state_error"></span>
                                        </div>
                                        <div class="col-md-4" style="margin-top: -10px;">
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
    <script src="{{ asset('/js/pages/customer.js') }}"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
