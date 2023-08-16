@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Any of these button styles can be used in all of the following examples.</p>
        <div class="flex flex-wrap 2xl:flex-nowrap items-start gap-x-4 mb-4">
            <a href="#standard-button" class="button w-full shrink-0 sm:w-1/2 xl:w-1/3 2xl:w-1/4">Standard button</a>
<pre>
{!! htmlspecialchars('<a href="#" class="button">My button</a>') !!}
</pre>
        </div>
        <div class="flex flex-wrap 2xl:flex-nowrap items-start gap-x-4 mb-4">
            <a href="#green-button" class="green-button w-full shrink-0 sm:w-1/2 xl:w-1/3 2xl:w-1/4">Green button</a>
<pre>
{!! htmlspecialchars('<a href="#" class="green-button">My button</a>') !!}
</pre>
        </div>
        <div class="flex flex-wrap 2xl:flex-nowrap items-start gap-x-4 mb-4">
            <a href="#green-gradient-button" class="green-gradient-button shrink-0 w-full sm:w-1/2 xl:w-1/3 2xl:w-1/4">Green gradient button</a>
<pre>
{!! htmlspecialchars('<a href="#" class="green-gradient-button">My button</a>') !!}
</pre>
        </div>
        <div class="flex flex-wrap 2xl:flex-nowrap items-start gap-x-4 mb-4">
            <a href="#gold-button" class="gold-button shrink-0 w-full sm:w-1/2 xl:w-1/3 2xl:w-1/4">Gold button</a>
<pre>
{!! htmlspecialchars('<a href="#" class="gold-button">My button</a>') !!}
</pre>
        </div>
        <div class="flex flex-wrap 2xl:flex-nowrap items-start gap-x-4 mb-4">
            <a href="#gold-gradient-button" class="gold-gradient-button shrink-0 w-full sm:w-1/2 xl:w-1/3 2xl:w-1/4">Gold gradient button</a>
<pre>
{!! htmlspecialchars('<a href="#" class="gold-gradient-button">My button</a>') !!}
</pre>
        </div>

        <h2>Two or three buttons in a row</h2>
        <p>Do not mix colors or styles in this presentation.</p>
        <div class="pb-4">
            <div class="flex flex-wrap md:flex-nowrap gap-x-4 gap-y-2">
                <a href="#" class="button text-lg w-full">Large text button</a>
                <a href="#" class="button text-lg w-full">Large text button</a>
                <a href="#" class="button text-lg w-full">Large text button</a>
            </div>
<pre>
{!! htmlspecialchars('<div class="flex flex-wrap md:flex-nowrap gap-x-4 gap-y-2">
    <a href="#" class="button text-lg w-full">Large text button</a>
    <a href="#" class="button text-lg w-full">Large text button</a>
    <a href="#" class="button text-lg w-full">Large text button</a>
</div>') !!}
</pre>
        </div>

        <h2 id="button-text-size">Increase button text size</h2>
        <p>Add class "text-lg" or "text-xl" to your button.</p>
        <div class="flex flex-wrap 2xl:flex-nowrap items-start gap-x-4 mb-4">
            <a href="#large-text-button" class="button text-lg shrink-0 w-full sm:w-1/2 xl:w-1/3 2xl:w-1/4">Large text button</a>
<pre>
{!! htmlspecialchars('<a href="#" class="button text-lg">My button</a>') !!}
</pre>
        </div>
        <div class="flex flex-wrap 2xl:flex-nowrap items-start gap-x-4 mb-4">
            <a href="#xl-text-button" class="button text-xl shrink-0 w-full sm:w-1/2 xl:w-1/3 2xl:w-1/4">XL text button</a>
<pre>
{!! htmlspecialchars('<a href="#" class="button text-xl">My button</a>') !!}
</pre>
        </div>
        <h2>Buttons with two lines</h2>
        <p>With the "two-line-button" class, you must contain each line within a <code>&lt;div&gt; &lt;/div&gt;</code>.</p>
        <p>Your icon must be an SVG or 50x50 pixels and must match the text color.</p>
        <div class="pb-4 flex flex-wrap xl:flex-nowrap items-start gap-x-4">
            <a href="#standard-two-line" class="two-line-button shrink-0 w-full sm:w-1/2 xl:w-2/5 2xl:w-1/3">
                <div>Two line button</div>
                <div>Brief subtext</div>
            </a>
<pre>
{!! htmlspecialchars('<a href="#" class="two-line-button">
    <div>Nihil quaerat</div>
    <div>Velit consequuntur explicabo</div1>
</a>') !!}
</pre>
        </div>
        <div class="pb-4 flex flex-wrap xl:flex-nowrap items-start gap-x-4">
            <a href="#standard-two-line" class="two-line-button shrink-0 w-full sm:w-1/2 xl:w-2/5 2xl:w-1/3">
                <img src="/styleguide/image/50x50" alt="">
                <div>Two line button</div>
                <div>Brief subtext</div>
            </a>
<pre>
{!! htmlspecialchars('<a href="#" class="two-line-button">
    <img src="/styleguide/image/50x50" alt="">
    <div>Nihil quaerat</div>
    <div>Velit consequuntur explicabo</div>
</a>') !!}
</pre>
        </div>
    </div>
@endsection
