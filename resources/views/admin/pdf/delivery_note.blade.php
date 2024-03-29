@extends('layouts.pdf')
    @section('content')
        @php
            $totalAmount = 0;
            $subPrice = 0;
            $iGst = 0;
            $cGst = 0;
            $sGst = 0;
            $totalItems = count($quote->items);
            $itemKey = 0;
        @endphp
        <p style="text-indent: 0pt;text-align: left; pading-top:-10px;">
        <span>
            <table cellspacing="0" cellpadding="0" class='center'>
            <tr>
                <td style="border: none;">
{{--                    <p style="padding-top: 4pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">SS Scientific - {{ $totalItems }}</p>--}}
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Shop No. 11, Jamal
                        Mansion,<br>Dr, Meisheri Road, Dongri,<br>Mumbai - 400 009.</p>
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Maharashtra,<br>India</p>
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 9pt;text-align: left;">GST: {{ $configs['GST_NO'] }}</p>
                </td>
                <td style='text-align:right;border: none;'>
                    <img src="{{ public_path('images/quotation logo.png') }}" style="width:140px;height:120px;" />
                </td>
            </tr>
</table>
        </span>
        </p>
        <table class='center table-quotation no-border'>
            <tr class='no-border'>
                <th class='no-border'>&nbsp;</th>
            </tr>
            <tr>
                <th style="text-align:center;" colspan='8'>
                    Delivery Note
                    <!-- <h1 style="padding-top: 1pt;text-align:center; font-size:13pt">QUOTATION</h1> -->
                </th>
            </tr>
            <tr class='no-border'>
                <th class='no-border'>&nbsp;</th>
            </tr>
            <tr>
                <th colspan='4' class='left-align'>Bill To:</th>
                <th colspan='4' class='left-align'>Ship To:</th>
            </tr>

            <tr>
                <td colspan='4'>
                    <p>
                        {{ $quote->property_address }}
                    </p>
                </td>
                <td colspan='4'>
                    @php
                        $state  = $invoice->is_billing_address?$quote->user->state:$invoice->state;
                        $city  = $invoice->is_billing_address?$quote->user->city:$invoice->city;
                    @endphp
                    @if(!$invoice->is_billing_address)
                        <p>{{ $invoice->shipto_address }}</p>
                    @else
                        <p>{{ $quote->user->billing_address }}</p>
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan='4'>
                    <p>
                        Invoice No.:{{ $invoice->invoice_no }} <br />
                        Date: {{ date('d.m.y', strtotime($invoice->created_at)) }} <br />
                        GST No.: {{ $configs['GST_NO'] }} <br />
                        PAN No.: {{ $configs['PAN_NO'] }} <br />
                    </p>
                </td>
                <td colspan='4'>
                    <p>
                        P.O. No.: {{ $invoice->po_no }} <br />
                        Place Of Supply.: {{ $city }} <br />
                        @php
                            $gstNo = $quote->user->gst_no;
                            $stateCode = null;
                            if($gstNo){
                                $stateCode = str_split($gstNo,2);
                                $gstNo = $stateCode[0];
                            }
                        @endphp
                        State: {{ $state }} &nbsp;&nbsp;&nbsp; State Code: {{ $gstNo }} <br />
                        GST No.: {{ $quote->user->gst_no }} <br />
                    </p>
                </td>
            </tr>

            <tr>
                <td  class='no-border' colspan='8' style="font-size: 15px;line-height: 10px;display: table-cell;padding-bottom: 22px;">
                </td>
            </tr>
            <tr>
                <th>S/N</th>
                <th>P/N</th>
                <th colspan='2'>Description of goods</th>
                <th>Qty</th>
            </tr>
            @foreach($quote->items as $key => $item)
                @php
                    $itemKey = ++$key;
                    $totalAmount = $totalAmount + ($item->quantity * $item->asset_value);
                    $subPrice += $item->asset_value * $item->quantity;
                @endphp
            <!-- <div> -->
            <tr style="text-align: center;border: solid thin ">
                <td width="10px" style="padding: 0px 0px 100px 0px;" class='text-top'><b>{{ $itemKey }}</b></td>
                <td class='text-top'>{{ $item->product->pn_no }}</td>
                <td colspan='2'  class='text-left text-top' style="text-align:left">
                    <b>{{ $item->product->name }}</b>
                    <br />
                    {{ $item->product->short_description }}
                    <br />
                    <b>HSN Code:    {{ $item->product->hsn_no }}</b>
                </td>
                <td class="text-top text-right">{{ $item->quantity }}</td>
            </tr>
                @foreach($item->accessories as $aKey => $accessory)
                    @php
                        if($accessory->is_payable){
                            $subPrice += $accessory->asset_value * $accessory->quantity;
                            $totalAmount += $accessory->asset_value * $accessory->quantity;
                        }
                    @endphp
                    <tr style="text-align: center; outline: thin solid">
                        <td width="10px" style="padding: 0px 0px 100px 0px" class="top-grey-border text-top">{{ $itemKey.'.'.++$aKey }}</td>
                        <td class="top-grey-border text-top">{{ $accessory->product->pn_no }}</td>
                        <td colspan='2' class="top-grey-border text-left text-top" style="text-align:left">
                            <b>{{ $accessory->product->name }}</b>
                            <br />
                            {{ $accessory->product->short_description }}
                            <br />
                            @if(!$accessory->is_payable)
                                <b>Not Payable</b>
                            @endif
                        </td>
                        <td class="top-grey-border text-right text-top">{{ $accessory->quantity }}</td>
                    </tr>
                    <!-- </div> -->
                @endforeach
            @endforeach
        </table>
        <div id='footer' style="position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center; font-size:1.50em" ><b>Work Address:</b> 401, 4th floor, 3, Navjeevan Society, Dr. D. B. Marg, Mumbai Central, Mumbai  - 400 008. </br>
           <b>Email:</b> support@ssscientific.net / sales@ssscientific.net <b>Web:</b>  www.ssscientific.net  <b>Mob.:</b> +91 98332 41875</div>

        </span>
        </p>
    @endsection
