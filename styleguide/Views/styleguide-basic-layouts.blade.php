@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Use these examples to style your content in the CMS editor</p>
    </div>

    <div class="content">
        <h2 id="two-equal-columns" class="my-4">Two equal columns</h2>
        <h3 class="mb-0">Example columns with text</h3>

        <div class="grid-two-col-layout">
            <div>
                <p>{{ $faker->text(400) }}</p>
            </div>

            <div>
                <p>{{ $faker->text(400) }}</p>
            </div>
        </div>

        <h3 class="mt-0">Example grid</h3>

        <div class="grid-two-col-layout mt-4">
            <div>
                <img src="/styleguide/image/425x240" alt="Two column placeholder image 1">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/425x240" alt="Two column placeholder image 2">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/425x240" alt="Two column placeholder image 3">
                <p>{{ $faker->text(60) }}</p>
            </div>

            <div>
                <img src="/styleguide/image/425x240" alt="Two column placeholder image 4">
                <p>{{ $faker->text(60) }}</p>
            </div>
        </div>

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<div class="grid-two-col-layout">
    <!-- Item one -->
    <div>
        <img src="https://base.wayne.edu/styleguide/image/425x240" alt="Placeholder image">
        <p>'.$faker->text(30).'</p>
    </div>

    <!-- Item two -->
    <div>
        <img src="https://base.wayne.edu/styleguide/image/425x240" alt="Placeholder image">
        <p>'.$faker->text(30).'</p>
    </div>

    <!-- Add more items to make a grid -->
</div>') !!}
</pre>
        <h2 id="two-columns-image-left" class="mt-10 my-4">Two columns image left</h2>

        <div class="two-col-layout">
            <div class="md:w-1/3 flex-shrink-0">
                <img src="/styleguide/image/600x400" alt="Left placeholder image">
            </div>
            <div class="w-full">
                <p>{{ $faker->text(250) }}</p>
                <p>{{ $faker->text(250) }}</p>
            </div>
        </div>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<div class="two-col-layout">
    <div class="md:w-1/3 flex-shrink-0">
        <img src="https://via.placeholder.com/600x400" alt="Your image description">
    </div>
    <div>
        <p>'.$faker->text(60).'</p>
        <p>'.$faker->text(60).'</p>
    </div>
</div>')!!}
</pre>
        <h2 id="two-columns-image-right" class="mt-10 mb-4">Two columns image right</h2>

        <div class="two-col-layout">
            <div class="w-full">
                <p>{{ $faker->text(250) }}</p>
                <p>{{ $faker->text(250) }}</p>
            </div>
            <div class="md:w-1/3 flex-shrink-0">
                <img src="/styleguide/image/600x400" alt="Right placeholder image">
            </div>
        </div>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<div class="two-col-layout">
    <div class="w-full">
        <p>'.$faker->text(60).'</p>
        <p>'.$faker->text(60).'</p>
    </div>
    <div class="md:w-1/3 flex-shrink-0">
        <img src="https://via.placeholder.com/600x400" alt="Your image description">
    </div>
</div>')!!}
</pre>

        <h2 id="two-columns-with-a-list" class="mt-10 mb-4">Two columns with a list</h2>
        <div class="two-col-layout">
            <div class="w-full">
                <p>{{ $faker->text(400) }}</p>
                <p><a href="#" class="button">{{ ucfirst(implode(' ',$faker->words(2))) }}</a></p>
            </div>
            <div class="md:w-1/3 flex-shrink-0">
                <ul>
                    <li><a href="/">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="/">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="/">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                </ul>
            </div>
        </div>

<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<div class="two-col-layout">
    <div class="w-full">
        <p>'.$faker->text(60).'</p>
        <p><a href="#" class="button">'.ucfirst(implode(' ',$faker->words(2))).'</a></p>
    </div>
    <div class="md:w-1/3 flex-shrink-0">
        <ul>
            <li><a href="#">'.ucfirst(implode(' ',$faker->words(4))).'</a></li>
            <li><a href="#">'.ucfirst(implode(' ',$faker->words(4))).'</a></li>
        </ul>
    </div>
</div>') !!}
</pre>
        <h2 id="three-equal-columns" class="mt-10">Three equal columns</h2>

        <div class="grid-three-col-layout mt-4">
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
{!! htmlspecialchars('<div class="grid-three-col-layout">
    <!-- Item one -->
    <div>
        <img src="/styleguide/image/268x268" alt="">
        <p>'.$faker->text(60).'</p>
    </div>

    <!-- Item two -->
    <div>
        <img src="/styleguide/image/268x268" alt="">
        <p>'.$faker->text(60).'</p>
    </div>

    <!-- Item three -->
    <div>
        <img src="/styleguide/image/268x268" alt="">
        <p>'.$faker->text(60).'</p>
    </div>

    <!-- Add more items to make a grid -->
</div>') !!}
</pre>
    </div>
@endsection
