@if(!empty($base['components']))
    <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
        @foreach($base['components'] as $componentName => $component)
            @if(!empty($component['data']) && !empty($component['component']['filename']))
                @if(\View::exists('components/'.$component['component']['filename']))
                    <div class="col-span-2 {{ str_contains($component['component']['filename'], 'column') ? 'md:col-span-1' : 'md:col-span-2' }}">
                        @if(!empty($component['component']['heading']))
                            @include('partials/heading', ['heading' => $component['component']['heading'], 'headingClass' => 'mt-0 '.($component['component']['headingClass'] ?? ''), 'headingLevel' => !empty($component['component']['headingLevel']) ? $component['component']['headingLevel'] : 'h2'])
                        @endif

                        @include('components/'.$component['component']['filename'], ['data' => $component['data'], 'component' => $component['component']])
                    </div>
                @endif
            @endif
        @endforeach
    </div>
@endif
