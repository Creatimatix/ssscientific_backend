<!DOCTYPE  html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ (request()->get('invoiceType') == \App\Models\Admin\Invoice::INVOICE)?"INVOICE":"PROFORMA INVOICE" }} </title>
    <meta name="author" content="ssscientific"/>
    <style type="text/css">
        /** {margin:0; padding:0; text-indent:0; }*/
        p {
            color: black;
            text-decoration: none;
            font-size: 10pt;
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
            font-size: 10pt;
        }
        .s2 {
            color: black;
            text-decoration: none;
            font-size: 10pt;
        }
        td, th{
            width:10%;
            padding-left:5pt;
            font-size: 10pt;
        }
        .table-quotation, th, td {
            border: 1px solid black;
            border-spacing:0;
        }
        .no-border{
            border:0px;
        }
        .left-align{
            text-align:left;
            padding-left:5pt;
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }
        /*table, tbody {vertical-align: top; overflow: visible; }*/
    </style>
</head>
<body>
<p style="text-indent: 0pt;text-align: left;">
    <span>
        <table cellspacing="0" cellpadding="0" class='center'>
            <tr>
                <td style="border: none;">
                    <p style="padding-top: 4pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">SS Scientific</p>
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Shop No. 11, Jamal
                        Mansion, Dr,<br> Meisheri Road, Dongri, Mumbai - 400 009.</p>
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Maharashtra, India</p>
                    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 9pt;text-align: left;">GST: 27AYQPS9651P1Z2</p>
                </td>
            </tr>
        </table>
    </span>
