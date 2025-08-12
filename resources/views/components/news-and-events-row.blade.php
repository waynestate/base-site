<div class="grid-two-col-layout">
    @if(!empty($data['news']))
        <div>
            @include('partials/heading', [
                'heading' => 'News', 
                'headingClass' => 'mt-0 '.($component['headingClass'] ?? ''), 
                'headingLevel' => $component['headingLevel'] ?? 'h2',
            ])
            @include('components.news-column', ['data' => $data['news']])
        </div>
    @endif
    @if(!empty($data['events']))
        <div>
            @include('partials/heading', [
                'heading' => 'Events', 
                'headingClass' => 'mt-0 '.($component['headingClass'] ?? ''), 
                'headingLevel' => $component['headingLevel'] ?? 'h2',
            ])
            @include('components.events-column', ['data' => $data['events']])
        </div>
    @endif
</div>
