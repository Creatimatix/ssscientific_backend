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
        <th colspan="">
            Product
        </th>
        <th class="text-left" style="width: 75px">
            Qty
        </th>
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
                {{ $item->product->name }}
            </td>
            <td>{{ $item->quantity }}</td>
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
                    <input type="checkbox" name="is_payable" id="is_payable" class="is_payable" data-id="{{ $accessory->id }}" {{ $accessory->is_payable?'checked': '' }} disabled />
                </td>
                <td>
                    {{ $itemKey.'.'.++$aKey }}  {{ $accessory->product->name }}
                </td>
                <td>{{ $accessory->quantity }}</td>
            </tr>
        @endforeach
    @endforeach
    @if($quote && $quote->discount > 0)
        @php
            $totalPrice = $totalPrice - $quote->discount;
        @endphp
        <tr class="table-summary">
            <td colspan="2" class="text-right">(-)Discount Applied
                <i class="icofont icofont-info-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Rental/Buy/Sale Furniture Subtotal : $0<br>Sales Tax (10.25%) on Rental/Buy/Sale Furniture : $0<br>Total : $0" data-html="true"></i></td>
            <td class="text-right"><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$quote->currency_type].$quote->discount }}</span></td>
        </tr>
    @endif
    @if($quote->freight)
        @php
            $totalPrice = $totalPrice + $quote->freight;
        @endphp
        <tr class="table-summary">
            <td colspan="2" class="text-right">Freight:
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
            <td colspan="2" class="text-right">Installation Charges:
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
            <td colspan="2" class="text-right">I GST:
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
            <td colspan="2" class="text-right">C GST Charges:
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
            <td colspan="2" class="text-right">S GST Charges:
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
    </tbody>
</table>
