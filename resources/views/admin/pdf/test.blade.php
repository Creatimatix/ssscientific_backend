@extends('admin.layouts.proposal-pdf', ['title' => 'Proposal','layout' => $layout])
@section('content')
    @if(!$model)
        <div><h1>Proposal Not generated,Please generate proposal first</h1></div>
    @else
        <div id="firstPage" class="commonPageCss">
            <div class="container">
                <div class="row margin-top-40">
                    <img src="{{ public_path('images/proposal-pdf/pdf-logo.png')  }}" style="width: 600px; height: auto" class="logo">
                </div>
                <div class="row" style="margin-top: 40px;margin-left: 40px;margin-right: 0;margin-bottom: 0">
                    <h2 class="extra-bold" style="font-size: 75px;color: #fff;">
                        DESIGNS THAT INSPIRE
                        <span style="font-size: 20px; vertical-align: top;padding-top: 20px">TM</span></h2>

                </div>
                <div class="row" style="font-size: 25px;margin-left: 15px;">
                    <ul class="main--list">
                        <li>Home Staging</li>
                        <li>Furniture Sales</li>
                        <li>Furniture Rental</li>
                    </ul>
                </div>
                <div class="row margin-top-40" style="padding:0;width: 100%;background-color: #fff;border-bottom-right-radius: 150px;">

                    <p style="color: #3a5a66; font-size: 30px;margin-left: 50px;padding-right: 50px;padding-bottom: 50px; line-height: 25px">
                        You can only sell your home once, don't leave money on table!
                    </p>
                </div>
                <p style="position: absolute;bottom: -50px;margin-left: 50px;color: #fff;font-size: 20px;">www.ssscientific.com</p>

            </div>
        </div>
        <div class="pdf-content">
            <div class="add--margin">
                <table class="row page_break" style="width: 100%">
                    <td>
                        <p style="margin: 0;padding: 0">
                            SS Scientific<br />
                            Shop No. 11, Jamal Mansion,<br />
                            Dr, Meisheri Road, Dongri,<br />
                            Mumbai - 400 009.<br />
                            Maharashtra, India<br />
                            GST: 27AYQPS9651P1Z2
                        </p>
                    </td>
                </table>
                <table class="row quoteTable margin-top-20" style="width: 100%;border: 1px solid #000000"  cellpadding="0" cellspacing="0">
                    <tr class="heading" style="border: 1px solid #000000">
                        <td style="width:25%;border: 1px solid #000000;padding: 10px;">
                            To
                        </td>
                        <td style="width:25%;border: 1px solid #000000;padding: 10px;"></td>
                    </tr>
                    <tr class="heading" style="border: 1px solid #000000">
                        <td style="border: 1px solid #000000;padding: 10px;">
                            <span class="">
                                <?php
                                    $firstName = 'N/A';
                                    if($model && $model->user){
                                        $firstName = $model->user->first_name;
                                    }
                                    ?>
                                Dear {{ $firstName }},
                            </span>
                            <span>
                                {{ $model?$model->property_address:'' }}
                            </span>
                        </td>
                        <td style="border: 1px solid #000000;padding: 10px;">
                            QTN.No.: {{ $model?$model->quote_no:'NA' }} <br /> <br />
                            Date: {{ date("d-m-Y", strtotime($model->created_at)) }}
                        </td>
                    </tr>
                </table>
                <table class="row quoteTable" style="width: 100%;margin-top: 13px !important;margin-left: -13px;" >
                    <tr class="heading" style="">
                        <td colspan="2" style="width:25%;padding: 10px;">
                            CONTACT PERSON: {{ $model->user->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%;padding: 10px;">
                            MOBILE: {{ $model->phone_number }}
                        </td>
                        <td style="padding: 10px;">
                            Email: {{ $model->email }}
                        </td>
                    </tr>
                </table>
                <table class="row quoteTable" style="width: 100%;border: 1px solid #000000;margin-top: 13px !important;"  cellpadding="0" cellspacing="0">
                    <tr class="heading" style="border: 1px solid #000000">
                        <td width="10%" style="border: 1px solid #000000;padding: 10px;"> S/N  </td>
                        <td width="10%" style="border: 1px solid #000000;padding: 10px;"> P/N  </td>
                        <td width="10%" style="border: 1px solid #000000;padding: 10px;"> HSN Code  </td>
                        <td width="40%" style="border: 1px solid #000000;padding: 10px;"> Description of goods </td>
                        <td width="10%" style="border: 1px solid #000000;padding: 10px;"> Qty </td>
                        <td width="10%" style="border: 1px solid #000000;padding: 10px;"> Unit {{ $model->currency_type }} </td>
                        <td width="10%" style="border: 1px solid #000000;padding: 10px;"> Amount {{ $model->currency_type }} </td>
                    </tr>
                    @if($model && $model->items)
                        @foreach($model->items as $item)
                            <tr class="heading" style="border: 1px solid #000000">
                                <td style="border: 1px solid #000000;padding: 10px;">
                                    Quotation Info
                                </td>
                                <td style="border: 1px solid #000000;padding: 10px;">
                                    Quotation Info
                                </td>
                                <td style="border: 1px solid #000000;padding: 10px;">
                                    Quotation Info
                                </td>
                                <td style="border: 1px solid #000000;padding: 10px;">
                                    {{ $item->product->name }}
                                </td>
                                <td style="border: 1px solid #000000;padding: 10px;">
                                    {{ $item->quantity }}
                                </td>
                                <td style="border: 1px solid #000000;padding: 10px;">
                                    {{ $item->asset_value }}
                                </td>
                                <td style="border: 1px solid #000000;padding: 10px;">
                                    {{ $item->asset_value }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
                <table class="row page_break" style="width: 100%;border: 1px solid #000000"  cellpadding="0" cellspacing="0">
                    <tr class="heading" style="border: 1px solid #000000">
                        <td style="border: 1px solid #000000;padding: 10px;">
                            <p class="">
                                Bank Account Details:<br/>
                                UNION BANK OF INDIA<br/>
                                WADALA (EAST) BRANCH<br/>
                                JUPITER BLDG., WADALA (EAST)<br/>
                                SHANKARMISTRY ROAD,<br/>
                                MUMBAI - 400037<br/>
                                A/C No.: 583505080000001<br/>
                                IFSC: UBIN0558354
                            </p>
                        </td>
                        <td style="border: 1px solid #000000;padding: 10px;">
                            Place the Order to:<br/>
                            S. S Scientific<br/>
                            Shop No. 11, Jamal Mansion,<br/>
                            Navroji Hill Road No. 1, Dongri,<br/>
                            Mumbai - 400 009<br/>
                            Contact No.: Suresh Samala<br/>
                            Email: ssuresh@ssscientific.net<br/>
                            Mobile No.: +91 9833241875
                        </td>
                    </tr>
                </table>
                <table class="row quoteTable" style="width: 100%;" cellpadding="0" cellspacing="0">
                    <tr class="heading">
                        <td style="">
                            Payment Terms:
                        </td>
                        <td style="text-align: right">
                            <table class="row quoteInnerTable"  cellpadding="0" cellspacing="0">
                                <tr class="heading">
                                    <td style="text-align: right;">
                                        Ex-Warehouse
                                    </td>
                                    <td style="border: 1px solid;padding: 5px;width: 85px;">

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="heading">
                        <td style="">
                            Delivery Period:
                        </td>
                        <td style="text-align: right">
                            <table class="row quoteInnerTable"  cellpadding="0" cellspacing="0">
                                <tr class="heading">
                                    <td style="text-align: right;">
                                        IGST 18%
                                    </td>
                                    <td style="border: 1px solid;padding: 5px;width: 85px;">

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="heading">
                        <td style="">
                            Installation:
                        </td>
                        <td style="text-align: right">
                            <table class="row quoteInnerTable"  cellpadding="0" cellspacing="0">
                                <tr class="heading">
                                    <td style="text-align: right;">
                                        CGST
                                    </td>
                                    <td style="border: 1px solid;padding: 5px;width: 85px;">

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="heading">
                        <td style="">
                            Freight:
                        </td>
                        <td style="text-align: right">
                            <table class="row quoteInnerTable"  cellpadding="0" cellspacing="0">
                                <tr class="heading">
                                    <td style="text-align: right;">
                                        SGST
                                    </td>
                                    <td style="border: 1px solid;padding: 5px;width: 85px;">

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="heading">
                        <td style="">
                            Validity - 90 Days
                        </td>
                        <td style="text-align: right">
                            <table class="row quoteInnerTable"  cellpadding="0" cellspacing="0">
                                <tr class="heading">
                                    <td style="text-align: right;">
                                        TOTAL FOR, DESTINATION
                                    </td>
                                    <td style="border: 1px solid;padding: 5px;width: 85px;">

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="row quoteTable" style="width: 100%;margin-top: 13px !important;margin-left: -13px;" >
                    <tr class="heading" style="">
                        <td style="width:25%;padding: 10px;">
                            For, S. S SCIENTIFIC
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%;padding: 10px;">
                            <img src="{{ public_path('images/proposal-pdf/stamp.png')  }}" style="width: 100px; height: 100px" class="stamp">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
    <style>

        @page {
            size: A4;
            margin: 0;
            padding: 0;
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

        #firstPage {
            font-family: 'Poppins Medium';
            background-image: url({{ public_path('images/proposal-pdf/pdf-bg.png') }}) !important;
            font-weight: 500;
        }

        .commonPageCss {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            height: 150%;
            width: 100%;
            background-size: cover !important;
            z-index: 111;
            padding: 0 !important;
            margin: 0 !important;
        }

        body {
            font-size: 10px;
            background-image: url({{ public_path('images/proposal-pdf/deck.jpg') }});
            height: 100%;
            width: 100%;
            background-size: cover;
            padding: 70px 0;
            z-index: 11;
        }

        table.collapse-border {
            border: 1px solid black;
            border-collapse: collapse;
        }


        .main--list {
            list-style-type:  disc;
            color: #fff;
            margin-left: 15px;
            vertical-align: middle;

        }

        .main--list li {
            padding-bottom: 25px;
            line-height: 20px;
        }

        .pdf-content {
            font-family: 'Poppins Medium';
            page-break-after: auto;
            font-weight: 500;
        }

        .list--type-2 li {
            padding-left: 20px;
        }

        .semi-bold {
            font-family: 'Poppins SemiBold';
            font-weight: 600;
        }

        .bold {
            font-family: 'Poppins Bold';
            font-weight: 700;
        }

        .extra-bold {
            font-family: 'Poppins ExtraBold';
            font-weight: 800;
            line-height: 50px;
        }

        /*.add--margin {*/
        /*    margin: 0 50px;*/
        /*}*/

        .page--title {
            background-color: #FFC847;
            font-size: 30px;
            position: relative;
            height: 80px;
            border-top-right-radius: 150px;
            width: 60%;
        }

        .circle--title {
            background-color: #FFC847;
            font-size: 20px;
            position: relative;
            height: 50px;
            border-radius: 0 20px 20px 0;
            width: 58%;
            padding-right: 0;
        }

        .bg--area {
            text-transform: capitalize;
            position: absolute;
            padding-left:50px;
        }

        .box--with-border {
            border: 3px solid #000000;
            border-radius: 30px;
            position: relative;
            padding: 20px 30px;
        }

        .box--with-border .title--box {
            background: #FFC847;
            position: absolute;
            height:25px;
            top: -23px;
            left: 8px;
            border-radius: 20px;
            padding: 1px 20px 10px 20px;
            text-align: center;
            vertical-align: middle;
        }

        .page_break {page-break-before: always;}

        .text-center {
            text-align: center;
        }

        .border-bottom {
            border-bottom: 2px solid grey;
        }

        .grey-font {
            color: grey;
        }
        .container {
            max-width: 700px;
        }

        .dotted-list {
            list-style-type:  disc;
            color: #000;
            margin-left: 15px;

        }

        .dotted-list li {
            line-height: 5px;
            vertical-align: middle;
            padding-bottom: 20px
        }

        .list-circle {
            list-style-type:  circle;
        }
        .pad-left-list {
            padding-left: 16px;
        }

        .display-flex {
            display: flex;
        }
        input[type=checkbox] {
            width: 20px;
            height: 20px;
            vertical-align: middle;
            margin-left: 5px;
            margin-right: 5px;
            cursor: pointer;
        }

        .list {
            padding-left: 15px;
            padding-top: 15px;
        }

        .list-2 li label {
            width: 35%;
            margin-bottom: 0;
            padding-top: 8px;
        }
        .list-2 li {
            margin-top: 15px;
        }
        .list-2 li input {
            width: 25%;
            margin-top: 10px;
        }
        .list-2 li select {
            width: 25%;
            margin-left: 30px;
            font-size: 12px;
            padding-left: 10px;
        }

        .list-2 li .price {
            margin-left: 15px;
            margin-top: 10px;
        }

        .dot-before li:before {
            content:"• ";
            font-size: 18px;
            padding-right: 5px;
        }
        .list input[type=checkbox] {
            vertical-align: middle;
            margin-right: 10px;
        }

        label, p {
            padding-right: 20px;
            vertical-align: sub;
            color: #000;
            /*font-weight: 300;*/
        }
        .input-field {
            border-top: none;
            border-left: none;
            border-right: none;
            vertical-align: unset;
            height: 20px;
            font-size: 12px;
        }
        .logo {
            width: 350px;
            text-align: center;
        }
        .preview-label {
            padding-right: 2px;
            vertical-align: baseline;
            margin: 0;
        }
        .margin-15 {
            margin-left: -4px;
        }
        .padding-50 {
            padding-left: 50px;
        }
        .margin-top-40 {
            margin-top: 40px !important;
        }
        .margin-top-30 {
            margin-top: 30px !important;
        }
        .margin-top-20 {
            margin-top: 20px !important;
        }
        .margin-top-10 {
            margin-top: 10px !important;
        }

        .margin-top-0 {
            margin-top: 0 !important;
        }
        .margin-bottom-0 {
            margin-bottom: 0 !important;
        }
        .margin-bottom-20 {
            margin-bottom: 20px !important;
        }

        .quoteInnerTable{
            width: 100%;
            /*display: inline-block;*/
        }

    </style>
@endsection