</p>
<h1 style="padding-top: 1pt;text-align:center; font-size:13pt">{{ (request()->get('invoiceType') == \App\Models\Admin\Invoice::INVOICE)?"INVOICE":"PROFORMA INVOICE" }}</h1>
<p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<table class='center table-quotation'>
    <tr>
        <th colspan='4' class='left-align'>BILL TO</th>
        <th colspan='4' class='left-align'>SHIP TO</th>
    </tr>

    <tr>
        <td colspan='4'>
            <p>
                {{ $invoice->invoice_no }} <br />
                Date: {{date('d-m-Y', strtotime($invoice->created_at)) }} <br />
                GST NO: {{ $invoice->gst_no  }} <br />
                PAN NO: {{ $invoice->pan_no  }} <br />
            </p>
        </td>
        <td colspan='4'>
            <p>P.O. No.: {{ $invoice->po_no }}</p>
            <p>Place of Supply: {{ $model->property_address }}</p>
            <p>CUSTOMER GST NO.: XYZ00021</p>
{{--            @if($invoice->purchaseOrder->vendor)--}}
{{--                <p>Vendor Code: {{ $invoice->purchaseOrder->vendor->vendor_code }}</p>--}}
{{--            @endif--}}
        </td>
    </tr>
    <tr>
        <td class='no-border left-align' colspan='8' style=" font-size: 15px; line-height: 38px; ">CONTACT PERSON: {{ $model->user->full_name }}</td>
    </tr>
    <tr>
        <td  class='no-border' colspan='8' style="font-size: 15px;line-height: 10px;display: table-cell;padding-bottom: 22px;">
            <span style="padding-right: 120px;float: left;">MOBILE: {{ $model->user->phone_number }}</span>
            <span style="padding-right: 13px;float: right;">Email:{{ $model->user->email }}</span>
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

    @php
        $totalAmount = 0;
        $subPrice = 0;
        $finalTotal = 0;
        $iGst = 0;
        $cGst = 0;
        $sGst = 0;
    @endphp

    <!-- Repeatable -->
    @if($model && $model->items)
        @foreach($model->items as $key => $item)
            @php
                $itemKey = ++$key;
                $totalAmount = $totalAmount + $item->asset_value;
            @endphp
            <tr style="text-align:center">
                <td width="10px">{{ $itemKey }}</td>
                <td>{{ $item->product->pn_no }}</td>
                <td>{{ $item->product->hsn_no }}</td>
                <td colspan='2' style="text-align: center">
                    {{ $item->product->name }}
                    <br />
                    @if($item->product)
                        @foreach($item->product->images as $image)
                            <img src="{{ public_path('images/products/'.$image->image_name) }}" style="width:80px;height:60px" />
                        @endforeach
                    @endif
                    <br />
                    {{ $item->product->short_description }}
                </td>
                <td>{{ $item->quantity }}</td>
                <td><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$item->asset_value }}</span></td>
                <td><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$item->asset_value }}</span></td>
            </tr>
            @foreach($item->accessories as $aKey => $accessory)
                @php
                    if($accessory->is_payable){
                        $subPrice += $accessory->asset_value * $accessory->quantity;
                        $totalAmount += $accessory->asset_value * $accessory->quantity;
                    }
                @endphp
                <tr style="text-align: center; outline: thin solid">
                    <td width="10px" style="padding: 0px 0px 10px 0px" class="top-grey-border text-top">{{ $itemKey.'.'.++$aKey }}</td>
                    <td class="top-grey-border text-top">{{ $accessory->product->pn_no }}</td>
                    <td class="top-grey-border text-top">{{ $accessory->product->hsn_no }}</td>
                    <td colspan='2' class="top-grey-border text-left text-top">
                        <b>{{ $accessory->product->name }}</b>
                        <br />
                        {{ $accessory->product->short_description }}
                    </td>
                    <td class="top-grey-border text-right text-top">{{ $accessory->quantity }}</td>
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
        @endforeach
    @endif
    <!-- repeatable -->

    <tr>
        <td colspan='8'>
            <p>Bank Account Details<br>
                UNION BANK OF INDIA<br>
                WADALA (EAST) BRANCH<br>
                JUPITER BLDG., WADALA (EAST)<br>
                SHANKARMISTRY ROAD,<br>
                MUMBAI - 400037<br>
                A/C No.: 583505080000001<br>
                IFSC: UBIN0558354<br>
            </p>
        </td>
    </tr>

    <tr>
        <td colspan='4'>

        </td>
        <td colspan='4'>
            <table class="innerInfoTable" style="text-align: right;height: 194px;width: 100%;border-spacing: 0px;">
                <tr>
                    <td colspan='6' class='no-border' >TOTAL EX-WORKS</td>
                    <td colspan="10"><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$totalAmount }}</span></td>
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
                        $iGst =(($finalTotal * $model->i_gst)/100);
                    }
                    if($model->c_gst){
                        $cGst =(($finalTotal * $model->c_gst)/100);
                    }
                    if($model->s_gst){
                        $sGst =(($finalTotal * $model->s_gst)/100);
                    }
                    $finalTotal += $iGst + $cGst + $sGst;

                @endphp
                @if($model->i_gst)
                <tr>
                    <td colspan='6' class='no-border' >IGST ({{ $model->i_gst }}%)</td>
                    <td colspan="10"> - {{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$iGst }}</td>
                </tr>
                @endif
                @if($model->c_gst)
                <tr>
                    <td colspan='6' class='no-border' >CGST ({{ $model->c_gst }}% )</td>
                    <td colspan="10">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$cGst }}</td>
                </tr>
                @endif
                @if($model->s_gst)
                <tr>
                    <td colspan='6' class='no-border' >SGST ({{ $model->s_gst }}%)</td>
                    <td colspan="10"> {{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$sGst }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan='6' class='no-border' >TOTAL</td>
                    <td colspan="10"><span style="font-family: DejaVu Sans; sans-serif;"> {{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$finalTotal }}</span></td>
                </tr>
                <tr>
                    <td colspan='6' class='no-border' >TOTAL ROUNDED OFF</td>
                    <td colspan="10"><span style="font-family: DejaVu Sans; sans-serif;"> {{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$finalTotal }}</span></td>
                </tr>
            </table>
        </td>
    </tr>

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
        font-size: 10px;
        {{--background-image: url({{ public_path('images/proposal-pdf/sss.png') }});--}}
        /* height: 100%;
        width: 100%; */
        background-size: cover;
        padding: 90px 0;
        z-index: 11;
    }
    table {
        width: 90%;
    }

    .innerInfoTable tr td:nth-child(even) {
        text-align: left !important;
    }
</style>
</body>
</html>
