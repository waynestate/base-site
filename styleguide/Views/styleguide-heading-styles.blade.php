@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Heading variants available by adding classes.</p>

        <h3 class="divider-gold">Your heading with a gold divider</h3>
        <p><code>&lt;h2 class="divider-gold"&gt;</code></p>

        <h3 class="divider-green">Your heading with a green divider</h3>
        <p><code>&lt;h2 class="divider-green"&gt;</code></p>

        <h3 class="bar-gold">Your heading with a gold bar</h3>
        <p><code>&lt;h2 class="bar-gold"&gt;</code></p>

        <h3 class="text-green font-normal mb-2">Your heading with green text and normal weight</h3>
        <p><code>&lt;h2 class="text-green font-normal"&gt;</code></p>

        <p><strong>Notice: Your heading text and body text cannot be gold.</strong></p>
    </div>
@endsection
