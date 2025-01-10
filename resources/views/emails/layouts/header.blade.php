<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Contact Us</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .email-header {
            background-color: #09445a !important;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid black;
            display: flex;
        }
        .email-body {
            padding: 20px;
            color: #black;
        }
        .email-footer {
            background-color: #09445a;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="email-header">
            {{-- <img src="{{ url('images/logo.png') }}" class="g-img" alt="Logo" style="max-height: 50px; margin-right: 1px;"> --}}
            <img src="{{ $message->embed('images/logo.png') }}" class="g-img" alt="Logo" style="max-height: 50px; margin-right: 1px;">
            <h1 style="margin-top: 8px; font-size: 27px; font-weight: bold;">SS Scientific</h1>
        </div>
