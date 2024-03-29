<?php
    $subPrice = 0;
    $totalPrice = 0;
    $iGstTotal = 0;
    $cGSTTotal = 0;
    $sGSTTotal = 0;

    $collape_type = 'collapsed-card';
    $collape_btn_type = 'fas fa-plus';

    if($quote->i_gst || $quote->s_gst || $quote->c_gst){
        $collape_type = '';
        $collape_btn_type = 'fas fa-minus';
    }
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
                    <div class="card-body">
                        <div class="row">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input trm_cond_checkbox" name="is_i_gst" id="is_i_gst" value="igst" {{ ($quote->i_gst)?'checked':'' }} {{ ($quote->c_gst || $quote->s_gst)?'checked':'' }} {{ $quote->delivery_type == \App\Models\Admin\Quote::INTRA_STATE?'':'disabled' }} />
                                <div style=" margin-top: 0px;margin-left: 16px;width: 130px;display: flex;">
                                    <label class="form-check-label" for="is_i_gst">
                                        IGST
                                    </label>
                                    <div class="form-group">
                                        <div class="displayFlex">
                                            <input type="text" class="form-control form-control-border" id="i_gst" name="i_gst" placeholder="IGST" value="{{ ($quote->i_gst)?$quote->i_gst:'' }}" style=" margin-top: -4px; margin-left: 16px; " {{ $quote->delivery_type == \App\Models\Admin\Quote::INTRA_STATE?'':'disabled' }}>
                                            <span>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check" style=" display: flex; ">
                                <input type="checkbox" class="form-check-input trm_cond_checkbox" id="is_c_s_gst" name="is_c_s_gst"  value="c_s_gst" {{ ($quote->c_gst || $quote->s_gst)?'checked':'' }} {{ $quote->delivery_type == \App\Models\Admin\Quote::INTER_STATE?'':'disabled' }} />
                                <div style="margin-top: 0px;margin-left: 13px;width: 130px;display: flex;">
                                    <label class="form-check-label" for="is_c_s_gst">
                                        CGST
                                    </label>
                                    <div class="form-group">
                                        <div class="displayFlex">
                                            <input type="text" class="form-control form-control-border" id="c_gst" name="c_gst" placeholder="CGST" value="{{ $quote->c_gst? $quote->c_gst : 0 }}" style=" margin-top: -4px; margin-left: 16px; " {{ $quote->delivery_type == \App\Models\Admin\Quote::INTER_STATE?'':'disabled' }} >
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
                                            <input type="text" class="form-control form-control-border" id="s_gst" name="s_gst" placeholder="SGST"  value="{{ $quote->s_gst? $quote->s_gst : 0 }}" style=" margin-top: -4px; margin-left: 16px; " {{ $quote->delivery_type == \App\Models\Admin\Quote::INTER_STATE?'':'disabled' }} >
                                            <span>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px">
                            <div class="form-check" style=" display: flex; ">
                                <input type="checkbox" class="form-check-input " id="is_amended" name="is_amended" {{ ($quote->amended_on || $quote->amended_on)?'checked':'' }}>
                                <div style="margin-top: 0px;margin-left: 13px;width: 375px;display: flex;">
                                    <label class="form-check-label" for="is_amended">
                                        IS Amended?
                                    </label>
                                    <div class="form-group">
                                        <input type="date" class="form-control form-control-border" id="amended_on" name="amended_on" placeholder="Amended On" value="{{ $quote->amended_on? $quote->amended_on : 0 }}"  style="display: {{ $quote->amended_on?'block': 'none' }};">
                                    </div>
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
                                            <option value="%" {{ $quote->freight_type == '%'?'selected':'' }}>Pecentage</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-border" id="freight_percentage" name="freight_percentage" value="{{ $quote->freight_percentage }}" placeholder="%"  style=" margin-top: -4px; margin-left: 16px; display: {{ $quote->freight_type == '%'?'block':'none' }}; ">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-border" id="freight" name="freight" placeholder="Freight"  value="{{ $quote->freight? $quote->freight : 0 }}" style=" margin-top: -4px; margin-left: 16px; ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <div style="margin-top: 0px;margin-left: -22px;width: 380px;display: flex;">
                                    <label class="form-check-label" for="freight" style="width:420px">
                                        Installation Charges (<span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type] }}</span>)
                                    </label>
                                    <div class="form-group">
                                        <select class="form-control form-control-border" id="getInstallationCharge" style="    width: 127px;">
                                            <option value="0"  {{ $quote->installation_type != '%'?'selected':'' }}>Fixed</option>
                                            <option value="%" {{ $quote->installation_type == '%'?'selected':'' }}>Pecentage</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style=" margin-right: 30px; ">
                                        <input type="text" class="form-control form-control-border" id="percentage" name="percentage" placeholder="%" value="{{ $quote->installation_percentage }}" style=" margin-top: -4px; margin-left: 16px; display: {{ $quote->installation_type == '%'?'block':'none' }};">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-border" id="installation" name="installation" placeholder="Installation"  value="{{ $quote->installation? $quote->installation : 0 }}" style=" margin-top: -4px; margin-left: 16px; ">
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
            <td colspan="4" class="text-right">(-)Discount Applied
                <i class="icofont icofont-info-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Rental/Buy/Sale Furniture Subtotal : $0<br>Sales Tax (10.25%) on Rental/Buy/Sale Furniture : $0<br>Total : $0" data-html="true"></i></td>
            <td class="text-right"><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$quote->discount }}</span></td>
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
        <td colspan="4" class="text-right">I GST:
            <br>
        </td>
        <td class="text-right">
            <strong>
                %{{ $quote?$quote->i_gst:0 }}
            </strong>
        </td>
        <td>
           <span style="font-family: DejaVu Sans; sans-serif;">
            {{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].round($iGstTotal, 2) }}
           </span>
        </td>
    </tr>
    @endif
    @if($quote->c_gst)
        @php
            $cGSTTotal = (($totalPrice * $quote->c_gst)/100);
        @endphp
    <tr class="table-summary">
        <td colspan="4" class="text-right">C GST Charges:
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
        <td colspan="4" class="text-right">S GST Charges:
            <br>
        </td>
        <td class="text-right">
            <strong>
                <span style="font-family: DejaVu Sans; sans-serif;">
                    {{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].round($sGSTTotal, 2) }}
                </span>
            </strong>
        </td>
        <td>

        </td>
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
