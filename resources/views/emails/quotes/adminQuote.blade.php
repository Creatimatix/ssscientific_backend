@include('emails.layouts.header')
<table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="margin: auto" class="email-contailer">
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 40px 20px; font-family: 'Monstressat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center">
            <p style="margin: 0;">Hi Admin,</p>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 40px 20px; font-family: 'Monstressat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center">
            <p style="margin: 0;">
                Quotation sent to {{ $customer->full_name }}
            </p>
        </td>
    </tr>
    @if($quotes)
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 40px 20px; font-family: 'Monstressat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center">
            <p style="margin: 0;">
                Address: {{ $quotes->property_address }}
            </p>
        </td>
    </tr>
    @endif
</table>
@include('emails.layouts.footer')
