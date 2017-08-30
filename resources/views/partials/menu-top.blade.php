{{--
    $site => array // ['title']
    $top_menu_output => string // '<ul></ul>'
--}}
<div class="menu-top">
    <div class="menu-top-container menu-top-bg">
        <div class="row">
            <div class="small-12 columns position-relative">
                <div class="vertical-centering title-area">
                    <h1>
                        <div>
                            <a href="/">
                                @if(config('app.sub_title') !== null)<span>{{ config('app.sub_title') }}</span>@endif
                                {{ $site['title'] }}
                            </a>
                        </div>
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

                @if(isset($banner) && $banner != false)
                    @include('partials/banner', ['banner' => $banner, 'class' => 'banner'])
                @endif

            </div>
        </div>
    </div>

    <div class="menu-top-placeholder"></div>
</div>
