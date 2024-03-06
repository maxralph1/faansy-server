<x-mail::message>
# {{ config('app.name') }} Passwordless Login

You have requested to sign in without a password. Please click on the button to sign into your account. 

<x-mail::button :url="'{{ config('app.url') }}/passwordless-signin/' . $username . '/' . $token " color="error">
Sign into your Account
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} Team

<small>If you have not requested to login, kindly ignore this notification or report this to our customer care if you notice suspicious activities on your account.</small>
</x-mail::message>
