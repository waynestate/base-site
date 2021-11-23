@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <div class="pb-4 xl:flex items-start">
            <a href="#standard-button" class="button xl:w-1/4 mr-4">Standard button</a>
<pre class="code-block mb-0 2xl:w-3/4">
{!! htmlspecialchars('<a href="#" class="button">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 xl:flex items-start">
            <a href="#green-button" class="green-button xl:w-1/4 mr-4 flex-shrink-0">Green button</a>
<pre class="code-block mb-0 2xl:w-3/4">
{!! htmlspecialchars('<a href="#" class="green-button">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 xl:flex items-start">
            <a href="#green-gradient-button" class="green-gradient-button xl:w-1/4 mr-4 flex-shrink-0">Green gradient button</a>
<pre class="code-block mb-0 2xl:w-3/4">
{!! htmlspecialchars('<a href="#" class="green-gradient-button">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 xl:flex items-start">
            <a href="#gold-button" class="gold-button xl:w-1/4 mr-4 flex-shrink-0">Gold button</a>
<pre class="code-block mb-0 2xl:w-3/4">
{!! htmlspecialchars('<a href="#" class="gold-button">My button</a>') !!}
</pre>
        </div>
        <div class="pb-4 xl:flex items-start">
            <a href="#gold-gradient-button" class="gold-gradient-button xl:w-1/4 mr-4 flex-shrink-0">Gold gradient button</a>
<pre class="code-block mb-0 2xl:w-3/4">
{!! htmlspecialchars('<a href="#" class="gold-gradient-button">My button</a>') !!}
</pre>
        </div>
        <h2 class="text-2xl">Make any button two lines</h2>
        <p>Replace the first "button" class in the code below with any of the classes above, like "green-gradient-button".</p>
        <div class="pb-4 xl:flex items-start">
            <div class="2xl:w-1/4 mr-4 flex-shrink-0">
                <div>
                    <a href="#standard-two-line" class="button button--two-line 2xl:block">
                        <div>Two line button</div>
                        <div>Extra context for the reader</div>
                    </a>
                </div>
                <div>
                    <a href="#green-gradient-two-line" class="green-gradient-button button--two-line 2xl:block">
                        <div>Two line button</div>
                        <div>Extra context for the reader</div>
                    </a>
                </div>
                <div>
                    <a href="#gold-gradient-two-line" class="gold-gradient-button button--two-line 2xl:block">
                        <div>Two line button</div>
                        <div>Extra context for the reader</div>
                    </a>
                </div>
            </div>
<pre class="code-block mb-0 2xl:w-3/4">
{!! htmlspecialchars('<a href="#" class="button button--two-line">
    <em>Nihil quaerat</em>
    <em>Velit consequuntur explicabo</em>
</a>') !!}
</pre>
        </div>
    </div>
@endsection
