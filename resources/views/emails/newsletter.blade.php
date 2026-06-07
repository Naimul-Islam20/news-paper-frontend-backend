<x-mail::message>
# {{ $subject }}

{!! nl2br(e($messageBody)) !!}

@if($link)
<x-mail::button :url="$link">
Read More
</x-mail::button>
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
