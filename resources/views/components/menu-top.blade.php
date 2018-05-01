{{--
    $site => array // ['title']
    $top_menu_output => string // '<ul></ul>'
--}}
<div class="menu-top">
    <div class="menu-top-container bg-green-darker">
        <div class="row relative px-4">
            <div class="title-area{{ config('app.surtitle') === null ? ' vertical-centering' : '' }}">
                @if(config('app.surtitle') !== null)
                    <h1 class="surtitle">
                        @if($site['parent']['id'] === null && config('app.surtitle_main_site_enabled') === true || $site['parent']['id'] !== null)
                            <a href="{{ config('app.surtitle_url') }}">{{ config('app.surtitle') }}</a>
                        @endif
                    </h1>
                @endif

                {!! config('app.surtitle') !== null ? '<h2>' : '<h1>' !!}
                    <a href="/{{ $site['subsite-folder'] !== null ? rtrim($site['subsite-folder'], '/') : '' }}">{{ $site['title'] }}</a>
                {!! config('app.surtitle') !== null ? '</h2>' : '</h1>' !!}
            </div>

            <div class="float-right vertical-centering">
                <div>
                    @if(config('app.top_menu_enabled') === true)
                        <nav id="top-menu" aria-label="Site menu" tabindex="-1">
                            {!! $top_menu_output !!}
                        </nav>
                    @endif

                    <div>
                        <ul class="menu-top menu-button mt:hidden">
                            <li><a href="#page-menu" class="menu-toggle menu-icon" data-toggle="page-menu"><span class="visually-hidden">Menu</span></a></li>
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
