@php
    $totalAmount = 0;
    $subPrice = 0;
    $totalItems = count($model->items);
@endphp
    <!-- Repeatable -->
@if($model && $model->items)
    @foreach($model->items as $key => $item)
        @php
            $itemKey = ++$key;
            $totalAmount = $totalAmount + ($item->quantity * $item->asset_value);
            $subPrice += $item->asset_value * $item->quantity;
        @endphp
<!DOCTYPE  html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quotation</title>
    <meta name="author" content="ssscientific"/>
    <style type="text/css">
        /** {margin:0; padding:0; text-indent:0; }*/
        body {
            transform: scale(1.0);
            transform-origin: 0 0;

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
            width:10%;
            padding-left:5pt;
            font-size: 12pt;
        }

        .table-quotation, th, td {
            border: 1px solid black;
            border-spacing:0;
        }


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


        /*table, tbody {vertical-align: top; overflow: visible; }*/
    </style>
</head>
<body>
<p style="text-indent: 0pt;text-align: left; pading-top:-10px;">
        <span>
<table cellspacing="0" cellpadding="0" class='center'>
    <tr>
        <td style="border: none;">
            <p style="padding-top: 4pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">SS Scientific - {{ $totalItems }}</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Shop No. 11, Jamal
                Mansion,<br>Dr, Meisheri Road, Dongri,<br>Mumbai - 400 009.</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Maharashtra,<br>India</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 9pt;text-align: left;">GST: 27AYQPS9651P1Z2</p>
        </td>
        <td style='text-align:right;border: none;'>
        <img src="{{ public_path('images/quotation logo.png') }}" style="width:140px;height:120px;" />
        </td>
    </tr>
</table>
</span>
</p>

