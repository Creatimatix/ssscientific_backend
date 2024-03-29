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
        <!DOCTYPE  html>
<html lang="en">
<head>
        
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Delivery Note</title>
    <meta name="author" content="ssscientific"/>
    <style type="text/css">
  table {
        width: 100%;
    }

    p {
            color: black;
            text-decoration: none;
            font-size: 12pt;
            margin: 0pt;
            padding-left:5pt;
            line-height: 1.6;
        }
        h1 {
            color: black;
            text-decoration: none;
            font-size: 13pt;
        }
        .s1 {
            color: black;
            text-decoration: none;
            font-size: 12pt;
        }
        .s2 {
            color: black;
            text-decoration: none;
            font-size: 12pt;
        }

        td, th{
            width:15%;
            padding-left:5pt;
            font-size: 12pt;
        }

        .table-quotation, th, td {
            border: 1px solid black;
            border-spacing:0;
            table-layout:fixed;
        }

        /* tr:nth-child(2) { border: solid thin; } */

        .no-border{
            border:0px;
        }

        .no-top-border{
            border-top : 0px;
        }

        .no-bottom-border{
            border-bottom : 0px;
        }

        .left-align{
            text-align:left;
            padding-left:5pt;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }
        .text-right{
            text-align: right;
        }

        .text-top{
            vertical-align: text-top;
        }

        .top-grey-border{
            border-top : 2px solid #D3D3D3;
        }

        @page {
        size: A4;
        margin: 10px !important;
        padding: 0 !important;
        border-style:solid solid solid solid;
        /* margin: 10mm 10mm 10mm 10mm; */
            /* margin: 0; */
            border: solid;
            border-width: thin;
            overflow:hidden;
            display:block;
            box-sizing: border-box;    
        }

        body {
        font-size: 11px;
        /* background-image: url({{ public_path('images/logobg.png') }}); */
        height: 100%;
        width: 100%;
        background-size: cover;
        padding: 9px 0;
        z-index: 11;
        }

        #print-wrapper *{
            visibility:visible;
        }

  
        .Product_table {
                margin-top: 0px !important;
                                table-layout: fixed;
        }

        table {
            width: 90%;
        }

        td .addressinfo {
            line-height: 17px !important;
            font-size: 13px;
            padding: -2px;
        }

    </style>

</head>
<body>
        <p style="text-indent: 0pt;text-align: left; pading-top:-10px;">
        <span>
            <table cellspacing="0" cellpadding="0" class='center'>
            <tr>
                <td style="border: none;" colspan='3'>
{{--                    <p style="padding-top: 4pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">SS Scientific - {{ $totalItems }}</p>--}}
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Shop No. 11, Jamal
                        Mansion,<br>Dr, Meisheri Road, Dongri,<br>Mumbai - 400 009.</p>
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Maharashtra,<br>India</p>
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 9pt;text-align: left;">GST: {{ isset($configs['GST_NO']) }}</p>
                </td>
                <td style='text-align:right;border: none;' colspan='3'>
                    <img src="{{ public_path('images/quotation logo.png') }}" style="width:140px;height:120px;" />
                </td>
            </tr>
</table>
        </span>
        </p>
        <table  cellspacing="0" cellpadding="0" class='center no-border' style="width:90%">
            <tr class='no-border'>
                <th class='no-border'>&nbsp;</th>
            </tr>
            <tr>
                <th style="text-align:center;" colspan='6'>
                    Delivery Note
                    <!-- <h1 style="padding-top: 1pt;text-align:center; font-size:13pt">QUOTATION</h1> -->
                </th>
            </tr>
            <tr class='no-border'>
                <th class='no-border'>&nbsp;</th>
            </tr>
            <tr>
                <th colspan='3' class='left-align'>Bill To:</th>
                <th colspan='3' class='left-align'>Ship To:</th>
            </tr>

            <tr>
                <td colspan='3'>
                    <p>
                        {{ $quote->property_address }}
                    </p>
                </td>
                <td colspan='3'>
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
                <td colspan='3'>
                    <p>
                        Invoice No.:{{ $invoice->invoice_no }} <br />
                        Date: {{ date('d.m.y', strtotime($invoice->created_at)) }} <br />
                        GST No.: {{ isset($configs['GST_NO']) }} <br />
                        PAN No.: {{ isset($configs['PAN_NO']) }} <br />
                    </p>
                </td>
                <td colspan='3'>
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
                <td  class='no-border' colspan='6' style="font-size: 15px;line-height: 10px;display: table-cell;padding-bottom: 22px;">
                </td>
            </tr>
            <tr>
                <th>S/N</th>
                <th>P/N</th>
                <th colspan='3'>Description of goods</th>
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
                <td colspan='3'  class='text-left text-top' style="text-align:left">
                    <b>{{ $item->product->name }}</b>
                    <br />
                    {{ $item->product->short_description }}
                    <br />
                    <b>HSN Code:    {{ $item->product->hsn_no }}</b>
                </td>
                <td class="text-top text-right"><div style="margin-right:5px">{{ $item->quantity }}</div></td>
            </tr>
                @foreach($item->accessories as $aKey => $accessory)
                    @if($accessory->product)
                        @php
                            if($accessory->is_payable){
                                $subPrice += $accessory->asset_value * $accessory->quantity;
                                $totalAmount += $accessory->asset_value * $accessory->quantity;
                            }
                        @endphp
                        <tr style="text-align: center; outline: thin solid">
                            <td width="10px" style="padding: 0px 0px 100px 0px" class="top-grey-border text-top">{{ $itemKey.'.'.++$aKey }}</td>
                            <td class="top-grey-border text-top">{{ $accessory->product?$accessory->product->pn_no:'' }}</td>
                            <td colspan='3' class="top-grey-border text-left text-top" style="text-align:left">
                                <b>{{ $accessory->product->name }}</b>
                                <br />
                                {{ $accessory->product->short_description }}
                                <br />
                                @if(!$accessory->is_payable)
                                    <b>Not Payable</b>
                                @endif
                            </td>
                            <td class="top-grey-border text-right text-top"><div style="margin-right:5px">{{ $accessory->quantity }}</div></td>
                        </tr>
                    <!-- </div> -->
                    @endif
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
        </body>
</html>
    @endsection
