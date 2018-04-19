@extends('partials.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        {!! $page['content']['main'] !!}
   

        <table class="table-stack">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr valign="top">
                        <td>{{ $faker->firstName }}</td>
                        <td>{{ $faker->lastName }}</td>
                        <td>{{ $faker->email }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>


        <a class="button" onclick="$('pre.table-stack').toggleClass('hide');">See Table Code</a>

        <pre class="table-stack hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {{ htmlspecialchars('
<table class="table-stack">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
        ') }}
        </pre>
    </div>
@endsection