<table class='center table-quotation no-border'>
    <tr>
        <th style="text-align:center;" colspan='8'>
            QUOTATION
            <!-- <h1 style="padding-top: 1pt;text-align:center; font-size:13pt">QUOTATION</h1> -->
        </th>
    </tr>
    <tr class='no-border'>
        <th class='no-border'>&nbsp;</th>
    </tr>
    <tr>
        <th colspan='4' class='left-align'>To</th>
        <th colspan='4' class='left-align'></th>
    </tr>

    <tr>
        <td colspan='4'>
            <p>
                {{ $model->property_address }}
            </p>
        </td>
        <td colspan='4'>
            <p>{{ $model->shipto_address }}</p>
        </td>
    </tr>
    <tr>
        <td colspan='4'>
            <p>
                {{ $model->user->full_name }} <br />
                {{ $model->property_address }}
            </p>
        </td>
        <td colspan='4'>
            <p>QTN.No.: {{ $model->quote_no }}</p>
            @if($model->order_type == \App\Models\Admin\Quote::ORDER_TYPE_TENDOR)
                <p>Tendor No.: {{ $model->tendor_no }}</p>
                <p>Due Date: {{ date('d-m-Y', strtotime($model->due_date)) }}</p>
            @endif
        </td>
    </tr>

    <tr>
        <td class='no-border left-align' colspan='8' style=" font-size: 15px; line-height: 38px; ">ATTN: {{ $model->user->full_name }}</td>
    </tr>
    <tr>
        <td  class='no-border' colspan='8' style="font-size: 15px;line-height: 10px;display: table-cell;padding-bottom: 22px;">
            <span style="padding-right: 120px;float: left;">TEL: {{ $model->user->phone_number }}</span>
            <span style="padding-right: 13px;float: right;">Email: {{ $model->user->email }}</span>
        </td>
    </tr>
    <tr>
        <th>S/N</th>
        <th>P/N</th>
        <th>HSN Code</th>
        <th colspan='2'>Description of goods</th>
        <th>Qty</th>
        <th>Unit {{ $model->currency_type }}</th>
        <th>Amount {{ $model->currency_type }}</th>
    </tr>

    <tr style="text-align: center">
        <td width="10px" style="padding: 100px 0px 100px 0px;" class=''><b>{{ $itemKey }}</b></td>
        <td class=''>{{ $item->product->pn_no }}</td>
        <td class=''>{{ $item->product->hsn_no }}</td>
        <td colspan='2'  class='text-left'>
            <b>{{ $item->product->name }}</b>
            <br />
            <div class='text-center'>
                @if($item->product)
                    @foreach($item->product->images as $image)
                        <img src="{{ storage_path('images/products/'.$image->image_name) }}" style="width:80px;height:60px;" />
                    @endforeach
                @endif
            </div>
            <br />
            {{ $item->product->short_description }}
        </td>
        <td class="text-top text-right">{{ $item->quantity }}</td>
        <td class="text-top text-right"><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].($item->asset_value) }}</span></td>
        <td class="text-top text-right"><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].($item->quantity * $item->asset_value) }}</span></td>
    </tr>
    @foreach($item->accessories as $aKey => $accessory)
        @php
            if($accessory->is_payable){
                $subPrice += $accessory->asset_value * $accessory->quantity;
                $totalAmount += $accessory->asset_value * $accessory->quantity;
            }
        @endphp
        <tr style="text-align: center; outline: thin solid">
            <td width="10px" style="padding: 10px 0px 10px 0px" class="top-grey-border">{{ $itemKey.'.'.++$aKey }}</td>
            <td class="top-grey-border">{{ $accessory->product->pn_no }}</td>
            <td class="top-grey-border">{{ $accessory->product->hsn_no }}</td>
            <td colspan='2' class="top-grey-border text-left">
                <b>{{ $accessory->product->name }}</b>
                <br />
                {{ $accessory->product->short_description }}
            </td>
            <td class="top-grey-border">{{ $accessory->quantity }}</td>
            <td class="text-top text-right top-grey-border" ><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].($accessory->quantity * $accessory->asset_value) }}</span></td>
            <td class="text-top text-right top-grey-border">
                @if($accessory->is_payable)
                    <span style="font-family: DejaVu Sans; sans-serif;">
                {{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].($accessory->quantity * $accessory->asset_value) }}
                    </span>
                @endif
            </td>
        </tr>
    @endforeach
    <!-- repeatable -->
