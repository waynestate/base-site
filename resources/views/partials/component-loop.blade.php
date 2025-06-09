{{--
    modular-component {
        "sectionClass":"bg-cover bg-center py-16", // class on section element, margins/padding/background
        "backgroundImageUrl":"https://domain.edu/url.jpg",
    }

    Troubleshooting, insert this below the first foreach:
    @dump($componentName, $component);
--}}

@if(!empty($base['components']))
    <div id="component-loop" class="flex flex-wrap items-start mt:justify-center">
        @foreach($base['components'] as $componentName => $component)
            @if(!empty($component['data']) && !empty($component['component']['filename']) && \View::exists('components/'.$component['component']['filename']))
                <section id="{{ Str::slug($componentName) }}" class="relative w-full {{ $component['component']['containerClass'] ?? ''}}">
                    <div class="component__container {{ $component['component']['componentClass'] ?? ''}} {{ in_array($base['page']['controller'], config('base.full_width_controllers')) ? '' : 'relative overflow-hidden' }}">
                        <div class="component__background {{ $component['component']['backgroundClass'] ?? ''}}" {!! $component['component']['backgroundImageUrl'] ?? '' !!}></div>
                        @if(!empty($component['component']['heading']))
                            @include('partials/heading', [
                                'heading' => $component['component']['heading'], 
                                'headingClass' => 'mt-0 '.($component['component']['headingClass'] ?? ''), 
                                'headingLevel' => $component['component']['headingLevel'] ?? 'h2',
                            ])
                        @endif
                        @if(!empty($component['data']))
                            @include('components/'.$component['component']['filename'], [
                                'data' => $component['data'], 
                                'component' => $component['component']
                            ])
                        @endif
                    </div>
                </section>
                @if(!empty($component['component']['containerClass']) && Str::contains($component['component']['containerClass'], 'end'))
                    <hr class="row-break" />
                @endif
            @endif
        @endforeach
    </div>
@endif
