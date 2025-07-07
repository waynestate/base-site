@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        {!! $base['page']['content']['main'] !!}
        <p>Be sure to use the table option in the CMS editor, and always use table headers and a caption to describe the data for accessibility.</p>

        <h2>Basic table</h2>
        <ul class="accordion ml-0">
            <li>
                <a href="#table-basic" tabindex="0" role="button" aria-expanded="false"><span aria-hidden="true"></span>Table source code</a>
                <div class="content fold">
                    <pre class="code-block w-full" tabindex="0">
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
                </div>
            </li>
        </ul>

        <table>
            <caption>Example of a basic table.</caption>
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
       
        <h2>Table overflow-x-scroll</h2>
        <p>We use javascript to apply a container div that handles scrolling.</p>
        <ul class="accordion ml-0">
            <li>
                <a href="#table-basic" tabindex="0" role="button" aria-expanded="false"><span aria-hidden="true"></span>Table overflow-x-scroll source code</a>
                <div class="content fold">
                    <pre class="code-block w-full" tabindex="0">
{!! htmlspecialchars('<table class="overflow-x-scroll">
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
            </li>
        </ul>
        <table class="overflow-x-scroll table-fixed">
            <thead>
                <tr>
                    <th scope="col" class="w-[100px]">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Description</th>
                    <th scope="col">{{ ucfirst(implode(' ',$faker->words(1))) }}</th>
                    <th scope="col">{{ ucfirst(implode(' ',$faker->words(2))) }}</th>
                    <th scope="col">{{ ucfirst(implode(' ',$faker->words(2))) }}</th>
                    <th scope="col">{{ ucfirst(implode(' ',$faker->words(2))) }}</th>
                    <th scope="col">{{ ucfirst(implode(' ',$faker->words(2))) }}</th>
                    <th scope="col">{{ ucfirst(implode(' ',$faker->words(2))) }}</th>
                    <th scope="col">{{ ucfirst(implode(' ',$faker->words(3))) }}</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $faker->firstName() }} {{ $faker->lastName() }}</td>
                        <td><a href="//wayne.edu">{{ $faker->email() }}</a></td>
                        <td>{{ ucfirst(implode(' ',$faker->words(3))) }}</td>
                        <td>{{ $faker->text(10) }}</td>
                        <td>{{ $faker->text(10) }}</td>
                        <td>{{ $faker->text(10) }}</td>
                        <td>{{ ucfirst(implode(' ',$faker->words(5))) }}</td>
                        <td>{{ $faker->text(10) }}</td>
                        <td>{{ $faker->text(10) }}</td>
                        <td>{{ $faker->text(10) }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>


        <h2>Table sort</h2>
        <p>Use <code>&lt;table class="table-sort"&gt;</code> for this option. Click on each table heading to sort by column. Status: </p>

        <ul class="accordion ml-0">
            <li>
                <a href="#table-basic" tabindex="0" role="button" aria-expanded="false"><span aria-hidden="true"></span>Table sort source code</a>
                <div class="content fold">
                    <pre class="code-block w-full" tabindex="0">
{!! htmlspecialchars('<table class="table-sort">
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
            </li>
        </ul>
        <table class="table-sort overflow-x-scroll">
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
                    <tr>
                        <td>{{ $faker->firstName() }}</td>
                        <td>{{ $faker->lastName() }}</td>
                        <td>{{ $faker->email() }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <h2>Table stack</h2>
        <ul class="accordion ml-0">
            <li>
                <a href="#table-basic" tabindex="0" role="button" aria-expanded="false"><span aria-hidden="true"></span>Table sort source code</a>
                <div class="content fold">
                    <pre class="code-block w-full" tabindex="0">
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
            </li>
        </ul>

        <table class="table-stack">
            <caption>Use <code>&lt;table class="table-stack"&gt;</code> for this option. This table turns data into self-contained cards on mobile for easy reading.</caption>
            <thead>
                <tr>
                    <th scope="col" class="w-1/5">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">{{ ucfirst(implode(' ',$faker->words(3))) }}</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $faker->firstName() }} {{ $faker->lastName() }}</td>
                        <td><a href="//wayne.edu">{{ $faker->email() }}</a></td>
                        <td>{{ $faker->text(200) }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <h2>Source code</h2>
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
    </div>
@endsection
