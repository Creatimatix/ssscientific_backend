<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;"
       class="email-container">
    <tr>
        <td bgcolor="#ffffff"
            style="padding: 30px 20px 0px; font-family:'Montserrat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center;">

            <table role="presentation" class="force-full-width-mobile" cellspacing="0" cellpadding="0" border="0"
                   width="100%">
                <tbody>
                </tbody>
            </table>
        </td>
    </tr>
</table>
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;"
       class="email-container">

    <!-- 1 Column Text : END -->
    <tr>
        <td bgcolor="#ffffff" dir="ltr" align="center" valign="top" width="100%"
            style="padding: 20px 10px 20px 10px; border-top: dotted 1px #f7913d;">
            <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <!-- Column : BEGIN -->
                    <td width="33.33%" class="stack-column-center">
                        <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0"
                               width="100%">
                            <tbody>
                            <tr>
                                <td dir="ltr" valign="top" style="padding: 0 10px;display: flex;" class="logo-footer">
                                    SS Scientific
                                    <img src="{{ asset('images/proposal-pdf/fire.png') }}"
                                         height="170" alt="alt_text" border="0" class="center-on-narrow"
                                         style="width: 145px;height: 50px;background:#ffffff;font-family:sans-serif;font-size:15px;line-height:20px;color:#555555;margin-left: 3px;border-left: 2px solid #4382d0 !important;padding-left: 3px;">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <!-- Column : END -->
                    <!-- Column : BEGIN -->
                    <td width="66.66%" class="stack-column-center">
                     
                    </td>
                    <!-- Column : END -->
                </tr>
                <tr>
                    <td colspan="2" align="center"><p style="margin: 10px 0 10px 0;">
                            &copy; Copyright {{date('Y')}} SS Scientific. All Rights Reserved.
                        </p></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

</table>
<!-- Email Body : END -->

<!-- Email Footer : BEGIN -->
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;"
       class="email-container">
    <tr>
        <td style="padding: 40px 10px;width: 100%;font-size: 12px!important; font-family:'Montserrat', sans-serif!important; line-height:18px; text-align: center; color: #777777!important;"
            class="x-gmail-data-detectors">

            {{--<unsubscribe style="color:#777777; text-decoration:underline; font-family:'Montserrat', sans-serif;">If you
                no longer wish to receive these emails you may <a
                        href="http://www.inhabitr.com/unsubscribe.php?list=list&email=email"
                        style="font-family:'Montserrat', sans-serif;font-weight: 300;color:#f7931d!important;line-height: 1.5; text-decoration: none; cursor:pointer!important;">unsubscribe</a>
                at any time.
            </unsubscribe>--}}
            @if(isset($user))
                @if($user)
                        <?php
                        $url = '/';
                        ?>
                    <unsubscribe style="color:#777777; text-decoration:underline; font-family:'Montserrat', sans-serif;">If you
                        no longer wish to receive emails from SS Scientific you may <a
                                href="{{$url}}/unsubscribe/{{base64_encode($user->id)}}"
                                style="font-family:'Montserrat', sans-serif;font-weight: 300;color:#f7931d!important;line-height: 1.5; text-decoration: none; cursor:pointer!important;">unsubscribe</a>
                        at any time.
                    </unsubscribe>
                @endif
            @endif
        </td>
    </tr>
</table>
<!-- Email Footer : END -->


</center>
</body>
</html>
