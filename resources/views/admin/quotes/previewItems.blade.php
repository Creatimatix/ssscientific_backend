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
    </tbody>
</table>
