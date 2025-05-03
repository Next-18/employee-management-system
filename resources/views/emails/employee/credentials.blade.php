@component('mail::message')
# Welcome to the Company, {{ $name }}!

Your employee account has been created. Here are your login credentials:

- **Email:** {{ $email }}
- **Password:** {{ $password }}

Please log in and change your password as soon as possible.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
