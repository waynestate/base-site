{{--
    modular-component {
        "sectionClass":"bg-cover bg-center py-16", // class on section element, margins/padding/background
        "backgroundImageUrl":"https://domain.edu/url.jpg",
        "containerClass":"row", //class containing component content/restricting max with
    }
--}}

@if(!empty($base['components']))
    <div class="grid md:grid-cols-modular {{ $base['components']['layout-config']['component']['gap'] ?? '' }} {{ $base['components']['layout-config']['component']['margin'] ?? '' }}">
        @foreach($base['components'] as $componentName => $component)
            @if(!empty($component['data']) && !empty($component['component']['filename']) && \View::exists('components/'.$component['component']['filename']))
                <section id="{{ Str::slug($componentName) }}" 
                    class="modular-{{ $component['component']['filename']}} 
                    {{ str_contains($component['component']['filename'], 'column') 
                        ? 'col-span-2 '.(($loop->iteration % 2 === 0) ? 'bg-gold' : 'bg-green-300')
                        : 'col-span-2 md:col-span-full bg-gold-100' }} 
                        px-container
                        py-8
                        md:grid md:grid-cols-subgrid 
                        place-content-start
                    {{ $component['component']['sectionClass'] ?? '' }}" 
                    @if(!empty($component['component']['backgroundImageURL'])) style="background-image:url('{{ $component['component']['backgroundImageUrl'] }}')"@endif
                >
                    <div class="component__container {{ $component['component']['containerClass'] ?? '' }} 
                        {{ str_contains($component['component']['filename'], 'column') 
                            ? 'grid-content '.(($loop->iteration % 2 === 0) ? 'bg-gold-100' : 'bg-green-100')
                            : 'col-span-full bg-gold' }} 
                        relative
                    ">
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
