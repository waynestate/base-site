@if(config('base.gtm_code') != 'GTM-' && config('app.env') != 'local')
    <noscript aria-hidden="true"><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('base.gtm_code') }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif