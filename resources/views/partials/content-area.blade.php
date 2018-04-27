@extends('layouts.' . (isset($layout) ? $layout : 'master'))

@section('content-area')
    @yield('top')

    @if(!empty($hero) && $site_menu['meta']['has_selected'] == false && config('app.hero_contained') === false)
        @include('components.hero', ['images' => $hero])
    @endif

    <div class="row">
        <div class="small-12 medium-3 columns main-menu @if($site_menu['meta']['has_selected'] == false && ((isset($show_site_menu) && $show_site_menu != true) || !isset($show_site_menu))) mt:hidden @endif" data-off-canvas id="page-menu" role="navigation"  aria-label="Page menu" tabindex="-1">
            @if(!empty($top_menu_output) && $site_menu !== $top_menu)
                <div class="offcanvas-main-menu">
                    <ul>
                        <li>
                            <a class="main-menu">Main Menu</a>

                            {!! $top_menu_output !!}
                        </li>
                    </ul>
                </div>
            @endif

            @if(!empty($site_menu_output))
                {!! $site_menu_output !!}
            @endif

            @yield('below_menu')

            @if(!empty($under_menu))
                @include('components.image-button-list', ['images' => $under_menu])
            @endif
        </div>

        <div class="small-12 @if($site_menu['meta']['has_selected'] == false && ((isset($show_site_menu) && $show_site_menu != true) || !isset($show_site_menu)))medium-12 @else medium-9 @endif columns content-area" data-off-canvas-content>
            @if(!empty($hero) && ($site_menu['meta']['has_selected'] == true || config('app.hero_contained') === true))
                @include('components.hero', ['images' => $hero, 'class' => 'hero--childpage'])
            @endif

            @if(!empty($breadcrumbs))
                @include('partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
            @endif

            <main id="main" tabindex="-1">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('bottom')
@endsection
