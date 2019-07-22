@component('mail::message')
# @lang('Welcome!')

@lang('Now only one step is missing.')
<p>@lang('Please confirm your email address and you are ready to go.')</p> 

@component('mail::button', ['url' => url('/api/auth/email-confirmation/confirm?token=' . $user->confirmation_token)])
    @lang('Confirm Email')
@endcomponent

@lang('Thank you,')<br>
{{ config('app.name') }}-Team
@endcomponent

