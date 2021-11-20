@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}

        <h2>Basic table</h2>
        <table>
            <caption>Describe your table for screen readers in the caption. Use <code>class="visually-hidden"</code> to hide it from sighted users.</caption>
            <thead>
                <tr>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $faker->firstName }}</td>
                        <td>{{ $faker->lastName }}</td>
                        <td>{{ $faker->email }}</td>
                        <td>{{ $faker->text(50) }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <pre class="code-block" tabindex="0">
        {!! htmlspecialchars('
<table>
    <caption>Describe your table for screen readers in the caption. Use class="visually-hidden" to hide from sighted users.</caption>
    <thead>
        <tr>
            <th scope="col">Column 1</th>
            <th scope="col">Column 2</th>
            <th scope="col">Column 3</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Data for col 1</td>
            <td>Data for col 2</td>
            <td>Data for col 3</td>
        </tr>
        <tr>
            <td>Data for col 1</td>
            <td>Data for col 2</td>
            <td>Data for col 3</td>
        </tr>
    </tbody>
</table>') !!}
        </pre>

        <hr />
        <h2>Sortable table</h2>

        <table class="table-sort">
            <caption>Describe your table for screen readers in the caption. Use <code>class="visually-hidden"</code> to hide it from sighted users.</caption>
            <thead>
                <tr>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $faker->firstName }}</td>
                        <td>{{ $faker->lastName }}</td>
                        <td>{{ $faker->email }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <pre class="code-block" tabindex="0">
        {!! htmlspecialchars('
<table class="table-sort">
    <caption>Describe your table for screen readers in the caption. Use class="visually-hidden" to hide from sighted users.</caption>
    <thead>
        <tr>
            <th scope="col">Column 1</th>
            <th scope="col">Column 2</th>
            <th scope="col">Column 3</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Data for col 1</td>
            <td>Data for col 2</td>
            <td>Data for col 3</td>
        </tr>
        <tr>
            <td>Data for col 1</td>
            <td>Data for col 2</td>
            <td>Data for col 3</td>
        </tr>
    </tbody>
</table>') !!}
        </pre>

        <hr />

        <h2>Responsive table</h2>

        <table class="table-stack">
            <caption>Describe your table for screen readers in the caption. Use <code>class="visually-hidden"</code> to hide it from sighted users.</caption>
            <thead>
                <tr>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $faker->firstName }}</td>
                        <td>{{ $faker->lastName }}</td>
                        <td>{{ $faker->email }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <pre class="code-block" tabindex="0">
        {!! htmlspecialchars('
<table class="table-stack">
    <caption>Describe your table for screen readers in the caption. Use class="visually-hidden" to hide from sighted users.</caption>
    <thead>
        <tr>
            <th scope="col">Column 1</th>
            <th scope="col">Column 2</th>
            <th scope="col">Column 3</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Data for col 1</td>
            <td>Data for col 2</td>
            <td>Data for col 3</td>
        </tr>
    </tbody>
</table>') !!}
        </pre>
    </div>
@endsection
