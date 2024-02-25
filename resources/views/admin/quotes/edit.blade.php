@extends('admin.layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quote</li>
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
                            <h5>Quotation Request Form</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="quoteForm" id="quoteForm" action="{{ route('quote.update',['quote' => $model->id]) }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <input type="hidden" id="quote_id" name="quote_id" value="{{ $model->id }}">
                                <h6 class="title_in_caps" style="margin-bottom: 9px !important;">Customer Information:</h6>
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4" style="text-align: left;margin-top: 9px;">
                                            <label class="">Select Primary Customer<span class="validateClass">*</span></label>
                                            <select data-resource="user"
                                                    class="form-control"
                                                    style="width: 100%;"
                                                    name="id_user"
                                                    id="quoteCustomer"
                                                    data-parent="#quoteForm"
                                                    onchange="return getUserDetails(this.value,1)"
                                                    required>
                                                <option value="">Select customer</option>
                                                @if(isset($model->user))
                                                    <option value="{{$model->user->id}}"
                                                            selected>{{$model->user->getFullname()}}
                                                        ({{$model->user->email}})
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4" style="text-align: left;margin-top: 9px;">
                                            <label class="">Currency Type<span class="validateClass">*</span></label>
                                            <select class="form-control" style="width: 100%;" name="currency_type" id="currency_type"
                                                    required>
                                                <option value="">Select Currency</option>
                                                @php
                                                    $currencies = \App\Models\Admin\Quote::CURRENCY_TYPES;
                                                @endphp
                                                @foreach($currencies as $key => $currency)
                                                    <option value="{{ $key }}" {{ ($key == $model->currency_type)?'selected':'' }}>{{ $currency }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4" style="text-align: left;margin-top: 9px;">
                                            <label for="order_type">Order Type:</label>
                                            <select class="form-control" id="order_type" name="order_type">
                                                <option value="">Select Order Type</option>
                                                <option value="0"  {{ ($model->order_type == 0)?'selected':'' }}>Regular</option>
                                                <option value="1"  {{ ($model->order_type == 1)?'selected':'' }}>Tender</option>
                                                <option value="2"  {{ ($model->order_type == 2)?'selected':'' }}>Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone_number">Phone Number:</label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control fixedOption"  value="{{ $model->phone_number }}" required>
                                        </div>
                                        <div class="col-md-4" style="margin-top: 2px;">
                                            <label for="email">E-Mail Address:<span class="validateClass">*</span></label>
                                            <input type="email" name="email" id="email"  value="{{ $model->email }}" class="form-control fixedOption">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="relation">GST No:<span class="validateClass">*</span></label>
                                            <input type="text" class="form-control"  value="{{ $model->gst_no }}" name="gst_no" id="gst_no" />
                                        </div>
                                        <div class="col-md-4 depend_on_tendor" style="display:none">
                                            <label for="tendor_no">Tendor Number:</label>
                                            <input type="text" name="tendor_no" id="tendor_no" value="{{ $model->tendor_no }}" class="form-control fixedOption" required>
                                        </div>
                                        <div class="col-md-4 depend_on_tendor" style="display:none">
                                            <label for="due_date">Due Date:<span class="validateClass">*</span></label>
                                            <input type="date" name="due_date" id="due_date" value="{{ $model->due_date }}"  class="form-control fixedOption">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="">
                                    Bill To:
                                </h6>
                                <div class="proposal-boxx--View">
                                    <div class="row">
                                        <div class="col-md-8 margin-bottom-20">
                                            <label for="property_address">Street Address:<span class="validateClass">*</span></label>
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $model->address }}" required>

                                        </div>
                                    </div>
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4">
                                            <label for="apt_no">Apt No<span class="noValidateClass">(optional)</span></label>
                                            <input type="text" class="form-control" name="apt_no" id="apt_no" value="{{ $model->apt_no }}" placeholder="Apt No">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="city">City<span class="validateClass">*</span></label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="City" value="{{ $model->city }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="zipcode">Zipcode<span class="validateClass">*</span></label>
                                            <input type="text" class="form-control" name="zipcode" id="zipcode" value="{{ $model->zipcode }}" placeholder="Zipcode" required>
                                        </div>
                                    </div>
                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4" style="clear: both">
                                            <label class="" for="state">State<span class="validateClass">*</span></label>
{{--                                            <select class="form-control" id="state" name="state">--}}
{{--                                                <option value="">Select State</option>--}}
{{--                                                <option value="1" {{ $model->state == 1?'selected':'' }}>MH</option>--}}

