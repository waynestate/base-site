@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <h2 class="divider-gold text-green font-normal my-4">Two columns image left</h2>

        <div class="two-col-layout">
            <div class="flex-shrink-0">
                <img src="/styleguide/image/300x200" alt="">
            </div>
            <div>
                <p>{{ $faker->text(250) }}</p>
                <p>{{ $faker->text(250) }}</p>
            </div>
        </div>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<h2 class="divider-gold text-green font-normal my-4">Two columns image left</h2>
<div class="two-col-layout">
    <div class="flex-shrink-0">
        <img src="/styleguide/image/300x200" alt="Your image description">
    </div>
    <div>
        <p>'.$faker->paragraph.'</p>
        <p>'.$faker->paragraph.'</p>
    </div>
</div>')!!}
</pre>
        <h2 class="divider-gold text-green font-normal mt-8 mb-4">Two columns image right</h2>

        <div class="two-col-layout">
            <div>
                <p>{{ $faker->text(250) }}</p>
                <p>{{ $faker->text(250) }}</p>
            </div>
            <div class="flex-shrink-0">
                <img src="/styleguide/image/300x200" alt="">
            </div>
        </div>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<h2 class="divider-gold text-green font-normal my-4">Two columns image right</h2>
<div class="two-col-layout">
    <div>
        <p>'.$faker->paragraph.'</p>
        <p>'.$faker->paragraph.'</p>
    </div>
    <div>
        <img src="/styleguide/image/300x200" alt="Your image description">
    </div>
</div>')!!}
</pre>

        <h2 class="divider-gold font-normal text-green mt-8 mb-4">Two columns with a list</h2>
        <div class="two-col-layout">
            <div class="md:w-2/3">
                <p>{{ $faker->text(400) }}</p>
                <p><a href="#" class="button">{{ ucfirst(implode(' ',$faker->words(2))) }}</a></p>
            </div>
            <div class="md:w-1/3">
                <ul>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                </ul>
            </div>
        </div>

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<h2 class="divider-gold font-normal text-green my-4">Two columns with list</h2>
<div class="two-col-layout">
    <!-- Item one -->
    <div class="md:w-2/3">
        <p>'.$faker->text(400).'</p>
        <p><a href="#" class="button">'.ucfirst(implode(' ',$faker->words(2))).'</a></p>
    </div>
    <div class="md:w-1/3">
        <ul>
            <li><a href="#">'.ucfirst(implode(' ',$faker->words(4))).'</a></li>
            <li><a href="#">'.ucfirst(implode(' ',$faker->words(4))).'</a></li>
        </ul>
    </div>

    <!-- Duplicate this item as many times as necessary -->
</div>') !!}
</pre>
        <h2 class="divider-gold text-green font-normal mt-8 mb-4">Two column grid</h2>

        <div class="grid-two-col-layout">
            <div>
                <img src="/styleguide/image/450x250?text=450x250" alt="">
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

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<h2 class="divider-gold font-normal text-green my-4">Two column grid</h2>
<div class="grid-two-col-layout">
    <!-- Item one -->
    <div>
        <img src="/styleguide/image/450x250" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Duplicate this item as many times as necessary -->
</div>') !!}
</pre>

        <h2 class="divider-gold text-green font-normal mt-8 mb-4">Three column grid</h2>

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

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<h2 class="divider-gold font-normal text-green my-4">Three column grid</h2>
<div class="grid-three-col-layout">
    <!-- Item one -->
    <div>
        <img src="/styleguide/image/268x268" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Duplicate this item as many times as necessary -->
</div>') !!}
</pre>
    </div>
@endsection
