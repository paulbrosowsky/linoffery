@component('mail::message')
# @lang('Hello ') {{ $user->name . ',' }}

@lang('We received a request for the password change on your user account.')
<p>@lang('Do you want to change your password?')</p> 

@component('mail::button', ['url' =>  url('/password/reset?token=' . $user->password_reset_token)])
    @lang('Reset Password')
@endcomponent

<small>{{url('/api/auth/email-confirmation/confirm?token=' . $user->password_reset_token)}}</small>

<p>@lang('If you have not sent us anything, just ignore this email.')</p> 

@lang('Thank you,')<br>
{{ config('app.name') }}-Team
@endcomponent

