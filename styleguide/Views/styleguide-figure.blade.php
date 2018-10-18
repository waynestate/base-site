@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}

        <p>Available classes for <code class="bg-grey-lightest py-px pb-1 px-1 text-sm">&lt;figure&gt;</code> are <code class="bg-grey-lightest py-px pb-1 px-1 text-sm">.float-left</code>, <code class="bg-grey-lightest py-px pb-1 px-1 text-sm">.float-right</code>, and <code class="bg-grey-lightest py-px pb-1 px-1 text-sm">.text-center</code>.</p>

        <div class="table">
            <figure>
                @image('/styleguide/image/400x300', 'Placeholder', 'p-10px')
                <figcaption>{{ $faker->sentence }}</figcaption>
            </figure>
        </div>

        <a href="#fig-none" class="button" onclick="document.querySelector('pre.fig-none').classList.toggle('hidden');">See code</a>

        <pre class="fig-none hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<figure>
    <img src="/styleguide/image/400x300" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
        ') !!}
        </pre>

        <hr>

        <div class="row flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <h2>Float left</h2>

                <div class="table">
                    <figure class="float-left">
                        <img src="/styleguide/image/400x300" style="padding: 10px" alt="">
                        <figcaption>{{ $faker->sentence }}</figcaption>
                    </figure>
                    <p>{{ $faker->paragraph(38) }}</p>
                </div>

                <a href="#fig-left" class="button" onclick="document.querySelector('pre.fig-left').classList.toggle('hidden');">See code</a>

                <pre class="fig-left hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
                {!! htmlspecialchars('
<figure class="float-left">
    <img src="/styleguide/image/400x300" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
                ') !!}
                </pre>
            </div>
        </div>

        <hr>

        <div class="row flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <h2>Float right</h2>

                <div class="table">
                    <figure class="float-right">
                        @image('/styleguide/image/400x300', 'Placeholder', 'p-10px')
                        <figcaption>{{ $faker->sentence }}</figcaption>
                    </figure>
                    <p>{{ $faker->paragraph(28) }}</p>
                </div>

                <a href="#fig-right" class="button" onclick="document.querySelector('pre.fig-right').classList.toggle('hidden');">See code</a>

                <pre class="fig-right hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
                {!! htmlspecialchars('
<figure class="float-right">
    <img src="/styleguide/image/400x300" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
                ') !!}
                </pre>
            </div>
        </div>

        <hr>

        <div class="row flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <h2>Text center</h2>

                <div class="table">
                    <p>{{ $faker->paragraph(12) }}</p>
                    <figure class="text-center">
                        @image('/styleguide/image/800x450', 'Placeholder', 'p-10px')
                        <figcaption>{{ $faker->sentence }}</figcaption>
                    </figure>
                    <p>{{ $faker->paragraph(12) }}</p>
                </div>

                <a href="#fig-center" class="button" onclick="document.querySelector('pre.fig-center').classList.toggle('hidden');">See code</a>

                <pre class="fig-center hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
                {!! htmlspecialchars('
<figure class="text-center">
    <img src="/styleguide/image/800x450" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
                ') !!}
                </pre>
            </div>
        </div>


@endsection
