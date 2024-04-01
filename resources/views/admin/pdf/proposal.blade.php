@php
    $totalAmount = 0;
    $subPrice = 0;
    $iGst = 0;
    $cGst = 0;
    $sGst = 0;
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
        @page {
            /* size: 7in 9.25in; */
            margin: 10px;;
        }


        :root {
  --border-strong: 3px solid #777;
  --border-normal: 1px solid gray;
}

        body {
            transform: scale(1.0);
            transform-origin: 0 0;
            background-image: url("{{ public_path('images/logobg.png') }}");
            background-size: cover;
            background-position: 10% 0%;
            margin-bottom:20px;
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
            font-size: 12pt;
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

        td, th .{
            width:10%;
            padding-left:5pt;
            font-size: 10pt;
        }

        .table-quotation, th, td {
            border: 1px solid black;
            border-spacing:0;
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

        .no-side-border{
            border-left: 1px solid; 
            border-right: 1px solid;
        }

        .left-align{
            text-align:left;
            padding-left:1pt;
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

        tr.border-bottom td {
        border-bottom: 1pt solid #ff000d;
      }
        /*table, tbody {vertical-align: top; overflow: visible; }*/
    </style>

</head>
<body>
<p style="text-indent: 0pt;text-align: left; pading-top:-10px; ">
        <span style="margin-bottom:30px">
<table cellspacing="0" height="100%" cellpadding="0" class='center'>
    <tr>
        <td style="border: none;">
            <p style="padding-top: 4pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">S S Scientific</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Shop No. 11, Jamal
                Mansion,<br>Dr, Meisheri Road, Dongri,<br>Mumbai - 400 009.</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">Maharashtra,<br>India</p>
            <p style="padding-left: 7pt;text-indent: 0pt;line-height: 109%;text-align: left;">GST: 27AYQPS9651P1Z2</p>
        </td>
        <td style='text-align:right;border: none;'>
        <img src="{{ public_path('images/quotation logo.png') }}" style="width:140px;height:120px;" />
        </td>
    </tr>
</table>
<!-- </span>
</p> -->

<table id="Products_table" class='center table-quotation no-border' >
<tr class='no-border'>
        <th class='no-border'>&nbsp;</th>
    </tr>
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
    <tr><td style="width:5%" class="no-border"></br></td></tr>
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
    <!-- </table>
    <table style="table-layout:fixed; height:90vh;" class="center no-border Product_table"> -->

    @if($key != $totalItems)
    <!-- Blank table for background -->
    <div style="position:fixed; z-index:9; width:100%">

        <table style="width:90%; border-size:2px; margin-left:0px;"  cellspacing="0" class="center Product_table" cellpadding="0" >
        <tr>
            <th style="width:5%">&nbsp;</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></th>
            <th style="width:10%"></th>
            <!-- <th></th> -->
            <th colspan='3'></th>
            <th style="width:5%"></th>
            <th style="width:15%"></th>
            <th style="width:15%"></th>
        </tr>
        </table>
    </div>
   @endif

    <tr class="border-bottom"style="border: solid thin;">
        <th style="width:5%" class='no-side-border'>S/N</th>
        <th style="width:10%"  class='no-side-border'>P/N</th>
        <!-- <th  class='no-side-border'>HSN Code</th> -->
        <th class='no-side-border' colspan='3'>Description of goods</th>
        <th style="width:5%" class='no-side-border'>Qty</th>
        <th style="width:15%" class='no-side-border'>Unit {{ $model->currency_type }}</th>
        <th style="width:15%" class='no-side-border'>Amount {{ $model->currency_type }}</th>
    </tr>
    <!-- <tr style="border-bottom:2px"></tr> -->
    <!-- <div> -->
    <tr style="text-align: center;"  class='no-border'>
        <td style="width:5%" style="padding: 0px 0px 10px 0px; width:5%" class='{{($key != $totalItems ? "no-border" : "")}} text-top no-bottom-border'><b>{{ $itemKey }}</b></td>
        <td  style="width:10%"  class='{{($key != $totalItems ? "no-border" : "")}} text-top no-bottom-border'>{{ $item->product->pn_no }}</td>
        <!-- <td   class='{{($key != $totalItems ? "no-border" : "")}} text-top no-bottom-border'>{{ $item->product->hsn_no }}</td>--}} -->
        <td  colspan='3'  class='{{($key != $totalItems ? "no-border" : "")}} left-align text-top no-bottom-border'>
            <b class='left-align'>{{ $item->product->name }}</b>
            <br />
            <div class='{{($key != $totalItems ? "no-border" : "")}} text-center'>
                @if($item->product)
                    @foreach($item->product->images as $image)
                        <img src="{{ storage_path('images/products/'.$image->image_name) }}" style="width:80px;height:60px;" />
                    @endforeach
                @endif
            </div>
            <br />
            {{ $item->product->short_description }}
            <br />
            {!! $item->product->description !!}
        </td>
        <td  style="width:5%"  class='{{($key != $totalItems ? "no-border" : "")}} text-top text-center no-bottom-border'>{{ $item->quantity }}</td>
        <td  style="width:15%"  class='{{($key != $totalItems ? "no-border" : "")}} text-top text-center no-bottom-border'><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].($item->asset_value) }}</span></td>
        <td  style="width:15%"  class='{{($key != $totalItems ? "no-border" : "")}} text-top text-center no-bottom-border'><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].($item->quantity * $item->asset_value) }}</span></td>
    </tr>
    @foreach($item->accessories as $aKey => $accessory)
        @php
            if($accessory->is_payable){
                $subPrice += $accessory->asset_value * $accessory->quantity;
                $totalAmount += $accessory->asset_value * $accessory->quantity;
            }
        @endphp
        <tr style="text-align: center;  outline: thin solid">
            <td style="width:5%" style="padding: 10px 0px 10px 0px" class='no-top-border text-top no-bottom-border {{($key != $totalItems ? "no-border" : "")}} '>{{ $itemKey.'.'.++$aKey }}</td>
            <td style="width:10%" class='no-top-border text-top no-bottom-border {{($key != $totalItems ? "no-border" : "")}} '>{{ $accessory->product->pn_no }}</td>
            <!-- <td class='no-top-border text-top no-bottom-border {{($key != $totalItems ? "no-border" : "")}} '>{{ $accessory->product->hsn_no }}</td> -->
            <td colspan='3' class='no-top-border text-left text-top no-bottom-border {{($key != $totalItems ? "no-border" : "")}}'>
                <b>{{ $accessory->product->name }}</b>{{ sizeof($item->accessories) }}
                <br />
                {{ $accessory->product->short_description }}
            </td>
            <td style="width:5%" class='no-top-border text-center text-top no-bottom-border {{($key != $totalItems ? "no-border" : "")}} '>{{ $accessory->quantity }}</td>
            <td style="width:15%" class='text-top text-center no-top-border no-bottom-border {{($key != $totalItems ? "no-border" : "")}}' ><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].($accessory->quantity * $accessory->asset_value) }}</span></td>
            <td style="width:15%" class='text-top text-center no-top-border no-bottom-border {{($key != $totalItems ? "no-border" : "")}}'>
                @if($accessory->is_payable)
                    <span style="font-family: DejaVu Sans; sans-serif;">
                {{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].($accessory->quantity * $accessory->asset_value) }}
                    </span>
                @endif
            </td>
        </tr>
        <!-- </div> -->
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
            $iGst =(($finalTotal * $model->i_gst)/100);
        }
        if($model->c_gst){
            $cGst =(($finalTotal * $model->c_gst)/100);
        }
        if($model->s_gst){
            $sGst =(($finalTotal * $model->s_gst)/100);
        }

        $finalTotal += $iGst + $cGst + $sGst;

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
        <td colspan='3' class='no-border' >Validity - 90 Days</td>
        <td colspan='3' class='no-border text-right'>Freight</td>
        <td colspan='2'><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$model->freight }}</span></td>
    </tr>
    <tr>
        <td colspan='3' class='no-border' ></td>
        <td colspan='3' class='no-border text-right'>Installation</td>
        <td colspan='2'><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$model->installation }}</span></td>
    </tr>
    <tr>
        <td colspan='3' class='no-border' ></td>
        <td colspan='3' class='no-border text-right'>{{($model->i_gst > 0 ? "IGST" : "CGST")}} </td>
        <td colspan='2'>{{($model->i_gst > 0 ? $model->i_gst : $model->c_gst)}}%</td>
    </tr>
       @if($model->s_gst > 0)
    <tr>
        <td colspan='3' class='no-border'></td>
        <td colspan='3' class='no-border text-right'>{{($model->s_gst > 0 ? "SGST" : "")}}</td>
        <td colspan='2'class=''>{{($model->s_gst > 0 ? $model->s_gst."%" : "")}}</td>
    </tr>
    @endif
     <tr>
        <td colspan='3' class='no-border' id="total"></td>
        <td colspan='3' class='no-border text-right'>TOTAL FOR, DESTINATION</td>
        <td colspan='2' class=''><span style="font-family: DejaVu Sans; sans-serif;">{{ \App\Models\Admin\ProductCartItems::CURRENCY[$model->currency_type].$finalTotal }}</span></td>
   <!-- <script>

