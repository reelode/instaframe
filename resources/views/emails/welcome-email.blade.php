@component('mail::message')
# Welcome to Instaframe

This is the new Instagram.

@component('mail::button', ['url' => ''])
Go to your profile
@endcomponent

Thanks,<br>
CEO Simon Lindelöf<br>
{{ config('app.name') }}
@endcomponent