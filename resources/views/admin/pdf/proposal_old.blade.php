<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice 120</title>
    <style>
        .invoice-box {
            /*max-width: 800px;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);*/
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td.nth-child {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total {
            text-align: right;
        }

        .invoice-box table tr.total td.nth-child {
            border-top: 2px solid #eee;
            font-weight: bold;
            text-align: left;
        }

        .footer td {
            text-align: center;
            padding-top: 25px;
        }

        .footer td p {
            padding-top: 25px;
        }
        .txt{
            text-transform: uppercase!important;
        }
        .txt-success {
            color: #4CAF50 !important;
        }
        .txt-info {
            color: #40c4ff !important;
        }
        .txt-danger {
            color: #ff5252 !important;
        }
        .txt > span {
            padding-left: 15px;
        }

        .invoice-detail-table td{
            border: 1px solid;
        }
        .invoice-detail-table th{
            border: 1px solid;
            padding: 13px;
            text-align: center;
        }
        .watermark{
            border:1px solid #aaa;
            border-radius: 8px;
            color: #aaa; opacity:0.6;
            position: absolute;
            z-index: 1;
            left:25%;
            top:40%;
            font-size: 19px;
            padding: 5px;
            -webkit-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            transform: rotate(-45deg);
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }
    </style>
</head>
@php
    $totalPaid = 0;
@endphp

<body>
<div class="invoice-box" style="{{ $totalPaid?'line-height: 21px !important;':'' }}">
    @if($model->status == \App\Models\Admin\Quote::QUOTE_REQUESTED)
        <div class="watermark">
            This invoice is already paid. No further action needed
        </div>
    @endif

    @if($model->status == \App\Models\Admin\Quote::PROPOSAL_SENT)
        <div class="watermark {{ $totalPaid?'partialInvoice':'' }}">
            This invoice is partially paid.
        </div>
    @endif
    <table  style="{{ count([0]) > 5?'line-height: 23px;':'' }}">
        <tr>
            <td style="width: 40%;font-size: 20px;font-weight: bold;">
                @if($model->status == 1)
                    S S Scientific LLC
                @else
                    <img class="img-fluid able-logo align-center" src="{{ public_path('images/quotation logo.png') }}" alt="Theme-logo" width="250px">
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 40%;font-size: 20px;font-weight: bold;">
                Quotation
            </td>
        </tr>
        <tr>
            <td class="nth-child" style="width: 60%;">
                Date: {{ $model->created_at}}<br>{{$model->quote_no}}<br>
                <?php
                    echo "Quote Invoice #: adfds"."<br>";
                ?>
                {{--@if($invoice->status == App\Model\Invoice\Invoice::STATUS_CHARGED)
                    <span style="color:darkgreen;">Invoice is already paid</span>
                @endif

                @if($invoice->status == App\Model\Invoice\Invoice::STATUS_PARTIAL_PAID)
                    <span style="color:darkgreen;">Invoice is partially paid</span>
                @endif--}}

                <br><br>

                    Phone: {{$model->phone_number}}<br>

                    Email: {{$model->email}}<br>

                    Address:  1223<br/>

            </td>
        </tr>
        <tr>
                <td>
                    <table class="invoice-detail-table"  cellpadding="0" cellspacing="0"  style="table-layout: fixed">
                        <tr class="thead-default">
                            <th width="25%">Item Type</th>
                            <th width="50%">Description</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>Test</td>
                            <td>Staging Design & Service Fee </td>
                            <td align="right">${{number_format(100 ,2)}}</td>
                        </tr>
                    </table>
                </td>
            </tr>

        <tr style="">
            <td>
                <h3>Additional Notes:</h3>
                <ul style="list-style: disc;padding-left: 58px;font-style: italic;font-size: 14px;">
                    <li>{!! $model->remark !!}</li>
                </ul>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
