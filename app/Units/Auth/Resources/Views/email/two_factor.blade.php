@component('mail::message')

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Atenciosamente,<br>{{ config('app.name') }}
@endif

@endcomponent
