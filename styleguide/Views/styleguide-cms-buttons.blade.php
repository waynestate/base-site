@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

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
        <h2>Increase button text size</h2>
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
        <h2>Give a button two lines</h2>
        <p>Notice the addition of the "button--two-line" class. You must contain each line within &lt;em&gt; &lt;/em&gt; when using this style in the CMS.</p>
        <div class="pb-4 2xl:flex items-start">
            <div class="mr-4 flex-shrink-0 2xl:w-1/4">
                <a href="#" class="button button--two-line w-full">
                    <div class="button__title">Two line button</div>
                    <div class="button__excerpt">Subtext</div>
                </a>
            </div>
<pre class="code-block mb-0 w-full">
{!! htmlspecialchars('<a href="#" class="button button--two-line w-full">
    <strong class="button__title">Two line button</strong>
    <em class="button__excerpt">Subtext</em>
</a>') !!}
</pre>
        </div>
        <h2>Give a button two lines with an icon</h2>
        <p>Your icon must be an SVG or 50x50 pixels and must match the text color.</p>
        <div class="pb-4 2xl:flex items-start">
            <div class="md:mr-4 flex-shrink-0">
                <a href="#" class="button button--two-line">
                    <img src="/styleguide/image/50x50" alt="" class="button__image">
                    <div class="button__title">Two line button</div>
                    <div class="button__excerpt">Subtext</div>
                </a>
            </div>
<pre class="code-block mb-0 w-full">
{!! htmlspecialchars('<a href="#" class="button button--two-line">
    <img src="/styleguide/image/50x50" alt="" class="button__image">
    <strong class="button__title">Two line button</strong>
    <em class="button__excerpt">Subtext</em>
</a>') !!}
</pre>
        </div>
        <h2>Two or three buttons in a row</h2>
        <p>Do not mix colors or styles in this presentation.</p>
        <div class="pb-4">
            <div class="grid-three-col-layout mt-4 mb-2 gap-x-4 gap-y-2">
                <a href="#" class="button text-lg">Large text button</a>
                <a href="#" class="button text-lg">Large text button</a>
            </div>
<pre class="code-block mb-0 w-full">
{!! htmlspecialchars('<div class="grid-three-col-layout my-4 gap-x-4 gap-y-2">
    <a href="#" class="button text-lg">Large text button</a>
    <a href="#" class="button text-lg">Large text button</a>
    <a href="#" class="button text-lg">Large text button</a>
</div>') !!}
</pre>
        </div>
    </div>
@endsection
