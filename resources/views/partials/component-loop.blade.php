{{--
    modular-component {
        "sectionClass":"bg-cover bg-center py-16", // class on section element, margins/padding/background
        "backgroundImageUrl":"https://domain.edu/url.jpg",
    }
--}}

@if(!empty($base['components']))
    <div id="component-loop" class="flex flex-wrap items-start mt:justify-center {{ $base['layout-config']['layoutClass'] ?? '[&>section]:mb-gutter-xl' }}">
        @foreach($base['components'] as $componentName => $component)
            @if(!empty($component['data']) && !empty($component['component']['filename']) && \View::exists('components/'.$component['component']['filename']))
                <section id="{{ Str::slug($componentName) }}" class="relative w-full {{ $component['component']['componentClasses'] ?? ''}}" {!! $component['component']['componentStyle'] ?? '' !!}>
                        @if(!empty($component['component']['heading']))
                            @include('partials/heading', ['heading' => $component['component']['heading'], 'headingClass' => 'mt-0 '.($component['component']['headingClass'] ?? ''), 'headingLevel' => !empty($component['component']['headingLevel']) ? $component['component']['headingLevel'] : 'h2'])
                        @endif

                        @if(!empty($component['data']))
                            @include('components/'.$component['component']['filename'], ['data' => $component['data'], 'component' => $component['component']])
                        @endif
                </section>
                @if(!empty($component['component']['componentClasses']) && Str::contains($component['component']['componentClasses'], 'end'))
                    <hr class="row-break" />
                @endif
            @endif
        @endforeach
    </div>
@endif