document.getElementById('total').innerHTML = convertNumberToWords({{$finalTotal}})+" ONLY.";
    </script> -->
    </tr>
    <tr>
        <td colspan='8' class='left-align no-border'>
    </br>
            For, S. S SCIENTIFIC</br>
            <img width="130px" height="85px" src="{{ public_path('images/proposal-pdf/stamp.png') }}"/></br>
            AUTHORIZED SIGNATORY
        </td>
    </tr>
    @endif
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
        /* font-size: 11px; */
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
        font-size: 12px;
        padding: -2px;
    }
</style>
<script>
        // Define an object that maps numbers to their word form
const numbersToWords = {
  0: "zero",
  1: "one",
  2: "two",
  3: "three",
  4: "four",
  5: "five",
  6: "six",
  7: "seven",
  8: "eight",
  9: "nine",
  10: "ten",
  11: "eleven",
  12: "twelve",
  13: "thirteen",
  14: "fourteen",
  15: "fifteen",
  16: "sixteen",
  17: "seventeen",
  18: "eighteen",
  19: "nineteen",
  20: "twenty",
  30: "thirty",
  40: "forty",
  50: "fifty",
  60: "sixty",
  70: "seventy",
  80: "eighty",
  90: "ninety",
};

// Define the convertNumberToWords function
function convertNumberToWords(number) {
  // if number present in object no need to go further
  if (number in numbersToWords) return numbersToWords[number];

  // Initialize the words variable to an empty string
  let words = "";

  // If the number is greater than or equal to 100, handle the hundreds place (ie, get the number of hundres)
  if (number >= 100) {
    // Add the word form of the number of hundreds to the words string
    words += convertNumberToWords(Math.floor(number / 100)) + " hundred";

    // Remove the hundreds place from the number
    number %= 100;
  }

  // If the number is greater than zero, handle the remaining digits
  if (number > 0) {
    // If the words string is not empty, add "and"
    if (words !== "") words += " and ";

    // If the number is less than 20, look up the word form in the numbersToWords object
    if (number < 20) words += numbersToWords[number];
    else {
      // Otherwise, add the word form of the tens place to the words string
      //if number = 37, Math.floor(number /10) will give you 3 and 3 * 10 will give you 30
      words += numbersToWords[Math.floor(number / 10) * 10];

      // If the ones place is not zero, add the word form of the ones place
      if (number % 10 > 0) {
        words += "-" + numbersToWords[number % 10];
      }
    }
  }

  // Return the word form of the number
  return words.toUpperCase();
}

document.getElementById('total').innerHTML = "Some Value";
    </script>
</body>
</html>
      @endforeach
   @endif
