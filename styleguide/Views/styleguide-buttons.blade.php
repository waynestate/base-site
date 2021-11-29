@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Any of these button styles can be used in all of the following examples.</p>
        <div class="pb-4 2xl:flex items-start">
            <a href="#standard-button" class="button 2xl:w-1/4 mr-4">Standard button</a>
<pre class="code-block mb-0">
{!! htmlspecialchars('<a href="#" class="button">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 2xl:flex items-start">
            <a href="#green-button" class="green-button 2xl:w-1/4 mr-4 flex-shrink-0">Green button</a>
<pre class="code-block mb-0">
{!! htmlspecialchars('<a href="#" class="green-button">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 2xl:flex items-start">
            <a href="#green-gradient-button" class="green-gradient-button 2xl:w-1/4 mr-4 flex-shrink-0">Green gradient button</a>
<pre class="code-block mb-0">
{!! htmlspecialchars('<a href="#" class="green-gradient-button">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 2xl:flex items-start">
            <a href="#gold-button" class="gold-button 2xl:w-1/4 mr-4 flex-shrink-0">Gold button</a>
<pre class="code-block mb-0">
{!! htmlspecialchars('<a href="#" class="gold-button">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 2xl:flex items-start">
            <a href="#gold-gradient-button" class="gold-gradient-button 2xl:w-1/4 mr-4 flex-shrink-0">Gold gradient button</a>
<pre class="code-block mb-0">
{!! htmlspecialchars('<a href="#" class="gold-gradient-button">My button</a>') !!}
</pre>
        </div>
        <h2 class="text-2xl">Increase button text size</h2>
        <p>Add class "text-lg" or "text-xl" to your button.</p>
        <div class="pb-4 2xl:flex items-start">
            <a href="#gold-gradient-button" class="button text-lg 2xl:w-1/4 mr-4 flex-shrink-0">Large text button</a>
<pre class="code-block mb-0">
{!! htmlspecialchars('<a href="#" class="button text-lg">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 2xl:flex items-start">
            <a href="#gold-gradient-button" class="button text-xl 2xl:w-1/4 mr-4 flex-shrink-0">XL text button</a>
<pre class="code-block mb-0">
{!! htmlspecialchars('<a href="#" class="button text-xl">My button</a>') !!}
</pre>
        </div>
        <h2 class="text-2xl">Give a button two lines</h2>
        <p>Notice the addition of the "button--two-line" class. You must contain each line within &lt;em&gt; &lt;/em&gt; when using this style in the CMS.</p>
        <div class="pb-4 2xl:flex items-start">
            <div class="mr-4 flex-shrink-0 2xl:w-1/4">
                <a href="#standard-two-line" class="button button--two-line 2xl:w-full">
                    <div>Two line button</div>
                    <div>Brief subtext</div>
                </a>
            </div>
<pre class="code-block mb-0 w-full">
{!! htmlspecialchars('<a href="#" class="button button--two-line">
    <em>Nihil quaerat</em>
    <em>Velit consequuntur explicabo</em>
</a>') !!}
</pre>
        </div>
        <h2 class="text-2xl">Give a button two lines with an icon</h2>
        <p>Your icon must be an SVG or 50x50 pixels and must match the text color.</p>
        <div class="pb-4 2xl:flex items-start">
            <div class="mr-4 flex-shrink-0">
                <a href="#standard-two-line" class="button button--two-line">
                    <img src="/styleguide/image/50x50" alt="">
                    <div>Two line button</div>
                    <div>Brief subtext</div>
                </a>
            </div>
<pre class="code-block mb-0 w-full">
{!! htmlspecialchars('<a href="#" class="button button--two-line">
    <img src="/styleguide/image/50x50" alt="">
    <em>Nihil quaerat</em>
    <em>Velit consequuntur explicabo</em>
</a>') !!}
</pre>
        </div>
        <h2 class="text-2xl">Two or three buttons in a row</h2>
        <div class="pb-4">
            <div class="my-2 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-2 items-start">
                <a href="#standard-two-line" class="button button--two-line">
                    <div>Two line button</div>
                    <div>Brief subtext</div>
                </a>
                <a href="#standard-two-line" class="button button--two-line">
                    <div>Two line button</div>
                    <div>Brief subtext</div>
                </a>
            </div>
<pre class="code-block mb-0 w-full">
{!! htmlspecialchars('<div class="my-2 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-2">
    <a href="#" class="button">Standard button</a>
    <a href="#" class="button">Standard button</a>
    <a href="#" class="button">Standard button</a>
</div>') !!}
</pre>
        </div>
    </div>
@endsection
