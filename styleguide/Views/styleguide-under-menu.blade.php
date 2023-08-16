@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <p>Under menu buttons are available through promotion groups. Please email <a href="mailto:web@wayne.edu" class="underline hover:no-underline">web@wayne.edu</a> to find out how to add this to your site.</p>
    <p>At the bottom of the menu on the left, you can see the default buttons in use. You may not mix button types on a single page.</p>
    <p>When setting up the promo group, add as few or as many of these options to use on the site:<br /><code>Default, Green, Gold, Bg image dark, Bg image light</code>

    <div class="under-menu">
        @if(!empty($buttons))
            <h2 class="mb-4">Default buttons</h2>
            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-default', ['button' => $buttons['default'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Option: None or 'Default'</li>
                    </ul>
                </div>
            </div>

            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-default', ['button' => $buttons['default_two_lines'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Excerpt</li>
                        <li>Option: None or 'Default'</li>
                    </ul>
                </div>
            </div>

            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-default', ['button' => $buttons['default_icon'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Excerpt</li>
                        <li>Filename: <a href="/styleguide/colors" class="underline hover:no-underline">Green-800</a> SVG 40x40</li>
                        <li>Option: None or 'Default'</li>
                    </ul>
                </div>
            </div>

            <hr />
            
            <h2 class="mb-4">Green buttons</h2>
            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-green', ['button' => $buttons['green'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Option: Green</li>
                    </ul>
                </div>
            </div>

            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-green', ['button' => $buttons['green_two_lines'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Excerpt</li>
                        <li>Option: Green</li>
                    </ul>
                </div>
            </div>

            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-green', ['button' => $buttons['green_icon'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Excerpt</li>
                        <li>Filename: White SVG 40x40</li>
                        <li>Option: Green</li>
                    </ul>
                </div>
            </div>

            <hr />

            <h2 class="mb-4">Gold buttons</h2>
            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-gold', ['button' => $buttons['default'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Option: Gold</li>
                    </ul>
                </div>
            </div>

            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-gold', ['button' => $buttons['default_two_lines'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Excerpt</li>
                        <li>Option: Gold</li>
                    </ul>
                </div>
            </div>

            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-gold', ['button' => $buttons['default_icon'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Excerpt</li>
                        <li>Filename: <a href="/styleguide/colors" class="underline hover:no-underline">Green-800</a> SVG 40x40</li>
                        <li>Option: Gold</li>
                    </ul>
                </div>
            </div>

            <hr />

            <h2 class="mb-4">Image buttons</h2>
            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-bg-image-light', ['button' => $buttons['bg_image_light'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Link</li>
                        <li>Primary image/filename: 
                            <ul class="ml-6 list-disc">
                                <li>Light colors</li>
                                <li>600x218 jpg</li>
                                <li>Ratio 2.76:1</li>
                            </ul>
                        </li>
                        <li>Option: Bg image light</li>
                    </ul>
                </div>
            </div>

            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-bg-image-dark', ['button' => $buttons['bg_image_dark'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Link</li>
                        <li>Primary image/filename: 
                            <ul class="ml-6 list-disc">
                                <li>Dark colors</li>
                                <li>600x218 jpg</li>
                                <li>Ratio 2.76:1</li>
                            </ul>
                        </li>
                        <li>Option: Bg image dark</li>
                    </ul>
                </div>
            </div>

            <hr />

            <h2 class="mb-4">SVG buttons</h2>
            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-bg-image-light', ['button' => $buttons['svg_light_bg'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Link</li>
                        <li>Primary image/filename: 
                            <ul class="ml-6 list-disc">
                                <li>Light colors</li>
                                <li>600x218 jpg</li>
                                <li>Ratio 2.76:1</li>
                            </ul>
                        </li>
                        <li>Secondary Image: 
                            <ul class="ml-6 list-disc">
                                <li>Dark/black colors</li>
                                <li>600x218 SVG</li>
                                <li>Ratio 2.76:1</li>
                            </ul>
                        </li>
                        <li>Option: Bg image light</li>
                    </ul>
                </div>
            </div>

            <div class="pb-4 md:flex items-start">
                <div class="md:mr-4 flex-shrink-0">
                    @include('components.button-bg-image-dark', ['button' => $buttons['svg_dark_bg'], 'class' => 'w-72'])
                </div>
                <div>
                    <h3 class="text-sm ">Promo setup:</h3>
                    <ul class="ml-6 list-disc text-sm">
                        <li>Title</li>
                        <li>Link</li>
                        <li>Primary image/filename: 
                            <ul class="ml-6 list-disc">
                                <li>Darker colors</li>
                                <li>600x218 jpg</li>
                                <li>Ratio 2.76:1</li>
                            </ul>
                        </li>
                        <li>Secondary Image: 
                            <ul class="ml-6 list-disc">
                                <li>White/light colors</li>
                                <li>600x218 SVG</li>
                                <li>Ratio 2.76:1</li>
                            </ul>
                        </li>
                        <li>Option: Bg image dark</li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endsection
