@if(config('app.env') != 'local')
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        @if(config('base.ga_code') != 'UA-' && config('base.ga_name') != null)
            ga('create', '{{ config('base.ga_code') }}', 'wayne.edu', {'name': '{{ config('base.ga_name') }}'});
            ga('{{ config('base.ga_name') }}.send', 'pageview', '{{ $server['path_with_query'] }}');
        @endif

        @if(config('base.ga_code_all_wsu') != 'UA-')
            ga('create', '{{ config('base.ga_code_all_wsu') }}', 'wayne.edu', {'name': 'allWayneState'});
            ga('allWayneState.send', 'pageview', '{{ $server['path_with_query'] }}');
        @endif
    </script>
@endif

