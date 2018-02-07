@if(config('app.env') != 'local')
    <script>
        @if(config('app.ga_code') != 'UA-' && config('app.ga_name') != null)
        ga('{{ config('app.ga_name') }}.send', 'pageview', '{{ $server['path_with_query'] }}');
        @endif
        ga('allWayneState.send', 'pageview', '{{ $server['path_with_query'] }}');
    </script>
@endif
