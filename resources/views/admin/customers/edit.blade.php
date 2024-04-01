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
                            <h5>Update {{ \App\Models\User::userTypes[$type] }}</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="customerForm" id="customerForm" action="{{ route('store.customer') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="margin-bottom-20">
                                    <input type="hidden" value="{{ $model->id }}" name="id">
                                    <div class="row margin-bottom-20">
                                        @if(in_array($type, ['vendor','customer']))
                                            <div class="col-md-4">
                                                <label for="company_name">Company Name:</label>
                                                <input type="text" name="company_name" id="company_name" class="form-control fixedOption" value="{{ $model->company_name }}">
                                            </div>
                                        @endif
                                        <div class="col-md-4">
                                            <label for="first_name">First Name:</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control fixedOption" required value="{{ $model->first_name }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="last_name">Last Name:</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control fixedOption" required value="{{ $model->last_name }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone_number">Phone Number:</label>
                                            <input type="number" name="phone_number" id="phone_number" class="form-control fixedOption" required value="{{ $model->phone_number }}">
                                        </div>
                                        <div class="col-md-4" style="margin-top: 2px;">
                                            <label for="email">E-Mail Address:<span class="validateClass">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control fixedOption" value="{{ old('email') ? old('email') : $model->email }}" >
                                        </div>
                                        @if(!in_array($type, ['customer','vendor']))
                                        <div class="col-md-4">
                                            <label for="relation">Role:<span class="validateClass">*</span></label>
                                            <select name="role" id="role" class="form-control" required>
                                                <option value="">Select Option</option>
                                                @foreach($roles as $role)
                                                    @if(in_array($role->id, [\App\Models\Admin\Role::ROLE_ADMIN,\App\Models\Admin\Role::ROLE_BUSINESS_HEAD,\App\Models\Admin\Role::ROLE_EXECUTIVE]))
                                                    <option value="{{ $role->id }}" {{ $model->role_id == $role->id?'selected': '' }}>{{ $role->role_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 depend_on_executive" style="display: {{ ($model->role_id == \App\Models\Admin\Role::ROLE_EXECUTIVE) ? 'block': 'none' }}">
                                            <label for="id_manager">Business Heads:</label>
                                            <select name="id_manager" id="id_manager" class="form-control">
                                                <option value="">Business Head</option>
                                                @foreach($businessHeads as $businessHead)
                                                    <option value="{{ $businessHead->id }}" {{ ($model->id_manager == $businessHead->id ? 'selected' : '' ) }}>{{ $businessHead->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 depend_on_area_manager"  style="display: {{ ($model->role_id == \App\Models\Admin\Role::ROLE_BUSINESS_HEAD) ? 'block': 'none' }}">
                                            <label for="id_manager">Zone:</label>
                                            <select name="zone" id="zone" class="form-control">
                                                <option value="">Select Zone</option>
                                                @foreach($zones as $zone)
                                                    <option value="{{ $zone }}" {{ ($model->zone == $zone ? 'selected' : '' ) }}>{{ $zone }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @else
                                            <input type="hidden" value="{{ ($type == 'customer' ? \App\Models\Admin\Role::ROLE_CUSTOMER: \App\Models\Admin\Role::ROLE_VENDOR) }}" name="role">
                                        @endif
                                        @if(in_array($type, ['customer','vendor']))
                                            <div class="col-md-4">
                                                <label for="gst_no">GST No:<span class="validateClass">*</span></label>
                                                <input type="text" name="gst_no" id="gst_no" value="{{ $model->gst_no }}" class="form-control fixedOption">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pan_no">Pan No:<span class="validateClass">*</span></label>
                                                <input type="text" name="pan_no" id="pan_no" value="{{ $model->pan_no }}" class="form-control fixedOption">
                                            </div>
                                        @endif
                                        @if(in_array($type, ['vendor']))
{{--                                            <div class="col-md-4">--}}
{{--                                                <label for="vendor_code">Vendor Code:</label>--}}
{{--                                                <input type="vendor_code" name="vendor_code" id="vendor_code"  value="{{ $model->vendor_code }}" class="form-control fixedOption">--}}
{{--                                            </div>--}}
                                        @endif
                                        <div class="col-md-4" style="margin-top: 2px;">
                                            <label for="relation">Status:<span class="validateClass">*</span></label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="1"  {{ $model->status == 1?'selected': '' }}>Active</option>
                                                <option value="2" {{ $model->status == 2?'selected': '' }}>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 margin-bottom-20">
                                            <label for="property_address">Street Address:<span class="validateClass">*</span></label>
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $model->address }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="apt_no">Apt No<span class="noValidateClass">(optional)</span></label>
                                            <input type="text" class="form-control" name="apt_no" id="apt_no" value="{{ $model->apt_no }}" placeholder="Apt No">
                                        </div>
                                    </div>
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4">
                                            <label for="city">City<span class="validateClass">*</span></label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="City" value="{{ $model->city }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="zipcode">Zipcode<span class="validateClass">*</span></label>
                                            <input type="text" class="form-control" name="zipcode" id="zipcode" value="{{ $model->zipcode }}" placeholder="Zipcode" required>
                                        </div>
                                        <div class="col-md-4" style="clear: both">
                                            <label class="" for="state">State<span class="validateClass">*</span></label>
                                            <input type="text" name="state" id="state" value="{{ $model->state }}" class="form-control">
                                            <span class="text-danger" id="state_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style=" margin-top: 15px; margin-left: 1px; ">
                                    <button type="submit" class="btn btn-primary pull-right customerFormBtn" id="customerFormBtn" data-type="save">Submit</button>
                                </div>
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
        var isMessage = "{{ session('customerMsg') }}";
        if(isMessage){
            messages.saved("Customer", isMessage);
        }
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
