<x-mail::message>
# {{ $subject }}

{!! $content !!}

@isset($url)
<x-mail::button :url="$url">
View Details
</x-mail::button>
@endisset

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>