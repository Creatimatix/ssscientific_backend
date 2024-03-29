<!DOCTYPE  html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Purchase Order</title>
    <meta name="author" content="ssscientific"/>
    <style type="text/css">
        /** {margin:0; padding:0; text-indent:0; }*/
        body{
            transform: scale(1.0);
            transform-origin: 0 0;
            background-image: url("{{ public_path('images/logobg.png') }}");
            background-size: cover;
            background-position: center;
        }
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
        <td style="border: none; font-size:1.50em">
            <p style="padding-top: 4pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">SS Scientific</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Shop No. 11, Jamal
                Mansion, Dr,<br> Meisheri Road, Dongri, Mumbai - 400 009.</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Maharashtra, India</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 9pt;text-align: left;">GST: 27AYQPS9651P1Z2</p>
        </td>
        <td style='text-align:right;border: none;'>
        <img src="{{ public_path('images/quotation logo.png') }}" style="width:140px;height:120px;" />
        </td>
    </tr>
</table>
</span>
</p></br>
<h1 style="padding-top: 1pt;text-align:center; font-size:13pt">PURCHASE ORDER</h1>
<p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
<p style="text-indent: 0pt;text-align: left;"><br/></p>
<table class='center table-quotation' style="table-layout:fixed; height : 80vh;">
    <tr>
        <th colspan='4' class='left-align'>To</th>
        <th colspan='4' class='left-align'></th>
    </tr>

    <tr>
        <td colspan='4'>
            <p>
                {{ $purchaseOrder->vendor->full_name }} <br />
            </p>
        </td>
        <td colspan='4'>
            <p>PO.No.: {{ $purchaseOrder->po_no }}</p>
            <p>Date : {{ date('d-m-Y',strtotime($purchaseOrder->created_at)) }}</p>
        </td>
    </tr>


    <tr style="border:0px !important;">
        <td class='no-border left-align' colspan='8' style=" font-size: 15px; line-height: 38px; ">Kind ATTN.: {{ $purchaseOrder->attn_no }}</td>
    </tr>
    <tr>
        <td  class='no-border' colspan='8' style="font-size: 15px;line-height: 10px;display: table-cell;padding-bottom: 22px;">
            <span style="padding-right: 120px;float: left;">MOBILE: {{ $purchaseOrder->vendor->phone_number }}</span>
            <span style="padding-right: 13px;float: right;">Email:{{ $purchaseOrder->vendor->email }}</span>
        </td>
    </tr>


    <tr>
        <th>S/N</th>
        <th>P/N</th>
        <th>HSN Code</th>
        <th colspan='2'>Description of goods</th>
        <th>Qty</th>
        <th>Unit</th>
        <th>Amount</th>
    </tr>

    <!-- Repeatable -->
    @if($purchaseOrder && $purchaseOrder->products)
        @foreach($purchaseOrder->products as $key => $product)
            <tr style="text-align:center">
                <td width="10px">{{ ++$key }}</td>
                <td>{{ $product->product->pn_no }}</td>
                <td>{{ $product->product->hsn_no }}</td>
                <td colspan='2'>{{ $product->product->name }}
                    <!-- <br /> -->
                    <!-- @if($product->product->images)
                        @foreach($product->product->images as $image)
                            <img src="{{ public_path('images/products/'.$image->image_name) }}" style="width:80px;height:60px" />
                        @endforeach
                    @endif -->
                </td>
                <td>1</td>
                <td>{{ $product->product->sale_price }}</td>
                <td>{{ $product->product->sale_price*2 }}</td>
            </tr>
        @endforeach
    @endif
    <!-- repeatable -->

    <tr>
        <td colspan='8'>
            {!! $purchaseOrder->terms_n_condition !!}
        </td>
    </tr>

    <tr>
        <td colspan='8' class='left-align no-border' style="bottom: 20px;">
            <br>
            For, S. S SCIENTIFIC</br>
            <img width="130" height="85" src="{{ public_path('images/proposal-pdf/stamp.png') }}"/></br>
            AUTHORIZED SIGNATORY
        </td>
    </tr>
</table>
<div id='footer' style="position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center; font-size:12pt" ><b>Work Address:</b> 401, 4th floor, 3, Navjeevan Society, Dr. D. B. Marg, Mumbai Central, Mumbai  - 400 008. </br>
           <b>Email:</b> support@ssscientific.net / sales@ssscientific.net <b>Web:</b>  www.ssscientific.net  <b>Mob.:</b> +91 98332 41875</div>

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
    td{
        height:40px;
    }
</style>
</body>
</html>
