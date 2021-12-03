@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <p>The web team can enable under menu buttons on your site. Here are the available options.</p> 

    @if(!empty($buttons))
        <h2 class="mb-4">Default buttons</h2>
        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-default', ['button' => $buttons['default'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Option: None or 'Default'</li>
                </ul>
            </div>
        </div>

        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-default', ['button' => $buttons['default_two_lines'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Excerpt</li>
                    <li>Option: None or 'Default'</li>
                </ul>
            </div>
        </div>

        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-default', ['button' => $buttons['default_icon'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Excerpt</li>
                    <li>Filename: Green SVG 40x40</li>
                    <li>Option: None or 'Default'</li>
                </ul>
            </div>
        </div>

        <hr />
        
        <h2 class="mb-4">Green buttons</h2>
        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-green', ['button' => $buttons['green'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Option: Green</li>
                </ul>
            </div>
        </div>

        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-green', ['button' => $buttons['green_two_lines'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Excerpt</li>
                    <li>Option: Green</li>
                </ul>
            </div>
        </div>

        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-green', ['button' => $buttons['green_icon'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Excerpt</li>
                    <li>Filename: White SVG 40x40</li>
                    <li>Option: Green</li>
                </ul>
            </div>
        </div>

        <hr />

        <h2 class="mb-4">Image buttons</h2>
        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-bg-image-light', ['button' => $buttons['bg_image_light'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Link</li>
                    <li>Filename: 600x218 jpg, Ratio 2.76:1</li>
                    <li>Option: Bg image light</li>
                </ul>
            </div>
        </div>

        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-bg-image-dark', ['button' => $buttons['bg_image_dark'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Link</li>
                    <li>Filename: 600x218 jpg, Ratio 2.76:1</li>
                    <li>Option: Bg image dark</li>
                </ul>
            </div>
        </div>

        <hr />

        <h2 class="mb-4">SVG buttons</h2>
        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-svg-light-bg', ['button' => $buttons['svg_light_bg'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Link</li>
                    <li>Filename: 600x218 jpg, Ratio 2.76:1</li>
                    <li>Secondary Image: 600x218 svg, Ratio 2.76:1</li>
                    <li>Option: SVG light bg</li>
                </ul>
            </div>
        </div>

        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                @include('components.button-svg-dark-bg', ['button' => $buttons['svg_dark_bg'], 'class' => 'w-72'])
            </div>
            <div>
                <h3 class="text-sm uppercase tracking-wider">Promo setup:</h3>
                <ul class="ml-6 list-disc text-sm">
                    <li>Title</li>
                    <li>Link</li>
                    <li>Filename: 600x218 jpg, Ratio 2.76:1</li>
                    <li>Option: SVG dark bg</li>
                </ul>
            </div>
        </div>
    @endif
@endsection
