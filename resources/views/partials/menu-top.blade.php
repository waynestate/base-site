{{--
    $site => array // ['title']
    $top_menu_output => string // '<ul></ul>'
--}}
<div class="menu-top">
    <div class="menu-top-container menu-top-bg">
        <div class="row">
            <div class="small-12 columns">
                <div class="vertical-centering title-area">
                    <h1>
                        <a href="/">
                            @if(config('app.sub_title') !== null)<span>{{ config('app.sub_title') }}</span>@endif
                            {{ $site['title'] }}
                        </a>
                    </h1>
                </div>

                <div class="float-right vertical-centering">
                    <div>
                        @if(config('app.top_menu_enabled') == true)
                            <section id="top-menu">
                                {!! $top_menu_output !!}
                            </section>
                        @endif

                        <div>
                            <ul class="menu-top menu-button hide-for-menu-top-up">
                                <li><a href="#mainMenu" class="menu-toggle menu-icon" data-toggle="mainMenu"><span>Menu</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="menu-top-placeholder"></div>
</div>
