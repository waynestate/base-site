@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
        <p>Be sure to use the table option in the CMS editor, and always use table headers and a caption to describe the data for accessibility. These are what tables look like and the different formats that are available.</p>

        <h2>Basic table</h2>
        <table>
            <caption>Previewing an example table.</caption>
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
{!! htmlspecialchars('<table>
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

        <hr />

        <h2>Sortable table</h2>

        <table class="table-sort">
            <caption>Use class="table-sort" for this option. Click on each table heading to sort by column. Status: </caption>
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

        <hr />

        <h2>Responsive table</h2>

        <table class="table-stack">
            <caption>Use class="table-stack" for this option. This table turns data into self-contained cards for mobile users for easy reading.</caption>
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
    </div>
@endsection