@if($key++ == $totalItems)
    <tr>
        <td colspan='4'>
            <p class="addressinfo"><b>Bank Account Details:</b></p>
            <p class="addressinfo">UNION BANK OF INDIA</p>
            <p class="addressinfo">WADALA (EAST) BRANCH</p>
            <p class="addressinfo">JUPITER BLDG., WADALA (EAST)</p>
            <p class="addressinfo">SHANKARMISTRY ROAD,</p>
            <p class="addressinfo">MUMBAI - 400037</p>
            <p class="addressinfo">A/C No.: 583505080000001</p>
            <p class="addressinfo">IFSC: UBIN0558354</p>
        </td>
        <td colspan='4'>
            <p class="addressinfo"><b>Place the Order to:</b></p>
            <p class="addressinfo">S. S Scientific</p>
            <p class="addressinfo">Shop No. 11, Jamal Mansion,</p>
            <p class="addressinfo">Navroji Hill Road No. 1, Dongri,</p>
            <p class="addressinfo">Mumbai - 400 009</p>
            <p class="addressinfo">Contact No.: Suresh Samala</p>
            <p class="addressinfo">Email: ssuresh@ssscientific.net</p>
            <p class="addressinfo">Mobile No.: +91 9833241875</p>
        </td>
    </tr>
    @php
        $finalTotal = $totalAmount;
        if($model->discount){
            $finalTotal = $finalTotal - $model->discount;
        }

        if($model->freight){
            $finalTotal = $finalTotal + $model->freight;
        }
        if($model->installation){
            $finalTotal = $finalTotal + $model->installation;
        }

        if($model->i_gst){
            $finalTotal = $finalTotal + (($finalTotal * $model->i_gst)/100);
        }
        if($model->c_gst){
            $finalTotal = $finalTotal + (($finalTotal * $model->c_gst)/100);
        }
        if($model->s_gst){
            $finalTotal = $finalTotal + (($finalTotal * $model->s_gst)/100);
        }

        $finalTotal = round($finalTotal, 2);
    @endphp
    <tr>
        <td colspan='3' class='no-border' >Payment Terms:</td>
        <td colspan='3' class='no-border text-right'>Ex-Warehouse</td>
        <td colspan='2'><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$totalAmount }}</span></td>
    </tr>
    @if($model->discount > 0)
        <tr>
            <td colspan='3' class='no-border' >Delivery Period:</td>
            <td colspan='3' class='no-border text-right'>Discount Applied</td>
            <td colspan='2'><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$model->discount }}</span></td>
        </tr>
    @endif
    <tr>
        <td colspan='3' class='no-border' >Installation: <span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$model->installation }}</span></td>
        <td colspan='3' class='no-border text-right'>{{($model->i_gst > 0 ? "IGST" : "CGST")}} </td>
        <td colspan='2'>{{($model->i_gst > 0 ? $model->i_gst : $model->c_gst)}}%</td>
    </tr>
    <tr>
        <td colspan='3' class='no-border' >Freight: <span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$model->freight }}</span></td>
        <td colspan='3' class='no-border text-right'>{{($model->s_gst > 0 ? "SGST" : "")}}</td>
        <td colspan='2'>{{($model->s_gst > 0 ? $model->s_gst."%" : "")}}</td>

    </tr>
    <tr>
        <td colspan='3' class='no-border' >Validity - 90 Days</td>
        <td colspan='3' class='no-border text-right'>TOTAL FOR, DESTINATION</td>
        <td colspan='2' class=''><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$finalTotal }}</span></td>
    </tr>
    <tr>
        <td colspan='8' class='left-align no-border'>
    </br>
            For, S. S SCIENTIFIC</br>
            <img width="130" height="85" src="{{ public_path('images/proposal-pdf/stamp.png') }}"/></br>
            AUTHORIZED SIGNATORY
        </td>
    </tr>
    @endif
</table>
</span>
</p>
<style>
    @page {
        size: A4;
        margin: 0px !important;
        padding: 0 !important
    }
    @font-face {
        font-family: 'Poppins';
        font-weight: normal;
        src: url({{ storage_path('fonts/poppins/poppins.ttf') }}) format("truetype");
    }
    @font-face {
        font-family: 'Poppins Light';
        font-weight: normal;
        src: url({{ storage_path('fonts/poppins/Poppins-Light.ttf') }}) format("truetype");
    }
    @font-face {
        font-family: 'Poppins Medium';
        font-weight: 500;
        src: url({{ storage_path('fonts/poppins/poppins-medium.ttf') }}) format("truetype");
    }
    @font-face {
        font-family: 'Poppins SemiBold';
        font-weight: 600;
        src: url({{ storage_path('fonts/poppins/Poppins-SemiBold.ttf') }}) format("truetype");
    }
    @font-face {
        font-family: 'Poppins Bold';
        font-weight: 700;
        src: url({{ storage_path('fonts/poppins/Poppins-Bold.ttf') }}) format("truetype");
    }
    @font-face {
        font-family: 'Poppins ExtraBold';
        font-weight: 800;
        src: url({{ storage_path('fonts/poppins/poppins-extra-bold.ttf') }}) format("truetype");
    }
    body {
        font-size: 11px;
{{--        background-image: url({{ public_path('images/proposal-pdf/sss.png') }});--}}
        /* height: 100%;
        width: 100%; */
        background-size: cover;
        padding: 9px 0;
        z-index: 11;
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
</body>
</html>
      @endforeach
   @endif
