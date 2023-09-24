@include('emails.layouts.header')
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="margin: auto" class="email-contailer">
        <tr>
           <td bgcolor="#ffffff" style="padding: 40px 40px 20px; font-family: 'Monstressat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center">
               <p style="margin: 0;">Hi {{ $customer->full_name }}</p>
           </td>
        </tr>
        <tr>
           <td bgcolor="#ffffff" style="padding: 40px 40px 20px; font-family: 'Monstressat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center">
               <p style="margin: 0;">
                   Thank you for the opportunity! we look forword to assisting you in a faster sale for more money! we have attached our quotation for your review.
               </p>
           </td>
        </tr>
        <tr>
           <td bgcolor="#ffffff" style="padding: 40px 40px 20px; font-family: 'Monstressat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center">
               <p style="margin: 0;">
                   Let us Know if you would like to move forward and we will send to you a contract and payment form. please know we schedule our installation in the order in which we receive paid , executed contracts.
               </p>
           </td>
        </tr>
        <tr>
           <td bgcolor="#ffffff" style="padding: 40px 40px 20px; font-family: 'Monstressat', sans-serif; font-size: 14px; line-height: 20px; color: #777777; text-align: center">
               <p style="margin: 0;">
                   We look forward to working with you!
               </p>
           </td>
        </tr>

    </table>
@include('emails.layouts.footer')
