<?php
    $subPrice = 0;
    $totalPrice = 0;
    $iGstTotal = 0;
    $cGSTTotal = 0;
    $sGSTTotal = 0;

    $collape_type = '';
    $collape_btn_type = 'fas fa-minus';

//    if($quote->i_gst || $quote->s_gst || $quote->c_gst) {
//        $collape_type = '';
//        $collape_btn_type = 'fas fa-minus';
//    }
?>
<table class="productSummaryTable table">
    <thead>
    <tr>
        <th style="width: 70px;"></th>
        <th>
            Product
        </th>
        <th class="text-left" style="width: 125px;">
            Sale Price
        </th>
        <th class="text-left" style="width: 75px">
            Qty
        </th>
        <th class="text-left" style="width: 125px;">
            Total
        </th>
        <th class="text-left" width="7%"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key => $item)
        @php
            $itemKey = ++$key;
            $subPrice += $item->asset_value * $item->quantity;
            $totalPrice += $item->asset_value * $item->quantity;
        @endphp
        <tr class="strong-line">
            <td>{{ $itemKey }}</td>
            <td>
                {{ $item->product->name }} <br />
                <a href="javascript:void(0)" onclick="return itemlist.getAccessories({{ $item->id }})">Add Accessories</a>
            </td>
            <td><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$item->asset_value }}</span></td>
            <td>{{ $item->quantity }}</td>
            <td><span style="font-family: DejaVu Sans; sans-serif;">{{  \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].($item->asset_value * $item->quantity) }}</span></td>
            <td>
                @php
                    $buttons = [
                        'trash' => [
                            'label' => 'Delete',
                            'attributes' => [
                                'href' => route('item.remove', ['item' => $item->id]),
                            ]
                        ]
                    ];
                @endphp
                {!! table_buttons($buttons, false) !!}
            </td>
        </tr>
        @foreach($item->accessories as $aKey => $accessory)
            @php
                if($accessory->is_payable){
                    $subPrice += $accessory->asset_value * $accessory->quantity;
                    $totalPrice += $accessory->asset_value * $accessory->quantity;
                }
            @endphp
            <tr class="strong-line">
                <td style=" text-align: right; ">
                    <input type="checkbox" name="is_payable" id="is_payable" class="is_payable" data-id="{{ $accessory->id }}" {{ $accessory->is_payable?'checked': '' }} />
                </td>
                <td>
                    {{ $itemKey.'.'.++$aKey }}  {{ $accessory->product->name }}
                </td>
                <td><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$accessory->asset_value }}</span></td>
                <td>{{ $accessory->quantity }}</td>
                <td><span style="font-family: DejaVu Sans; sans-serif;">{{  \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].($accessory->asset_value * $accessory->quantity) }}</span></td>
                <td>
                    @php
                        $buttons = [
                            'trash' => [
                                'label' => 'Delete',
                                'attributes' => [
                                    'href' => route('item.remove', ['item' => $accessory->id]),
                                ]
                            ]
                        ];
                    @endphp
                    {!! table_buttons($buttons, false) !!}
                </td>
            </tr>
        @endforeach
    @endforeach
    <tr class="table-summary">
        <td colspan="5" class="text-right" style="text-align: left !important;">
            @if($quote && !$quote->discount && count($items) > 0)
                <div class="pull-left">
                    <form name="discountForm" action="{{ route('applyDiscount') }}" id="discountForm" method="post">
                        <div class="form-group" style="display:flex">
                            <select class="form-control form-control-border" id="discount_type" style="    width: 127px;">
                                <option value="0"  {{ $quote->discount_type != '%'?'selected':'' }}>Fixed</option>
                                <option value="%" {{ $quote->discount_type == '%'?'selected':'' }}>In %</option>
                            </select>
                            <input type="number" class="form-control form-control-border" id="discount_percentage" name="discount_percentage" placeholder="%" value="{{ $quote->installation_percentage }}" style="margin-top: 0px;margin-left: 16px;width: 73px;margin-right: 12px; display: {{ $quote->installation_type == '%'?'block':'none' }};">
                            <input type="text" name="discount" id="discount" class="form-control" style="width: 200px;"/>
                            <input type="button" id="discountBtn" class="btn btn-sm pButton" value="Apply Discount" onclick="itemlist.applyDiscount(this)">
                        </div>
                    </form>
                </div>
            @endif
        </td>
        <td></td>
    </tr>
    @if(count($items) > 0)
        <tr class="table-summary">
            <td colspan="6" class="text-right" style="text-align: left !important;">
                <div class="card card-default {{ $collape_type }}">
                    <div class="card-header">
                        <h3 class="card-title">Terms and Conditions</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" style=" width: 34px; height: 26px; ">
                                <i class="{{ $collape_btn_type }}"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    @php
                        $defaultIGst = null;
                        $defaultCGst = null;
                        $defaultSGst = null;

                        if($quote->i_gst){
                            $defaultIGst = $quote->i_gst;
                        }else if(!$quote->i_gst && $quote->delivery_type == \App\Models\Admin\Quote::INTER_STATE){
                            $defaultIGst = isset($configs['INTERSTATE'])?$configs['INTERSTATE']:'';
                        }

                        if($quote->c_gst){
                            $defaultCGst = $quote->c_gst;
                        }else if(!$quote->c_gst && $quote->delivery_type == \App\Models\Admin\Quote::INTRA_STATE){
                            $defaultCGst = isset($configs['INTRASTATE'])?$configs['INTRASTATE']:'';
                        }

                        if($quote->s_gst){
                            $defaultSGst = $quote->s_gst;
                        }else if(!$quote->s_gst && $quote->delivery_type == \App\Models\Admin\Quote::INTRA_STATE){
                            $defaultSGst = isset($configs['INTRASTATE'])?$configs['INTRASTATE']:'';
                        }
                    @endphp
                    <div class="card-body">
                        <div class="row">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input trm_cond_checkbox" name="is_i_gst" id="is_i_gst" value="igst" {{ ($quote->i_gst)?'checked':'' }} {{ $quote->delivery_type == \App\Models\Admin\Quote::INTER_STATE?'':'disabled' }} />
                                <div style=" margin-top: 0px;margin-left: 16px;width: 130px;display: flex;">
                                    <label class="form-check-label" for="is_i_gst">
                                        IGST
                                    </label>
                                    <div class="form-group">
                                        <div class="displayFlex">
                                            <input type="text" class="form-control form-control-border" id="i_gst" name="i_gst" placeholder="IGST" value="{{ $defaultIGst }}" style=" margin-top: -4px; margin-left: 16px; " {{ $quote->delivery_type == \App\Models\Admin\Quote::INTER_STATE?'':'disabled' }}>
                                            <span>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check" style=" display: flex; ">
                                <input type="checkbox" class="form-check-input trm_cond_checkbox" id="is_c_s_gst" name="is_c_s_gst"  value="c_s_gst" {{ ($quote->c_gst || $quote->s_gst)?'checked':'' }} {{ $quote->delivery_type == \App\Models\Admin\Quote::INTRA_STATE?'':'disabled' }} />
                                <div style="margin-top: 0px;margin-left: 13px;width: 130px;display: flex;">
                                    <label class="form-check-label" for="is_c_s_gst">
                                        CGST
                                    </label>
                                    <div class="form-group">
                                        <div class="displayFlex">
                                            <input type="text" class="form-control form-control-border" id="c_gst" name="c_gst" placeholder="CGST" value="{{ $defaultCGst }}" style=" margin-top: -4px; margin-left: 16px; " {{ $quote->delivery_type == \App\Models\Admin\Quote::INTRA_STATE?  $configs['INTRASTATE']:'disabled' }} >
                                            <span>%</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 0px;margin-left: 44px;width: 130px;display: flex;">
                                    <label class="form-check-label" for="exampleCheck1">
                                        SGST
                                    </label>
                                    <div class="form-group">
                                        <div class="displayFlex">
                                            <input type="text" class="form-control form-control-border" id="s_gst" name="s_gst" placeholder="SGST"  value="{{ $defaultSGst }}" style=" margin-top: -4px; margin-left: 16px; " {{ $quote->delivery_type == \App\Models\Admin\Quote::INTRA_STATE?'':'disabled' }} >
                                            <span>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px">
                            <div class="form-check" style=" display: flex; ">
                                <input type="checkbox" class="form-check-input " id="is_amended" name="is_amended" {{ ($quote->amended_on)?'checked':'' }}>
                                <div style="margin-top: 0px;margin-left: 13px;width: 375px;display: flex;">
                                    <label class="form-check-label" for="is_amended">
                                        IS Amended?
                                    </label>
{{--                                    <div class="form-group">--}}
{{--                                        <input type="date" class="form-control form-control-border" id="amended_on" name="amended_on" placeholder="Amended On" value="{{ $quote->amended_on? $quote->amended_on : 0 }}"  style="display: {{ $quote->amended_on?'block': 'none' }};">--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <div style="margin-top: 0px;margin-left: -22px;width: 307px;display: flex;">
                                    <label class="form-check-label" for="freight" style="width:158px">
                                        Freight (<span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type] }}</span>)
                                    </label>
                                    <div class="form-group">
                                        <select class="form-control form-control-border" id="getFreightCharge" style=" width: 127px;">
                                            <option value="0"  {{ $quote->freight_type != '%'?'selected':'' }}>Fixed</option>
                                            <option value="%" {{ $quote->freight_type == '%'?'selected':'' }}>In %</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-border" id="freight_percentage" name="freight_percentage" value="{{ $quote->freight_percentage }}" placeholder="%"  style=" margin-top: -4px; margin-left: 16px; display: {{ $quote->freight_type == '%'?'block':'none' }}; ">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-border" id="freight" name="freight" placeholder="Freight"  value="{{ $quote->freight? $quote->freight : 0 }}" style=" margin-top: -4px; margin-left: 36px; ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <div style="margin-top: 0px;margin-left: -22px;width: 555px;display: flex;">
                                    <label class="form-check-label" for="freight" style="width:420px">
                                        Installation Charges (<span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type] }}</span>)
                                    </label>
                                    <div class="form-group">
                                        <select class="form-control form-control-border" id="getInstallationCharge" style="    width: 127px;">
                                            <option value="0"  {{ $quote->installation_type != '%'?'selected':'' }}>Fixed</option>
                                            <option value="%" {{ $quote->installation_type == '%'?'selected':'' }}>In %</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style=" margin-right: 30px; ">
                                        <input type="text" class="form-control form-control-border" id="percentage" name="percentage" placeholder="%" value="{{ $quote->installation_percentage }}" style=" margin-top: -4px; margin-left: 16px; display: {{ $quote->installation_type == '%'?'block':'none' }};">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-border" id="installation" name="installation" placeholder="Installation"  value="{{ $quote->installation? $quote->installation : 0 }}" style="margin-top: -4px;margin-left: 16px;width: 121px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <div style="margin-top: 0px;margin-left: -22px;width: 637px;display: flex;">
                                    <label class="form-check-label" for="warranty_note" style="width:420px">
                                        Warranty Note:
                                    </label>
                                    <div class="form-group" style=" margin-right: 30px; ">
                                        <textarea  class="form-control form-control-border" id="warranty_note" name="percentage" placeholder="Warranty Note" cols="220" rows="2">{{ $quote->warranty_note }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <div style="margin-top: 0px;margin-left: -22px;width: 637px;display: flex;">
                                    <label class="form-check-label" for="payment_terms" style="width:420px">
                                        Payment Terms:
                                    </label>
                                    <div class="form-group" style=" margin-right: 30px; ">
                                        <textarea  class="form-control form-control-border" id="payment_terms" name="payment_terms" placeholder="Payment Terms" cols="220" rows="2">{{ $quote->payment_terms }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <div style="margin-top: 0px;margin-left: -22px;width: 637px;display: flex;">
                                    <label class="form-check-label" for="validity" style="width:420px">
                                        Validity:
                                    </label>
                                    <div class="form-group" style=" margin-right: 30px; ">
                                        <textarea  class="form-control form-control-border" id="validity" name="validity" placeholder="Validity" cols="220" rows="2">{{ $quote->validity }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat" id="terms_condition_btn">Save</button>
                            </span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endif
    <tr class="table-summary">
        <td colspan="2" class="text-right" style="text-align: left !important;">
        </td>
        <td colspan="2" class="text-right">Sub Total</td>
        <td class="text-right">
            <strong>
                <span style="font-family: DejaVu Sans; sans-serif;">
                    @if($quote)
                        {{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$subPrice }}
                    @else
                        0
                    @endif
                </span>
            </strong>
            <br>
        </td>
        <input type="hidden" name="old_order_sub_total" id="old_order_sub_total" value="0">
        <td></td>
    </tr>
    @if($quote && $quote->discount > 0)
        @php
            $totalPrice = $totalPrice - $quote->discount;
        @endphp
        <tr class="table-summary">
            <td colspan="4" class="text-right">(-)Discount Applied {{ $quote->discount_percentage?"<strong>(".$quote->discount_percentage."%)</strong>":"" }}
                <i class="icofont icofont-info-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Rental/Buy/Sale Furniture Subtotal : $0<br>Sales Tax (10.25%) on Rental/Buy/Sale Furniture : $0<br>Total : $0" data-html="true"></i></td>
            <td class="text-right">
                <span style="font-family: DejaVu Sans; sans-serif;">
                    {{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$quote->discount }}
                </span>
            </td>
            <td>
                @php
                    $buttons = [
                        'trash' => [
                            'label' => 'Delete',
                            'attributes' => [
                                'href' => route('removeDiscount', ['quote_id' => $quote->id]),
                            ]
                        ]
                    ];
                @endphp
                {!! table_buttons($buttons, false) !!}
            </td>
        </tr>
    @endif

    <tr class="table-summary">
        <td colspan="4" class="text-right">
            Net total
        </td>
        <td class="text-right">
            <strong>
                <span style="font-family: DejaVu Sans; sans-serif;">
                {{ $quote?\App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$totalPrice:0 }}
                </span>
            </strong>
        </td>
        <td>

        </td>
    </tr>
    @if($quote->freight)
        @php
            $totalPrice = $totalPrice + $quote->freight;
        @endphp
    <tr class="table-summary">
        <td colspan="4" class="text-right">Freight:
            <br>
        </td>
        <td class="text-right">
            <strong>
                <span style="font-family: DejaVu Sans; sans-serif;">{{ $quote?\App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$quote->freight:0 }}</span>
            </strong>
        </td>
        <td>

        </td>
    </tr>
    @endif
    @if($quote->installation)
        @php
            $totalPrice = $totalPrice + $quote->installation;
        @endphp
    <tr class="table-summary">
        <td colspan="4" class="text-right">Installation Charges:
            <br>
        </td>
        <td class="text-right">
            <strong>
                <span style="font-family: DejaVu Sans; sans-serif;">
                {{ $quote?\App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$quote->installation:0 }}
                </span>
                <input type="hidden" value="{{ $totalPrice }}" id="totalOrderAmount">
            </strong>
        </td>
        <td>

        </td>
    </tr>
    @endif
    @if($quote->i_gst)
        @php
             $iGstTotal =  (($totalPrice * $quote->i_gst)/100);
        @endphp
    <tr class="table-summary">
        <td colspan="4" class="text-right">I GST <strong>({{ $quote?$quote->i_gst:0 }}%)</strong>:
            <br>
        </td>
        <td class="text-right">
            <strong>
               <span style="font-family: DejaVu Sans; sans-serif;">
                {{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].round($iGstTotal, 2) }}
               </span>
            </strong>
        </td>
        <td> </td>
    </tr>
    @endif
    @if($quote->c_gst)
        @php
            $cGSTTotal = (($totalPrice * $quote->c_gst)/100);
        @endphp
        <tr class="table-summary">
        <td colspan="4" class="text-right">C GST <strong>({{ $quote?$quote->c_gst:0 }}%)</strong>:
            <br>
        </td>
        <td class="text-right">
            <strong>
                <span style="font-family: DejaVu Sans; sans-serif;">
                    {{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].round($cGSTTotal,2) }}
                </span>
            </strong>
        </td>
        <td>

        </td>
    </tr>
    @endif
    @if($quote->s_gst)
        @php
            $sGSTTotal = (($totalPrice * $quote->s_gst)/100);
        @endphp
        <tr class="table-summary">
            <td colspan="4" class="text-right">S GST <strong>({{ $quote?$quote->s_gst:0 }}%)</strong>:
            <br>
        </td>
        <td class="text-right">
            <strong>
                <span style="font-family: DejaVu Sans; sans-serif;">
                    {{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].round($sGSTTotal, 2) }}
                </span>
            </strong>
        </td>
        <td></td>
    </tr>
    @endif

    @php
        $totalPrice += $iGstTotal + $cGSTTotal + $sGSTTotal;
    @endphp
    <tr class="table-summary">
        <td colspan="4" class="text-right">
            @if($quote->total_title)
                {{ $quote->total_title }}
            @else
                Total
            @endif
            <br>
        </td>
        <td class="text-right">
            <strong>
                <span style="font-family: DejaVu Sans; sans-serif;">
                {{ $quote?\App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$totalPrice:0 }}
                </span>
                <input type="hidden" value="{{ $totalPrice }}" id="totalOrderAmount">
            </strong>
        </td>
        <td>

        </td>
    </tr>
    <tr class="table-summary">
    </tr>
    </tbody>
</table>
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
</style>
