@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <h2 class="mt-4 divider-gold text-green font-normal">Two column layout</h2>

        <div class="-mx-4 md:flex flex-wrap">
            <div class="md:w-1/2 px-4 my-4">
                <img src="/styleguide/image/450x250" alt="" class="mb-2">
                <p>{{ $faker->text(50) }}</p>
            </div>

            <div class="md:w-1/2 px-4 my-4">
                <img src="/styleguide/image/450x250" alt="" class="mb-2">
                <p>{{ $faker->text(50) }}</p>
            </div>

            <div class="md:w-1/2 px-4 my-4">
                <img src="/styleguide/image/450x250" alt="" class="mb-2">
                <p>{{ $faker->text(50) }}</p>
            </div>

            <div class="md:w-1/2 px-4 my-4">
                <img src="/styleguide/image/450x250" alt="" class="mb-2">
                <p>{{ $faker->text(50) }}</p>
            </div>
        </div>

        <h3>Copy this into the CMS source editor</h3>
        <p>Show as many items as you want by duplicating the identified section below</p>

<pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
{!! htmlspecialchars('
<div class="row -mx-4 md:flex flex-wrap">
    <!-- Item one -->
    <div class="md:w-1/2 px-4 my-4">
        <img src="/styleguide/image/450x250" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item two -->
    <div class="md:w-1/2 px-4 my-4">
        <img src="/styleguide/image/450x250" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item three -->
    <div class="md:w-1/2 px-4 my-4">
        <img src="/styleguide/image/450x250" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item four -->
    <div class="md:w-1/2 px-4 my-4">
        <img src="/styleguide/image/450x250" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Duplicate as many items as you need -->
</div>
') !!}
</pre>

        <h2 class="mt-8 divider-gold text-green font-normal">Three column layout</h2>

        <div class="-mx-4 lg:flex flex-wrap">
            <div class="lg:w-1/3 px-4 my-4">
                <img src="/styleguide/image/268x200" alt="" class="mb-2">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div class="lg:w-1/3 px-4 my-4">
                <img src="/styleguide/image/268x200" alt="" class="mb-2">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div class="lg:w-1/3 px-4 my-4">
                <img src="/styleguide/image/268x200" alt="" class="mb-2">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div class="lg:w-1/3 px-4 my-4">
                <img src="/styleguide/image/268x200" alt="" class="mb-2">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div class="lg:w-1/3 px-4 my-4">
                <img src="/styleguide/image/268x200" alt="" class="mb-2">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div class="lg:w-1/3 px-4 my-4">
                <img src="/styleguide/image/268x200" alt="" class="mb-2">
                <p>{{ $faker->text(60) }}</p>
            </div>
        </div>

        <h3>Copy this into the CMS</h3>
        <p>Show as many items as you want by duplicating the identified section below</p>

<pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
{!! htmlspecialchars('
<div class="-mx-4 md:flex flex-wrap">
    <!-- Item one -->
    <div class="lg:w-1/3 px-4 my-4">
        <img src="/styleguide/image/268x268" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item two -->
    <div class="lg:w-1/3 px-4 my-4">
        <img src="/styleguide/image/268x268" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item three -->
    <div class="lg:w-1/3 px-4 my-4">
        <img src="/styleguide/image/268x268" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Item four -->
    <div class="lg:w-1/3 px-4 my-4">
        <img src="/styleguide/image/268x268" alt="" class="mb-2">
        <p>'.$faker->paragraph.'</p>
    </div>

    <!-- Duplicate as many items as you need -->
</div>
') !!}
</pre>

    </div>
@endsection
