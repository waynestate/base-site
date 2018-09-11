@extends('layouts.' . (!empty($layout) ? $layout : 'master'))

@section('content-area')
    @yield('top')

    @if(!empty($hero) && in_array($page['controller'], config('base.hero_full_controllers')))
        @include('components.hero', ['images' => $hero])
    @endif

    @if(!in_array($page['controller'], config('base.full_width_controllers')))<div class="row mt:flex">@endif
        <div class="mt:w-1/4 mt:px-4 mt:block {{ $show_site_menu === false ? ' mt:hidden' : '' }}">
            <nav id="menu" class="main-menu" role="navigation" aria-label="Page menu" tabindex="-1">
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
                    <hr class="mb-2">
                @endif

                @if(!empty($banner))
                    <a href="{{ $banner['link'] }}" class="my-4 min-w-full button expanded mt:hidden">{{ $banner['title'] }} {{ $banner['excerpt'] }}</a>
                @endif

                @yield('below_menu')

                @if(!empty($under_menu))
                    @include('components.under-menu', ['buttons' => $under_menu])
                @endif
            </nav>
        </div>

    <div class="w-full{{ !in_array($page['controller'], config('base.full_width_controllers')) ? ' px-4' : '' }} {{$show_site_menu === true ? 'mt:w-3/4' : '' }} content-area mb-8">
            @if(!empty($hero) && !in_array($page['controller'], config('base.hero_full_controllers')))
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