{{--                                            </select>--}}

                                            <input type="text" name="state" id="state" value="{{ $model->state }}" class="form-control">
                                            <span class="text-danger" id="state_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="" style="display:flex">
                                    <span class="">Ship To:</span><span class="noValidateClass">(optional)</span>&nbsp;
                                    <div class="icheck-primary d-inline billingCheckbox">
                                        <input type="checkbox" name="billingChk" id="billingChk"
                                               onclick="fillBillingAddress()" class="" {{ $model->billing_option?'checked':'' }}>
                                        <label for="billingChk">
                                            <span>Same as Staging Address</span>
                                        </label>
                                    </div>
                                </h6>
                                <div class="proposal-boxx--View">
                                    <div class="row">
                                        <div class="col-md-8 margin-bottom-20">
                                            <label for="billing_address">Billing Street Address:</label>
                                            <input type="text" class="form-control" name="billing_address" id="billing_address" value="{{ $model->billing_address }}" placeholder="Address" required>

                                        </div>
                                    </div>

                                    <div class="row margin-bottom-20">
                                        <div class="col-md-4">
                                            <label for="billing_apt_no">Billing Apt No</label>
                                            <input type="text" class="form-control" name="billing_apt_no" id="billing_apt_no" value="{{ $model->billing_apt_no }}" placeholder="Billing Apt No">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="billing_city">Billing City<span class="validateClassOption">*</span></label>
                                            <input type="text" class="form-control" name="billing_city" id="billing_city" value="{{ $model->billing_city }}"  placeholder="Billing City" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="billing_zipcode">Billing Zipcode<span class="validateClassOption">*</span></label>
                                            <input type="text" class="form-control" name="billing_zipcode" id="billing_zipcode" value="{{ $model->billing_zipcode }}"  placeholder="Billing Zipcode" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4" style="clear: both">
                                            <div class="form-group">
                                                <label class="">Billing State<span class="validateClassOption">*</span></label>
                                                <input type="text" name="billing_state" id="billing_state" value="{{ $model->billing_state }}"  class="form-control">
                                            </div>
                                            <span class="text-danger" id="billing_state_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="title_in_caps">Miscellaneous Information:</h6>
                                <div class="proposal-boxx--View">
                                    <div class="form-group margin-bottom-20  m-t-5 depend_on_order_type">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="reference_from" style="min-height: 33px">How did you hear about US?</label>
                                                <input type="text" name="reference_from"  value="{{ $model->reference_from }}" id="reference_from" class="form-control">
                                            </div>
                                            <div class="col-md-3 depend">
                                                <label for="referral_person" style="min-height: 33px">Who referred us to you?</label>
                                                <input type="text" name="referral"  value="{{ $model->referral }}" id="referral" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="is_enquired" style="min-height: 33px">Is previously enquired?</label>
                                                <input type="text" name="is_enquired" id="is_enquired" class="form-control" value="{{ $model->is_enquired }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="change_quote_no" style="min-height: 33px">Change Quote No <small>({{ $model->quote_no }})</small></label>
                                                <input type="text" name="change_quote_no" id="change_quote_no" class="form-control" value="{{ $model->is_enquired }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="notes">Quotation Request Notes<span class="noValidateClass">(optional)</span></label>
                                                <textarea cols="10" rows="5" class="form-control" id="notes" name="notes" aria-describedby="emailHelp" placeholder="Notes">{{ $model->notes }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right quoteFormBtn quoteNewForm" id="quoteFormBtn" data-type="save">Save & Continue</button>
{{--                                <button type="submit" class="btn btn-primary modalClose" data-dismiss="modal" aria-label="Close" >Cancel</button>--}}
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Product</h5>
                        </div>
                        <div class="card-body">
                            <form name="productForm" id="productForm" action="{{ route('quote.create') }}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="proposal-boxx--View">
                                    <div class="row margin-bottom-20">
                                       <div class="col-md-12" style="display:flex">
                                           <div class="col-md-6" style="text-align: left;">
                                               <select class="form-control select2bs4" data-resource="product" data-parent="#addProduct" style="width: 100%;" name="sku" id="ddlProducts" onchange="return searchProduct(this.value,1)">
                                                   <option value="">Select Product</option>
                                               </select>
                                           </div>
                                           <label for="ddlProducts" class="addMoreProductLable" style="display: none">Add More Products</label>
                                       </div>
                                    </div>
                                </div>
                            </form>
                            <div class="productResultContainer"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Added Items</h5>
                        </div>
                        <div class="card-block">
                            <div class="cartItemsBlock">
                                <div class="loadProducts">Please wait..</div>
                            </div>
                            @if($model)
                                <div class="row">
                                    <div class="col-lg-6" style="margin-top: 12px;text-align: left;margin-left: 13px;">
                                        <div class="approvedProposalDiv fade-in-primary">
                                            @if($model->action_by)
                                                <label>
                                                    Proposal Approved By:
                                                        <?php
                                                        if ($model->action_type) {
                                                            $adminName = '';
                                                            if ((int)$model->action_by > 0) {
                                                                $adminName = \App\Models\User::getApprover($model->action_by);
                                                                echo $adminName . ' <br />Quote Approved On: ' . date('d-m-Y',$model->action_at);
                                                            }
                                                        }
                                                        ?>
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="btnRowList">
{{--                                <button class="btn pull-right m-l-10 btn btn-success"--}}
{{--                                        type="button">Send to Internal--}}
{{--                                </button>--}}
                                    <button class="btn btn-success pull-right m-l-10"
                                            type="button" style="display: {{ ($model->action_type == \App\Models\Admin\Quote::ACTION_STATUS_APPROVED)?'inline':'none' }}">Quote Approved
                                    </button>
{{--                                    <a class="btn btn-primary pull-right m-l-10" id="invoiceDownload"--}}
{{--                                       target="_blank" href="{{ route('invoice.download',['quote_id' => $model->id,'type'=>'pdf']) }}" style="display: {{ ($model->action_type == \App\Models\Admin\Quote::ACTION_STATUS_APPROVED)?'inline-block':'none' }};margin-right:5px;">--}}
{{--                                        Download Invoice--}}
{{--                                    </a>--}}
                                    <button class="btn btn-success pull-right m-l-10 approvedButton"
                                            type="button" data-toggle="modal" data-target="#confirmApprovalModal"  style="display: {{ !$model->action_type?'inline-block':'none' }}">Approve Quote
                                    </button>

                                <a class="btn btn-primary pull-right m-l-10" id="proposalDownload1"
                                   target="_blank" href="{{ route('quote.download',['quote_id' => $model->id,'type'=>'pdf']) }}">Download Proposal</a>
    {{--                                <button--}}
    {{--                                    class="btn pull-right m-l-10 btn btn-success customerSendMailBtn"--}}
    {{--                                    type="button"--}}
    {{--                                    onclick="return quote.send('{{ route('quote.sendQuote',['quote_id' => $model->id]) }}')"--}}
    {{--                                >Sent to Customer--}}
    {{--                                </button>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="confirmApprovalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Please Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -26px !important">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="action_type">Status Type:</label>
                            <select class="form-control" id="action_type" name="action_type">
                                <option value="">Select Order Type</option>
                                <option value="2">Order Received</option>
                                <option value="3">Lost</option>
                                <option value="4">Hold</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="notes">Remark</label>
                            <textarea cols="10" rows="5" class="form-control" id="remark" name="remark" aria-describedby="emailHelp" placeholder="Remark"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary confirmApprovalBtn" id="confirmApprovalBtn"
                            onclick="return quote.approveProposal('{{route('quote.changeStatus', ['quote_id' => $model->id])}}')">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="accessoriesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Accessories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="accessoriesTable">
                        <thead>
                        <tr>
                            <th scope="col">SR NO</th>
                            <th scope="col">Accessories Name</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Asset Value</th>
                            <th scope="col">ADD</th>
                        </tr>
                        </thead>
                        <tbody id="accessoriesRowData"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageScript')
    <script src="{{ asset('/js/pages/quote.js') }}"></script>
    <script>
        var quoteSuccessMsg = "{{ session('quoteSuccessMsg') }}";
        var quoteErrorMsg = "{{ session('quoteErrorMsg') }}";
        if(quoteSuccessMsg){
            messages.saved("Quote", quoteSuccessMsg);
        }

        if(quoteErrorMsg){
            messages.error("Quote", quoteErrorMsg);
        }

    </script>
@endsection
