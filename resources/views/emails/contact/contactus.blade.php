@include('emails.layouts.header')
<div class="email-body">
    <h2>Dear Admin,</h2>
    <p>We have received a new enquiry from our website. Here are the details:</p>
    <p><strong>Name:</strong> {{ $details['name'] }}</p>
    <p><strong>Email:</strong> {{ $details['email'] }}</p>
    <p><strong>Phone:</strong> {{ $details['phone'] }}</p>
    <p><strong>Your Message:</strong></p>
    <blockquote style="margin-left: 20px; font-style: italic;">
        {{ $details['message']  }}
    </blockquote>
    <p>Please review the details and respond accordingly.</p>
    <p>Best regards,</p>
    <p><strong>SS Scientific</strong></p>
</div>
@include('emails.layouts.footer')