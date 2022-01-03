@extends('components.content-area')

@section('content')
    <img class="w-full block" src="/styleguide/image/1600x580?text=Full%20width%20image" alt="">

    <div class="bg-gray-100 mb-4">
        <div class="row py-4">
            <p class="mx-4 py-2 text-4xl text-gray-600 font-serif text-center">"{{ $faker->paragraph(3) }}"</p>
        </div>
    </div>

    <div class="row content mx-4">
        <h2>{{ ucfirst($faker->words(2, true)) }}</h2>

        <p>{{ $faker->paragraph(10) }}</p>
        <p>{{ $faker->paragraph(10) }}</p>
        <p>{{ $faker->paragraph(10) }}</p>
    </div>
@endsection
