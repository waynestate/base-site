@extends('layouts.' . (isset($layout) ? $layout : 'master'))

@section('content-area')
    @yield('top')

    @if(!empty($hero) && $site_menu['meta']['has_selected'] == false && config('base.hero_contained') === false)
        @include('components.hero', ['images' => $hero])
    @endif

    @if(!in_array($page['controller'], config('base.full_width_controllers')))<div class="row mt:flex">@endif
        <div class="md:w-1/4 mt:px-4 mt:block @if($site_menu['meta']['has_selected'] == false && ((isset($show_site_menu) && $show_site_menu != true) || !isset($show_site_menu))) mt:hidden @endif">
            <nav id="menu" class="main-menu" role="navigation" aria-label="Page menu" aria-hidden="true" tabindex="-1">
                @if(!empty($top_menu_output) && $site_menu !== $top_menu)
                    <div class="offcanvas-main-menu mt:hidden">
                        <ul>
                            <li>
                                <a class="main-menu-toggle">Main Menu</a>

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
            </nav>
        </div>

        <div class="w-full{{ !in_array($page['controller'], config('base.full_width_controllers')) ? ' px-4' : '' }}{{ ($site_menu['meta']['has_selected'] == false && ((isset($show_site_menu) && $show_site_menu != true) || !isset($show_site_menu))) ? '' : ' md:w-3/4'}} content-area mb-8">
            @if(!empty($hero) && ($site_menu['meta']['has_selected'] == true || config('base.hero_contained') === true))
                @include('components.hero', ['images' => $hero, 'class' => 'hero--childpage'])
            @endif

            @if(!empty($breadcrumbs))
                @include('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
            @endif

            @yield('content')
        </div>
    @if(!in_array($page['controller'], config('base.full_width_controllers')))</div>@endif

    @yield('bottom')
@endsection
