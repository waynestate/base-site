@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <h2 class="mt-4 divider-gold text-green font-normal">Single row of two columns layout</h2>

        <div class="single-row-two-col-layout">
            <img src="/styleguide/image/300x200" alt="">
            <div>
                <p>{{ $faker->text(250) }}</p>
                <p>{{ $faker->text(250) }}</p>
            </div>
        </div>

        <div class="single-row-two-col-layout">
            <p>{{ $faker->text(450) }}</p>
            <img src="/styleguide/image/150x150" alt="">
        </div>

        <h3>Copy this into the CMS source editor</h3>
        <p>Show as many items as you want by duplicating the identified section below</p>

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('
<!-- Row image left -->
<div class="single-row-two-col-layout">
    <img src="/styleguide/image/300x200" alt="Your image description">
    <div>
        <p>'.$faker->paragraph.'</p>
        <p>'.$faker->paragraph.'</p>
    </div>
</div>

<!-- Row image right -->
<div class="single-row-two-col-layout">
    <div>
        <p>'.$faker->paragraph.'</p>
    </div>
    <img src="/styleguide/image/150x150" alt="Your image description">
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
