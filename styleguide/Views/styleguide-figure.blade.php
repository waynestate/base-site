@extends('layouts.' . (!empty($layout) ? $layout : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}

        <p><code>&lt;figure&gt;</code> is used to highlight an image with a caption. It appears centered by default.</p>

        <h2>Default</h2>
        <p>{{ $faker->paragraph(8) }}</p>
        <figure class="figure">
            @image('/styleguide/image/400x225', '', 'p-2')
            <figcaption>{{ $faker->sentence() }}</figcaption>
        </figure>
        <p>{{ $faker->paragraph(8) }}</p>

        <h2>Left aligned</h2>
        <p><code>&lt;figure class="figure float-left"&gt;</code></p>

        <figure class="figure float-left">
            @image('/styleguide/image/400x225', '', 'p-2')
            <figcaption>{{ $faker->sentence() }}</figcaption>
        </figure>
        <p>{{ $faker->paragraph(28) }}</p>

        <h2>Right aligned</h2>
        <p><code>&lt;figure class="figure float-right"&gt;</code></p>

        <figure class="figure float-right">
            @image('/styleguide/image/400x225', '', 'p-2')
            <figcaption>{{ $faker->sentence() }}</figcaption>
        </figure>
        <p>{{ $faker->paragraph(28) }}</p>

        <h2>Source code</h2>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<figure class="figure">
    <img src="/styleguide/image/400x300" alt="">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>') !!}
</pre>
    </div>
@endsection
