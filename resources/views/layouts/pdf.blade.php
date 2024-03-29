<!DOCTYPE  html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quotation</title>
    <meta name="author" content="ssscientific"/>
    <style type="text/css">
        /** {margin:0; padding:0; text-indent:0; }*/
        /* @page {
            size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
        } */

        body {
            transform: scale(1.0);
            transform-origin: 0 0;
            background-image: url("{{ public_path('images/logobg.png') }}");
            background-size: cover;
            background-position: center;
            /* margin: 10mm 10mm 10mm 10mm; */
            margin: 0;
            border: solid blue;
            border-width: thin;
            overflow:hidden;
            display:block;
            box-sizing: border-box;
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

@yield('content')

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
        /* background-image: url({{ public_path('images/logobg.png') }}); */
        height: 100%;
        width: 100%;
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
