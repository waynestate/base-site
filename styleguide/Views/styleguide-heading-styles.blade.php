@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Heading variants available by adding classes. Your heading and body text cannot be gold.</p>

        <h2 class="divider-gold">Your heading with a gold divider</h2>
        <p><code>&lt;h2 class="divider-gold"&gt;</code></p>

        <h2 class="divider-green">Your heading with a green divider</h2>
        <p><code>&lt;h2 class="divider-green"&gt;</code></p>

        <h2 class="bar-gold">Your heading with a gold bar</h2>
        <p><code>&lt;h2 class="bar-gold"&gt;</code></p>

        <h2 class="text-green font-normal mb-2">Your heading with green text and normal weight</h2>
        <p><code>&lt;h2 class="text-green font-normal"&gt;</code></p>

        <h2 class="divider-gold text-green font-normal mb-2">Combine multiple styles</h2>
        <p><code>&lt;h2 class="divider-gold text-green font-normal"&gt;</code></p>
    </div>
@endsection
