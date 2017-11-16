@extends('layouts.' . (isset($layout) ? $layout : 'master'))

@section('content-area')
    @yield('top')

    @if(isset($hero) && $hero != false && $site_menu['meta']['has_selected'] == false && config('app.hero_contained') === false)
        @include('components.hero', ['images' => $hero])
    @endif

    <div class="row">
        <div class="xlarge-3 large-3 small-12 columns main-menu @if($site_menu['meta']['has_selected'] == false && ((isset($show_site_menu) && $show_site_menu != true) || !isset($show_site_menu))) hide-for-menu-top-up @endif" id="mainMenu" data-off-canvas role="navigation">
            @if(isset($site_menu_output) && isset($top_menu_output) && $site_menu !== $top_menu)
                <div class="offcanvas-main-menu">
                    <ul>
                        <li>
                            <a class="main-menu">Main Menu</a>

                            {!! $top_menu_output !!}
                        </li>
                    </ul>
                </div>
            @endif

            @if(isset($site_menu_output))
                {!! $site_menu_output !!}
            @endif

            @yield('below_menu')

            @if(isset($under_menu))
                @include('components.image-list', ['images' => $under_menu, 'class' => 'under-menu'])
            @endif
        </div>

        <div class="small-12 @if($site_menu['meta']['has_selected'] == false && ((isset($show_site_menu) && $show_site_menu != true) || !isset($show_site_menu)))xlarge-12 large-12 @else xlarge-9 large-9 @endif columns content" data-off-canvas-content>

            @if(isset($hero) && $hero != false && $site_menu['meta']['has_selected'] == true || config('app.hero_contained') === true)
                @include('components.hero', ['images' => $hero, 'class' => 'hero--childpage'])
            @endif

            @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                @include('partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
            @endif

            @yield('content')
        </div>
    </div>

    @yield('bottom')
@endsection
