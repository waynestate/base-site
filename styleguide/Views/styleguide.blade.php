@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <hr>

        <h2>Two column layout</h2>

        <div class="row -mx-4 md:flex">
            <div class="md:w-1/2 px-4">
                <p>{{ $faker->paragraph }}</p>
            </div>

            <div class="md:w-1/2 px-4">
                <p>{{ $faker->paragraph }}</p>
            </div>
        </div>

        <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
            {!! htmlspecialchars('
<div class="row -mx-4 md:flex">
    <div class="md:w-1/2 px-4">
        <p>'.$faker->paragraph.'</p>
    </div>
    <div class="md:w-1/2 px-4">
        <p>'.$faker->paragraph.'</p>
    </div>
</div>') !!}
        </pre>

        <hr>

        <h2>Three column layout</h2>

        <div class="row -mx-4 lg:flex">
            <div class="lg:w-1/3 px-4">
                <p>{{ $faker->paragraph }}</p>
            </div>

            <div class="lg:w-1/3 px-4">
                <p>{{ $faker->paragraph }}</p>
            </div>

            <div class="lg:w-1/3 px-4">
                <p>{{ $faker->paragraph }}</p>
            </div>
        </div>

        <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
            {!! htmlspecialchars('
<div class="row -mx-4 lg:flex">
    <div class="lg:w-1/3 px-4">
        <p>'.$faker->paragraph.'</p>
    </div>
    <div class="lg:w-1/3 px-4">
        <p>'.$faker->paragraph.'</p>
    </div>
    <div class="lg:w-1/3 px-4">
        <p>'.$faker->paragraph.'</p>
    </div>
</div>') !!}
        </pre>

        <hr>

        <h2>Table</h2>

        <table class="table-stack">
                <caption>Example table with fake contact information</caption>
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 4; $i++)
                <tr>
                    <td>@image('/styleguide/image/150x50?text=150x50', 'Example table image showing the image size of 150x50', 'p-2')
                    <td>{{ $faker->firstName }}</td>
                    <td>{{ $faker->lastName }}</td>
                    <td><a href="mailto:{{ $faker->email }}">{{ $faker->email }}</a></td>
                </tr>
                @endfor
            </tbody>
        </table>

        <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
        {!! htmlspecialchars('
<table class="table-stack">
        <caption>Example table with caption</caption>
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>') !!}
        </pre>

        <hr>

        <h2>Abbreviations</h2>

        <p><abbr title="Wayne State University">WSU</abbr></p>

        <hr>

        <div class="row -mx-4 md:flex">
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

        <hr>

        <h2>Blockquote</h2>

        <blockquote>
            <p>&ldquo;{{ $faker->paragraph(10) }}&rdquo;</p>
            <p>&ldquo;{{ $faker->paragraph(4) }}&rdquo;</p>
            <cite>&mdash; {{ $faker->Name }}</cite>
        </blockquote>

        <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
        {!! htmlspecialchars('
<blockquote>
    <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."</p>
    <cite>Name or citation</cite>
</blockquote>') !!}
        </pre>

        <hr>

        <h2>PDF links</h2>

        Links to PDFs will automatically append the file type to the end of the link. Example: <a href="example.pdf">download brochure</a>.

        <hr>

        <h2>Buttons</h2>

        <a href="#button-examples" class="button">Standard button</a>
        <br />
        <a href="#button-examples" class="button bg-gradient-green text-white">Dark button</a>
        <a href="#button-examples" class="button expanded">Expanded button</a>
        <br />

        <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
        {!! htmlspecialchars('
<a href="#" class="button">Standard button</a>
<a href="#" class="button bg-gradient-green text-white">Dark button</a>
<a href="#" class="button expanded">Expanded button</a>') !!}
        </pre>

        <hr>

        <h2>Headers</h2>

        <h1>H1: {{ $faker->sentence }}</h1>
        <h2>H2: {{ $faker->sentence }}</h2>
        <h3>H3: {{ $faker->sentence }}</h3>
        <h4>H4: {{ $faker->sentence }}</h4>
        <h5>H5: {{ $faker->sentence }}</h5>
        <h6>H6: {{ $faker->sentence }}</h6>

        <hr>

        <h2>Media</h2>
        <p>Any valid YouTube URL starting with <code class="bg-gray-100 py-px pb-1 px-1 text-sm">youtu.be</code> or <code class="bg-gray-100 py-px pb-1 px-1 text-sm">youtube.com/watch</code> will open a lightbox with the video.</p>
        <p><a href="//www.youtube.com/watch?v=guRgefesPXE"><img src="//i.wayne.edu/youtube/guRgefesPXE" alt="School of Medicine Commencement YouTube video"></a></p>

        <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
        {!! htmlspecialchars('
<p>
    <a href="//www.youtube.com/watch?v=guRgefesPXE">
        <img src="//i.wayne.edu/youtube/guRgefesPXE" alt="Description of YouTube video">
    </a>
</p>') !!}
        </pre>

        <hr>

        <h2>Responsive Embed</h2>

        <p>To make sure embedded content maintains its aspect ratio as the width of the screen changes, wrap the <code class="bg-gray-100 py-px pb-1 px-1 text-sm">iframe</code>, <code class="bg-gray-100 py-px pb-1 px-1 text-sm">object</code>, <code class="bg-gray-100 py-px pb-1 px-1 text-sm">embed</code>, or <code class="bg-gray-100 py-px pb-1 px-1 text-sm">video</code> in a container with the <code class="bg-gray-100 py-px pb-1 px-1 text-sm">.responsive-embed</code> class.</p>
        <div class="responsive-embed">
            <iframe width="420" height="315" src="//www.youtube.com/embed/guRgefesPXE" title="Responsive embed example" allowfullscreen></iframe>
        </div>

        <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
        {!! htmlspecialchars('
<div class="responsive-embed">
    <iframe width="420" height="315" src="//www.youtube.com/embed/guRgefesPXE" title="Responsive embed example" allowfullscreen></iframe>
</div>') !!}
        </pre>

        <hr>

        <div class="row flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <h2>Figure</h2>

                <div class="table">
                    <figure>
                        @image('/styleguide/image/400x300', 'Example figure image showing the image size of 400x300', 'p-2')
                        <figcaption>{{ $faker->sentence }}</figcaption>
                    </figure>
                </div>

                <pre class="bg-gray-100 overflow-scroll p-4" tabindex="0">
                {!! htmlspecialchars('
<figure>
    <img src="/styleguide/image/400x300" alt="">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>') !!}
                </pre>

                <a href="/styleguide/figure" class="button mt-4">More options</a>
            </div>
        </div>

        <hr>

        <h2 class="pb-6">Colors</h2>

        <div class="flex flex-col space-y-3 sm:flex-row text-xs sm:space-y-0 sm:space-x-4">
            <div class="w-32 flex-shrink-0">
                <div class="h-10 flex flex-col justify-center">
                    <div class="text-sm font-semibold text-gray-900">Green</div>
                    <div>
                        <code class="text-xs text-gray-500">baseColors.green</code>
                    </div>
                </div>
            </div>
            <div class="min-w-0 flex-1 grid grid-cols-5 2xl:grid-cols-10 gap-x-4 gap-y-3 2xl:gap-x-2">
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-50"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">50</div>
                        <div>#CEDDDB</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-100"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">100</div>
                    <div>#9EBBB6</div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-200"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">200</div>
                        <div>#6D9892</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-300"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">300</div>
                        <div>#3D766D</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-400"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">400</div>
                    <div>#0C5449</div></div>
                </div>
                <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-500"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">500</div>
                        <div>#0B4A40</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-600"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">600</div>
                        <div>#094038</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-700"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">700</div>
                        <div>#08352F</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-800"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">800</div>
                        <div>#062B27</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-900"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">900</div>
                        <div>#05211E</div>
                    </div>
                </div>
            </div>
        </div>



        <div class="flex flex-col space-y-3 sm:flex-row text-xs sm:space-x-4">
            <div class="w-32 flex-shrink-0">
                <div class="h-10 flex flex-col justify-center">
                    <div class="text-sm font-semibold text-gray-900">Gold</div>
                    <div>
                        <code class="text-xs text-gray-500">baseColors.gold</code>
                    </div>
                </div>
            </div>
            <div class="min-w-0 flex-1 grid grid-cols-5 2xl:grid-cols-10 gap-x-4 gap-y-3 2xl:gap-x-2">
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-50"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">50</div>
                        <div>#FFF5D6</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-100"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">100</div>
                    <div>#FFEBAD</div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-200"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">200</div>
                        <div>#FFE085</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-300"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">300</div>
                        <div>#FFD65C</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-400"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">400</div>
                    <div>#FFCC33</div></div>
                </div>
                <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-500"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">500</div>
                        <div>#EDBD2C</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-600"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">600</div>
                        <div>#DBAE25</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-700"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">700</div>
                        <div>#C89F1F</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-800"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">800</div>
                        <div>#B69018</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-900"></div>
                    <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                        <div class="w-6 font-medium text-gray-900">900</div>
                        <div>#A48111</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
