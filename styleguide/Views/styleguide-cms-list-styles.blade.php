@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <h2>Unordered lists</h2>

        <ul>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
            <ul>
                <li>{{ $faker->sentence() }}</li>
                <li>{{ $faker->sentence() }}</li>
                <ul>
                    <li>{{ $faker->sentence() }}</li>
                    <li>{{ $faker->sentence() }}</li>
                </ul>
            </ul>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
        </ul>

        <h2>Ordered lists</h2>

        <ol>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
            <ol>
                <li>{{ $faker->sentence() }}</li>
                <li>{{ $faker->sentence() }}</li>
                <ol>
                    <li>{{ $faker->sentence() }}</li>
                    <li>{{ $faker->sentence() }}</li>
                </ol>
            </ol>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
        </ol>

        <h2>Policy lists</h2>

        <p>Policy numbering list style is a nested ordered and unordered list style.</br>
        Apply the <code>policy-numbering</code> class to the opening ordered list element.</br>
        Each new nested list should start within the previous list item.</p>

        <code class="w-1/2">
            <ul style="list-style: none">
                <li>&lt;ol class="policy-numbering"&gt;</li>
                <li>&#20;&#20;&#20;&#20;&lt;li&gt;Item 1.0&lt;/li&gt;</li>
                <li>&#20;&#20;&#20;&#20;&lt;li&gt;Item 2.0&lt;/li&gt;</li>
                <li>&#20;&#20;&#20;&#20;&lt;li&gt;Item 3.0</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;ol&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;li&gt;Item 3.1&lt;/li&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;li&gt;Item 3.2</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;ul&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;li&gt;Item a&lt;/li&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;li&gt;Item b</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;li&gt;Item i&lt;/li&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;li&gt;Item ii&lt;/li&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;/li&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;/ul&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;/li&gt;</li>
                <li>&#20;&#20;&#20;&#20;&#20;&#20;&#20;&#20;&lt;/ol&gt;</li>
                <li>&#20;&#20;&#20;&#20;&lt;/li&gt;</li>
                <li>&lt;/ol&gt;</li>
            </ul>
        </code>
        <ol class="policy-numbering">
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}</li>
            <li>{{ $faker->sentence() }}
                <ol>
                    <li>{{ $faker->sentence() }}</li>
                    <li>{{ $faker->sentence() }}
                        <ul>
                            <li>{{ $faker->sentence() }}</li>
                            <li>{{ $faker->sentence() }}
                                <ul>
                                    <li>{{ $faker->sentence() }}</li>
                                    <li>{{ $faker->sentence() }}</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ol>

            </li>
        </ol>
    </div>
@endsection
