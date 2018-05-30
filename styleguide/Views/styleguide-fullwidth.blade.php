@extends('components.content-area')

@section('content')
    <img class="w-full block" src="/styleguide/image/1600x580?text=Full%20Width%20Image" />

    <div class="bg-grey-lightest mb-4">
        <div class="row py-4">
            <p class="py-2 text-4xl text-grey-darkest font-serif text-center">"{{ $faker->paragraph(3) }}"</p>
        </div>
    </div>

    <div class="row content">
        <h2>{{ $faker->words(2, true) }}</h2>

        <p>{{ $faker->paragraph(10) }}</p>
        <p>{{ $faker->paragraph(10) }}</p>
        <p>{{ $faker->paragraph(10) }}</p>
    </div>
@endsection
