{{--
    modular-component {
        "sectionClass":"bg-cover bg-center py-16", // class on section element, margins/padding/background
        "backgroundImageUrl":"https://domain.edu/url.jpg",
        "containerClass":"row", //class containing component content/restricting max with
    }
--}}

@if(!empty($base['components']))
    <div class="flex flex-wrap items-start mt:justify-center gap-y-16">
        @foreach($base['components'] as $componentName => $component)
            @if(!empty($component['data']) && !empty($component['component']['filename']) && \View::exists('components/'.$component['component']['filename']))
                <section id="{{ Str::slug($componentName) }}" class="{{ !empty($component['component']['sectionClass']) ? $component['component']['sectionClass'] : $component['component']['filename'] }} w-full {{ !empty($component['component']['column-span']) ? 'mt:colspan-'.$component['component']['column-span'] : '' }} {{ ($loop->iteration % 2 === 0) ? 'xbg-gold-100' : 'xbg-green-100' }} relative">
                    <div class="component__container {{ strpos($component['component']['filename'], 'page-content') !== 0 ? 'px-container' : '' }}">
                        @if(!empty($component['component']['heading']))
                            @include('partials/heading', ['heading' => $component['component']['heading'], 'headingClass' => 'mt-0 '.($component['component']['headingClass'] ?? ''), 'headingLevel' => !empty($component['component']['headingLevel']) ? $component['component']['headingLevel'] : 'h2'])
                        @endif

                        @if(!empty($component['data']))
                            @include('components/'.$component['component']['filename'], ['data' => $component['data'], 'component' => $component['component']])
                        @endif
                    </div>
                </section>
            @endif
        @endforeach
    </div>
@endif
