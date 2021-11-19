@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <h2 class="mt-4 divider-gold text-green font-normal">Single row of two columns layout</h2>

        <div class="single-row-two-col-layout">
            <div class="flex-shrink-0">
                <img src="/styleguide/image/350x200" alt="">
            </div>
            <div>
                <p>{{ $faker->text(350) }}</p>
            </div>
        </div>

        <div class="single-row-two-col-layout">
            <div>
                <p>{{ $faker->text(350) }}</p>
            </div>
            <div class="flex-shrink-0">
                <img src="/styleguide/image/350x200" alt="">
            </div>
        </div>

        <h3>Copy this into the CMS source editor</h3>
        <p>Show as many items as you want by duplicating the identified section below</p>

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('
<!-- Row one image left -->
<div class="single-row-two-col-layout">
    <div class="flex-shrink-0">
        <img src="/styleguide/image/350x200" alt="Your image description">
    </div>

    <div>
        <p>'.$faker->paragraph.'</p>
    </div>
</div>

<!-- Row two image right -->
<div class="two-col-layout">
    <div>
        <p>'.$faker->paragraph.'</p>
    </div>

    <div class="flex-shrink-0">
        <img src="/styleguide/image/350x200" alt="Your image description">
    </div>
</div>
<!-- Duplicate as many items as you need -->
') !!}
</pre>
        <h2 class="mt-4 divider-gold text-green font-normal">Grid of two columns layout</h2>

        <div class="grid-two-col-layout">
            <div>
                <img src="/styleguide/image/450x250" alt="">
                <p>{{ $faker->text(50) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/450x250" alt="">
                <p>{{ $faker->text(50) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/450x250" alt="">
                <p>{{ $faker->text(50) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/450x250" alt="">
                <p>{{ $faker->text(50) }}</p>
            </div>
        </div>

        <h3>Copy this into the CMS source editor</h3>
        <p>Show as many items as you want by duplicating the identified section below</p>

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('
<div class="grid-two-col-layout">
    <!-- Item one -->
    <div>
        <img src="/styleguide/image/450x250" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item two -->
    <div>
        <img src="/styleguide/image/450x250" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item three -->
    <div>
        <img src="/styleguide/image/450x250" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item four -->
    <div>
        <img src="/styleguide/image/450x250" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Duplicate as many items as you need -->
</div>
') !!}
</pre>

        <h2 class="mt-8 divider-gold text-green font-normal">Three column layout</h2>

        <div class="grid-three-col-layout">
            <div>
                <img src="/styleguide/image/268x200" alt="">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/268x200" alt="">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/268x200" alt="">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/268x200" alt="">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/268x200" alt="">
                <p>{{ $faker->text(60) }}</p>
            </div>

        </div>

        <h3>Copy this into the CMS</h3>
        <p>Show as many items as you want by duplicating the identified section below</p>

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('
<div class="grid-three-col-layout">
    <!-- Item one -->
    <div>
        <img src="/styleguide/image/268x268" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item two -->
    <div>
        <img src="/styleguide/image/268x268" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item three -->
    <div>
        <img src="/styleguide/image/268x268" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item four -->
    <div>
        <img src="/styleguide/image/268x268" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Duplicate as many items as you need -->
</div>
') !!}
</pre>

    </div>
@endsection
