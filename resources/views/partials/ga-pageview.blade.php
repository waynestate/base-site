@if(config('app.env') != 'local')
    <script>
        @if(config('app.ga_code') != 'UA-' && config('app.ga_name') != null)
        ga('{{ config('app.ga_name') }}.send', 'pageview', '{{ str_replace(['&spf=navigate', '?spf=navigate'], ['', ''], $server['url_with_query']) }}');
        @endif
        ga('allWayneState.send', 'pageview', '{{ str_replace(['&spf=navigate', '?spf=navigate'], ['', ''], $server['url_with_query']) }}');
    </script>
@endif
