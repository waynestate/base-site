@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>{{ $faker->text(300) }}</p>

        <h2 class="divider-gold font-normal text-green mb-4">{{ ucfirst(implode(' ',$faker->words(4))) }}</h2>
        <div class="-mx-4 md:flex">
            <div class="md:w-2/3 px-4">
                <p>{{ $faker->text(400) }}</p>
                <p><a href="#" class="button">{{ ucfirst(implode(' ',$faker->words(2))) }}</a></p>
            </div>
            <div class="md:w-1/3 px-4">
                <ul>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                </ul>
            </div>
        </div>

        <h2 class="divider-gold font-normal text-green mb-4">{{ ucfirst(implode(' ',$faker->words(4))) }}</h2>
        <div class="-mx-4 md:flex">
            <div class="md:w-2/3 px-4">
                <p>{{ $faker->text(400) }}</p>
                <p><a href="#" class="button">{{ ucfirst(implode(' ',$faker->words(2))) }}</a></p>
            </div>
            <div class="md:w-1/3 px-4">
                <ul>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                </ul>
            </div>
        </div>

        <h2 class="divider-gold font-normal text-green mb-4">{{ ucfirst(implode(' ',$faker->words(4))) }}</h2>
        <div class="-mx-4 md:flex">
            <div class="md:w-2/3 px-4">
                <p>{{ $faker->text(400) }}</p>
                <p><a href="#" class="button">{{ ucfirst(implode(' ',$faker->words(2))) }}</a></p>
            </div>
            <div class="md:w-1/3 px-4">
                <ul>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                </ul>
            </div>
        </div>

        <h2 class="divider-gold font-normal text-green mb-4">{{ ucfirst(implode(' ',$faker->words(4))) }}</h2>
        <div class="-mx-4 md:flex">
            <div class="md:w-2/3 px-4">
                <p>{{ $faker->text(400) }}</p>
                <p><a href="#" class="button">{{ ucfirst(implode(' ',$faker->words(2))) }}</a></p>
            </div>
            <div class="md:w-1/3 px-4">
                <ul>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                    <li><a href="#">{{ ucfirst(implode(' ',$faker->words(4))) }}</a></li>
                </ul>
            </div>
        </div>

        <hr>
        
        <h3 class="mb-4">Copy this into the CMS source editor</h3>

<pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
{!! htmlspecialchars('
<h2 class="divider-gold font-normal text-green mb-4">Temporibus error mollitia quia</h2>
<div class="-mx-4 md:flex">
    <div class="md:w-2/3 px-4">
        <p>Aliquam nobis corrupti suscipit laboriosam. Aliquam fugit ipsum quod nostrum sunt. Dolor et qui praesentium et numquam adipisci. Deserunt corporis rerum amet pariatur itaque facere id. Voluptate numquam ut quisquam excepturi possimus. Et et ad est necessitatibus ad provident accusantium. Et rem cum molestias minima ipsam tempore.</p>
        <p><a href="#" class="button">Facere sint</a></p>
    </div>
    <div class="md:w-1/3 px-4">
        <ul>
            <li><a href="#">Est eum labore reprehenderit</a></li>
            <li><a href="#">Earum voluptatem excepturi ut</a></li>
            <li><a href="#">Maiores odit ut voluptatem</a></li>
            <li><a href="#">Placeat quidem sint eligendi</a></li>
            <li><a href="#">Temporibus at dolor quia</a></li>
            <li><a href="#">Eligendi eveniet perferendis temporibus</a></li>
        </ul>
    </div>
</div>
') !!}
</pre>

    </div>
@endsection
