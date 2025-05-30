{{ $subject }}

{{ strip_tags($content) }}

@isset($url)
View Details: {{ $url }}
@endisset

Thanks,
{{ config('app.name') }}