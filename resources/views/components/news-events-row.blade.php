<div class="grid-two-col-layout">
    <div>
        @include('partials/heading', [
            'heading' => 'News', 
            'headingClass' => 'mt-0 '.($component['component']['headingClass'] ?? ''), 
            'headingLevel' => $component['component']['headingLevel'] ?? 'h2',
        ])
        @include('components.news-column', ['data' => $data['news']])
    </div>
    <div>
        @include('partials/heading', [
            'heading' => 'Events', 
            'headingClass' => 'mt-0 '.($component['component']['headingClass'] ?? ''), 
            'headingLevel' => $component['component']['headingLevel'] ?? 'h2',
        ])
        @include('components.events-column', ['data' => $data['events']])
    </div>
</div>
