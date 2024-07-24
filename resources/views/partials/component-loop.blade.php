{{--
    [component] {
        "sectionClass":"bg-cover bg-center py-16",
        "backgroundImageUrl":"https://domain.edu/url.jpg",
        "containerClass":"row",
        "headingClass":"mt-0",
        "headingLevel":"h2",
    }

    layout-config {
        "gridGap":"gap-y-8 sm:gap-x-4 lg:gap-x-8";
        "margin":"mt-8 mb-4";
        "class":"my_class"; //custom cascading class to style all h2's etc 
    }
--}}
@if(!empty($base['components']))
    <div class="grid grid-cols-1 md:grid-cols-2 items-start {{ $base['components']['layout-config']['component']['gridGap'] ?? 'gap-y-8 sm:gap-x-4 lg:gap-x-8' }} {{ $base['components']['layout-config']['component']['margin'] ?? 'mt-8 mb-4' }} {{ $base['components']['layout-config']['component']['class'] ?? '' }}">
        @foreach($base['components'] as $componentName => $component)
            @if(!empty($component['data']) && !empty($component['component']['filename']) && \View::exists('components/'.$component['component']['filename']))
                <section id="{{ Str::slug($componentName) }}" class="col-span-2 {{ str_contains($component['component']['filename'], 'column') ? 'md:col-span-1' : 'md:col-span-2' }} {{ $component['component']['sectionClass'] ?? '' }}" @if(!empty($component['component']['backgroundImageUrl'])) style="background-image:url('{{ $component['component']['backgroundImageUrl'] }}');" @endif >
                    <div class="component__container {{ $component['component']['containerClass'] ?? 'row px-4' }}">
                        @if(!empty($component['data']['Heading']))
                            <div class="component__heading content">
                                @include('partials/heading', ['heading' => $component['data']['Heading'][0]['title'], 'headingClass' => $component['component']['headingClass'] ?? '', 'headingLevel' => $component['component']['headingLevel'] ?? 'h2'])
                                {!! $component['data']['Heading'][0]['description'] !!}
                            </div>
                        @elseif(!empty($component['component']['heading']))
                            @include('partials/heading', ['heading' => $component['component']['heading'], 'headingClass' => 'mt-0 '.($component['component']['headingClass'] ?? ''), 'headingLevel' => !empty($component['component']['headingLevel']) ? $component['component']['headingLevel'] : 'h2'])
                        @endif

                        {{-- Only send the non-heading related data to the component, unless its a catalog which uses that information --}}
                        @if(!empty($component['component']['groupByOptions']) && $component['component']['groupByOptions'] === true && !Str::contains($component['component']['filename'], 'catalog'))
                            @include('components/'.$component['component']['filename'], ['data' => $component['data']['items'], 'component' => $component['component']])
                        @else
                            @include('components/'.$component['component']['filename'], ['data' => $component['data'], 'component' => $component['component']])
                        @endif
                    </div>
                </section>
            @endif
        @endforeach
    </div>
@endif
