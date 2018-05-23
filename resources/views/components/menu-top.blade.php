{{--
    $site => array // ['title']
    $top_menu_output => string // '<ul></ul>'
--}}
<div class="menu-top">
    <div class="menu-top-container bg-green-dark">
        <div class="row relative px-4">
            <div class="title-area{{ config('base.surtitle') === null ? ' vertical-centering' : '' }}">
                @if(config('base.surtitle') !== null)
                    <h1 class="surtitle">
                        @if($site['parent']['id'] === null && config('base.surtitle_main_site_enabled') === true || $site['parent']['id'] !== null)
                            <a href="{{ config('base.surtitle_url') }}">{{ config('base.surtitle') }}</a>
                        @endif
                    </h1>
                @endif

                {!! config('base.surtitle') !== null ? '<h2>' : '<h1>' !!}
                    <a href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}">{{ $site['title'] }}</a>
                {!! config('base.surtitle') !== null ? '</h2>' : '</h1>' !!}
            </div>

            <div class="float-right vertical-centering">
                <div>
                    @if(config('base.top_menu_enabled') === true)
                        <nav id="top-menu" class="top-menu" aria-label="Site menu" tabindex="-1">
                            {!! $top_menu_output !!}
                        </nav>
                    @endif  

                    <div>
                        <ul class="menu-top menu-button mt:hidden">
                            <li><button class="menu-toggle menu-icon" data-toggle="menu" aria-expanded="false" aria-controls="menu" tabindex="0"><span class="visually-hidden">Menu</span></button></li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(!empty($banner))
                @include('components.banner', ['banner' => $banner])
            @endif
        </div>
    </div>

    <div class="menu-top-placeholder"></div>
</div>
