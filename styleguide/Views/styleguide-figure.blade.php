@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}

        <p>Available classes for <code class="bg-grey-lightest py-px pb-1 px-1 text-sm">&lt;figure&gt;</code> are <code class="bg-grey-lightest py-px pb-1 px-1 text-sm">.float-left</code>, <code class="bg-grey-lightest py-px pb-1 px-1 text-sm">.float-right</code>, and <code class="bg-grey-lightest py-px pb-1 px-1 text-sm">.text-center</code>.</p>

        <figure>
            @image('/styleguide/image/400x300', '', 'p-2')
            <figcaption>{{ $faker->sentence }}</figcaption>
        </figure>

        <pre class="bg-grey-lightest overflow-scroll p-4">
        {!! htmlspecialchars('
<figure>
    <img src="/styleguide/image/400x300" alt="">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>') !!}
        </pre>

        <hr>

        <div class="row flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <h2>Float left</h2>

                <figure class="float-left">
                    @image('/styleguide/image/400x300', '', 'p-2')
                    <figcaption>{{ $faker->sentence }}</figcaption>
                </figure>
                <p>{{ $faker->paragraph(38) }}</p>

                <pre class="bg-grey-lightest overflow-scroll p-4">
                {!! htmlspecialchars('
<figure class="float-left">
    <img src="/styleguide/image/400x300" alt="">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>')!!}
                </pre>
            </div>
        </div>

        <hr>

        <div class="row flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <h2>Float right</h2>

                <figure class="float-right">
                    @image('/styleguide/image/400x300', '', 'p-2')
                    <figcaption>{{ $faker->sentence }}</figcaption>
                </figure>
                <p>{{ $faker->paragraph(28) }}</p>

                <pre class="bg-grey-lightest overflow-scroll p-4">
                {!! htmlspecialchars('
<figure class="float-right">
    <img src="/styleguide/image/400x300" alt="">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>') !!}
                </pre>
            </div>
        </div>

        <hr>

        <div class="row flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <h2>Text center</h2>

                <p>{{ $faker->paragraph(12) }}</p>
                <figure class="text-center">
                    @image('/styleguide/image/800x450', '', 'p-2')
                    <figcaption>{{ $faker->sentence }}</figcaption>
                </figure>
                <p>{{ $faker->paragraph(12) }}</p>

                <pre class="bg-grey-lightest overflow-scroll p-4">
                {!! htmlspecialchars('
<figure class="text-center">
    <img src="/styleguide/image/800x450" alt="">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>') !!}
                </pre>
            </div>
        </div>
    </div>
@endsection
