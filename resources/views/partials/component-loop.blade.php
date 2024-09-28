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
@php
    dump($base['components']);
@endphp
@if(!empty($base['components']))
    <div class="grid grid-cols-1 md:grid-cols-2 items-start 
        {{ $base['components']['layout-config']['component']['gridGap'] ?? 'gap-y-8 sm:gap-x-4 lg:gap-x-8' }} 
        {{ $base['components']['layout-config']['component']['margin'] ?? 'mt-8 mb-4' }} 
        {{ $base['components']['layout-config']['component']['class'] ?? '' }}
    ">
        @foreach($base['components'] as $componentName => $component)
            @if(!empty($component['data']) && !empty($component['component']['filename']) && \View::exists('components/'.$component['component']['filename']))
                <section 
                    id="{{ Str::slug($componentName) }}" 
                    class="{{-- flex justify-end --}}col-span-2 
                        {{ str_contains($component['component']['filename'], 'column') ? 'md:col-span-1' : 'md:col-span-2' }} 
                        {{(in_array($component['component']['filename'], config('base.full_width_components')) 
                            || (!empty($component['component']['fullWidth']) && $component['component']['fullWidth'] === true)) ? '' : 'container-sm' 
                        }} 
                        {{ $component['component']['sectionClass'] ?? '' }}" 
                    @if(!empty($component['component']['backgroundImageUrl'])) style="background-image:url('{{ $component['component']['backgroundImageUrl'] }}');" @endif 
                >
                    <div class="component__container 
                        {{ $component['component']['containerClass'] ?? 'w-full' }} 
                        {{ !empty($component['component']['fullWidth']) && $component['component']['fullWidth'] === true 
                            && !in_array($component['component']['filename'], config('base.heading_components')) ? 'container-sm space-sm' : ''
                        }}
                    ">
                        @if(!empty($component['heading']))
                            @include('partials/heading')
                        @endif

                        {{-- Only send the non-heading related data to the component, unless its a catalog which uses that information --}}
                        @if(!in_array($component['component']['filename'], config('base.heading_components')) 
                            && !empty($component['data']['Heading']) 
                            && !empty($component['data']['items'])
                        )
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
