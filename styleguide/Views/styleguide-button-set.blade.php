@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
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
            <h2>Button appearance examples</h2>
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
