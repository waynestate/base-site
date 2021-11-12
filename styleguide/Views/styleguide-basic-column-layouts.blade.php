@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <h2 class="mb-4">Two column layout</h2>

        <div class="row -mx-4 md:flex">
            <div class="md:w-1/2 px-4">
                <img src="/styleguide/image/450x150" alt="" class="mb-2">
                <p>{{ $faker->text(100) }}</p>
            </div>

            <div class="md:w-1/2 px-4">
                <img src="/styleguide/image/450x150" alt="" class="mb-2">
                <p>{{ $faker->text(100) }}</p>
            </div>
        </div>

        <ul class="accordion">
            <li>
                <a href="#code-two-col" id="code-two-col"><span aria-hidden="true"></span>Two column layout code</a>
                <div class="content">
<pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
{!! htmlspecialchars('
<div class="row -mx-4 md:flex">
    <div class="md:w-1/2 px-4">
        <img src="/styleguide/image/450x150" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>
    <div class="md:w-1/2 px-4">
        <img src="/styleguide/image/450x150" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>
</div>') !!}
</pre>
                </div>
            </li>
        </ul>

        <hr>

        <h2 class="mb-4">Three column layout</h2>

        <div class="row -mx-4 lg:flex">
            <div class="lg:w-1/3 px-4">
                <img src="/styleguide/image/268x100" alt="" class="mb-2">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div class="lg:w-1/3 px-4">
                <img src="/styleguide/image/268x100" alt="" class="mb-2">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div class="lg:w-1/3 px-4">
                <img src="/styleguide/image/268x100" alt="">
                <p>{{ $faker->text(60) }}</p>
            </div>
        </div>

        <ul class="accordion">
            <li>
                <a href="#code-three-col" id="code-three-col"><span aria-hidden="true"></span>Three column layout code</a>
                <div class="content">
<pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
{!! htmlspecialchars('
<div class="row -mx-4 lg:flex">
    <div class="lg:w-1/3 px-4">
        <img src="/styleguide/image/268x100" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>
    <div class="lg:w-1/3 px-4">
        <img src="/styleguide/image/268x100" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>
    <div class="lg:w-1/3 px-4">
        <img src="/styleguide/image/268x100" alt="">
        <p>'.$faker->paragraph.'</p>
    </div>
</div>') !!}
</pre>
                </div>
            </li>
        </ul>
    </div>
@endsection
