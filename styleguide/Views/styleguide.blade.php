@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Welcome to your Styleguide! The styles listed on this page are available to you in the CMS.</p>

        <h2>&lt;h2&gt; Heading level 2</h2>
        <p>{{ $faker->text(40) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a> {{ $faker->text(300) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a></p>

        <h3>&lt;h3&gt; Heading level 3</h3>
        <p>{{ $faker->text(40) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a> {{ $faker->text(300) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a></p>

        <h4>&lt;h4&gt; Heading level 4</h4>
        <p>{{ $faker->text(40) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a> {{ $faker->text(300) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a></p>

        <h5>&lt;h5&gt; Heading level 5</h5>
        <p>{{ $faker->text(40) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a> {{ $faker->text(300) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a></p>

        <h6>&lt;h6&gt; Heading level 6</h6>
        <p>{{ $faker->text(40) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a> {{ $faker->text(300) }} <a href="https://base.wayne.edu">{{ $faker->text(40) }}</a></p>

        <hr />

        <h2>Additional heading styles</h2>
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

        <hr />

        <h2>General code formatting</h2>
        <p class="mb-1">These HTML classes are available for text formatting. Add <code>class="text-lg"</code> to a paragraph or span tag.</p>
        <ul>
            <li>font-normal</li>
            <li><span class="font-bold">font-bold</span></li>
            <li><span class="font-light">font-light</span></li>
            <li><span class="italic">italic</span></li>
            <li><span class="text-sm">text-sm</span></li>
            <li><span class="text-base">text-base</span></li>
            <li><span class="text-lg">text-lg</span></li>
            <li><span class="text-xl">text-xl</span></li>
        </ul>

        <hr />
        
        <div class="-mx-4 md:flex">
            <div class="w-full md:w-1/3 px-4">
                <h2>Unordered lists</h2>

                <ul>
                    <li>First</li>
                    <li>Second</li>
                    <li>Third</li>
                </ul>
            </div>

            <div class="w-full md:w-1/3 px-4">
                <h2>Ordered lists</h2>

                <ol>
                    <li>First</li>
                    <li>Second</li>
                    <li>Third</li>
                </ol>
            </div>

            <div class="w-full md:w-1/3 px-4">
                <h2>Data lists</h2>

                <dl>
                    <dt>First</dt>
                    <dd>Description of first.</dd>
                    <dt>Second</dt>
                    <dd>Description of second.</dd>
                    <dt>Third</dt>
                    <dd>Description of third.</dd>
                </dl>
            </div>
        </div>

        <hr />

        <h2>Blockquote</h2>

        <blockquote>
            <p>&ldquo;{{ $faker->paragraph(10) }}&rdquo;</p>
            <p>&ldquo;{{ $faker->paragraph(4) }}&rdquo;</p>
            <cite>&mdash; {{ $faker->Name }}</cite>
        </blockquote>

<pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
{!! htmlspecialchars('<blockquote>
    <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."</p>
    <cite>Name or citation</cite>
</blockquote>') !!}
</pre>

        <hr />

        <h2>PDF links</h2>

        <p>Links to PDFs will automatically append the file type to the end of the link. Example: <a href="example.pdf">download brochure</a>.</p>

        <h2>Abbreviations</h2>

        <p><abbr title="Wayne State University">WSU</abbr></p>

        <hr />

    </div>
@endsection
