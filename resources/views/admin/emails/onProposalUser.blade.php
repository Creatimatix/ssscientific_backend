@include('emails.layout.header')

<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;"
       class="email-container">
    <tr>
        <td bgcolor="#ffffff"
            style="padding: 40px 40px 20px; font-family:'Montserrat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center;">
            <p style="margin: 0;">Hi {{$user->first_name}},</p>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff"
            style="padding: 0 40px 20px; font-family:'Montserrat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center;">
            <p style="margin: 0;">
                Thank you for the opportunity!  We look forward to assisting you in marketing your home resulting in a faster sale for more money!  We have attached our staging proposal for your review.
            </p>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff"
            style="padding: 0 40px 20px; font-family:'Montserrat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center;">
            <p style="margin: 0;font-weight: 700;">
                Let us know if you would like to move forward with staging and we will send you a contract and payment form. Please know we schedule our installations in the order in which we receive paid, executed contracts.
            </p>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff"
            style="padding: 0 40px 20px; font-family:'Montserrat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center;">
            <p style="margin: 0;">
                We look forward to working with you!
            </p>
        </td>
    </tr>
</table>

@include('emails.layout.footer')
