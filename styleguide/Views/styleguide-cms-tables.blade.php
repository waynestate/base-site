@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('partials.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
        <p>Be sure to use the table option in the CMS editor, and always use table headers and a caption to describe the data for accessibility.</p>

        <h2>Basic table</h2>
        <table>
            <caption>Example of a basic table.</caption>
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
                        <td>{{ $faker->firstName() }}</td>
                        <td>{{ $faker->lastName() }}</td>
                        <td><a href="//wayne.edu">{{ $faker->email() }}</a></td>
                        <td>{{ $faker->text(50) }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <h2>Sortable table</h2>

        <table class="table-sort">
            <thead>
                <tr>
                    <th scope="col">
                        First name
                    </th>
                    <th scope="col">
                        Last name
                    </th>
                    <th scope="col">
                        Email
                    </th>
                    <th class="no-sort" scope="col">Address (no sort)</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td>{{ $faker->firstName() }}</td>
                        <td>{{ $faker->lastName() }}</td>
                        <td><a href="//wayne.edu">{{ $faker->email() }}</a></td>
                        <td>{{ $faker->streetAddress() }}</td>
                    </tr>
                    <tr>
                        <td>{{ $faker->firstName() }}</td>
                        <td>{{ $faker->lastName() }}</td>
                        <td>{{ $faker->email() }}</td>
                        <td>{{ $faker->streetAddress() }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <h2>Source code</h2>
        <pre class="code-block" tabindex="0">
{!! htmlspecialchars('<table class="table-sort">
    <caption>Describe your table for screen readers in the caption.</caption>
    <thead>
        <tr>
            <th scope="col">
                First name
            </th>
            <th scope="col">
                Last name
            </th>
            <th scope="col" aria-sort="ascending">
                Email
            </th>
            <th scope="col" class="no-sort">Address (no sort)</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Data for col 1</td>
            <td>Data for col 2</td>
            <td>Data for col 3</td>
            <td>Data for col 4</td>
        </tr>
        <tr>
            <td>Data for col 1</td>
            <td>Data for col 2</td>
            <td>Data for col 3</td>
            <td>Data for col 4</td>
        </tr>
    </tbody>
</table>') !!}
</pre>

        <h2>Responsive table</h2>

        <table class="table-stack">
            <caption>Use <code>&lt;table class="table-stack"&gt;</code> for this option. This table turns data into self-contained cards on mobile for easy reading.</caption>
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
                        <td>{{ $faker->firstName() }}</td>
                        <td>{{ $faker->lastName() }}</td>
                        <td><a href="//wayne.edu">{{ $faker->email() }}</a></td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <h2>Source code</h2>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<table class="table-stack">
    <caption>Describe your table for screen readers in the caption.</caption>
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
    </div>
@endsection
