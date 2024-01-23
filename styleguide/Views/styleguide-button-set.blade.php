@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
        <h2>Best use cases for buttons</h2>
        <h3 class="text-lg my-0">Call-to-Action (CTA) buttons</h3>
        <ul>
            <li><strong>Purpose:</strong> Encourage specific actions from users.
            <li><strong>Examples:</strong> "Apply now," "Request information," "Speak with an advisor," etc.
            <li><strong>Placement:</strong> CTAs are most effective on landing pages and frequently visited sections with important information.
        </ul>
        <h3 class="text-lg my-0">Under-menu button column</h3>
        <ul>
            <li><strong>Purpose:</strong> Facilitate easy navigation to pages not within one step of the menu or to resources not within the website but relevant to the page content.</li>
            <li><strong>Examples:</strong> "Schedule appointment" "Make a payment," "Check application status," "Program requirements" etc.</li>
            <li><strong>Note:</strong> On mobile, the under-menu buttons are inserted beneath the first paragraph.</li>
        </ul>

        <h2>Guidelines for button usage</h2>
        <ul>
            <li><strong>Consistency:</strong> Ensure a consistent button design and placement across the website.</li>
            <li><strong>Button styling:</strong> We have <a href="/styleguide/buttons">multiple button styles</a>. Make sure to not mix button styles in one setting to maintain a consistent visual appearance across the website. Jump to <a href="/styleguide/buttonset#button-appearance-examples">button appearance examples</a> to see how to configure buttons in a promotion group.</li>
            <li><strong>Accessibility:</strong> Buttons should have sufficient color contrast and visual clarity to accommodate users with visual impairments. This ensures that button text and graphics are easily distinguishable from the background. The button styles we offer meet these requirements.</li>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-y-8 sm:gap-x-4 lg:gap-x-8 mt-8 mb-4">
        <div class="col-span-full">
            @include('components/accordion', ['data' => $accordion['data'], 'component' => $accordion['component']])
        </div>
        <div class="col-span-full">
            <h2 class="mt-0">{{ $button_row_1['component']['heading'] }}</h2>
            @include('components/button-row', ['data' => $button_row_1['data'], 'component' => $button_row_1['component']])
        </div>
        <div class="col-span-1">
            <h2 class="mt-0">{{ $button_column_1['component']['heading'] }}</h2>
            @include('components/button-column', ['data' => $button_column_1['data'], 'component' => $button_column_1['component']])
        </div>
        <div class="col-span-full">
            <hr />
            <h2 id="button-appearance-examples">Button appearance examples</h2>
            <p>A button's appearance depends on which fields you add to the promotion item.</p>
            <p>For "Default" and "Green" buttons, the excerpt displays as a second line line of text, and the primary image displays as a small icon next to either one or two lines of text. 
            <p class="mb-0">For "Image" buttons, a primary and secondary image create a layered effect. None of the text fields are used when "Image" is selected.</p> 
        </div>
        <div class="col-span-1">
            <h3 class="mt-0">Default buttons</h3>
            @include('components/button-column', ['data' => $button_column_2['data'], 'component' => $button_column_2['component']])
            <h3>Green buttons</h3>
            @include('components/button-column', ['data' => $button_column_3['data'], 'component' => $button_column_3['component']])
        </div>
        <div class="col-span-1">
            <h3 class="mt-0">Image buttons</h3>
            @include('components/button-column', ['data' => $button_column_4['data'], 'component' => $button_column_4['component']])
        </div>
    </div>


@endsection
