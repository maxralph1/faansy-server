<x-mail::message>
# {{ config('app.name') }} Password Reset Token

You have requested to reset your password. Please click on the button to reset your password. 

<x-mail::button :url="'{{ config('app.url') }}/reset-password/' . $email . '/' . $token " color="error">
Reset Password
</x-mail::button>

If you have not requested for a password reset, kindly ignore this notification or report this to our customer care if you notice suspicious activities on your account

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
