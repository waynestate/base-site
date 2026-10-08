{{--
modular-component {
    "columnSpan":6,
    "classes":"bg-cover bg-center py-16", // class on section element, margins/padding/background
    "backgroundImageUrl":"https://domain.edu/url.jpg",
    "heading":"My heading",
    "headingClass":"divider-gold",
    "headingLevel":"h3",
}
--}}

@if(!empty($base['components']))
    <div id="component-loop" class="flex flex-wrap items-start mt:justify-center">
        @foreach($base['components'] as $componentName => $component)
            @php
                $componentView = null;

                if (!empty($component['component']['filename'])) {
                    $componentView = component_view($component['component']['filename']);
                }
            @endphp
            @if(!empty($component['data']) && $componentView !== null && \View::exists($componentView))
                <section id="{{ Str::slug($componentName) }}" class="relative w-full {{ $component['component']['containerClass'] ?? ''}}">
                    <div class="component__container {{ $component['component']['componentClass'] ?? ''}} {{ in_array($base['page']['controller'], config('base.full_width_controllers')) ? '' : 'relative' }}">
                        <div class="component__background {{ $component['component']['backgroundClass'] ?? ''}}" {!! $component['component']['backgroundImageUrl'] ?? '' !!}></div>
                        @if(!empty($component['component']['heading']))
                            @include('partials/heading', [
                                'heading' => $component['component']['heading'], 
                                'headingClass' => 'mt-0 '.($component['component']['headingClass'] ?? ''), 
                                'headingLevel' => $component['component']['headingLevel'] ?? 'h2',
                            ])
                        @endif
                        @if(!empty($component['data']))
                            @include($componentView, [
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
