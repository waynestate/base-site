@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <a href="#button-examples" class="button">Standard button</a>
        <br />
        <a href="#button-examples" class="green-button">Green button</a>
        <br />
        <a href="#button-examples" class="green-gradient-button">Green gradient button</a>
        <br />
        <a href="#button-examples" class="gold-button">Gold button</a>
        <br />
        <a href="#button-examples" class="gold-gradient-button">Gold gradient button</a>

        <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
        {!! htmlspecialchars('
<a href="#" class="button">Standard button</a>
<a href="#" class="button bg-gradient-green text-white">Dark button</a>
<a href="#" class="button expanded">Expanded button</a>') !!}
        </pre>
    </div>
@endsection
