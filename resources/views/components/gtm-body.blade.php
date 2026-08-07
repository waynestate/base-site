@if(config('base.gtm_code') != 'GTM-' && config('app.env') != 'local')
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('base.gtm_code') }}"
    height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager tracking fallback" aria-hidden="true"></iframe></noscript>
@endif
