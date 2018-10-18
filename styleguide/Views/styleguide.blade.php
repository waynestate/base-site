@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

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

        <a href="#two-columns-code" class="button" onclick="document.querySelector('pre.two-columns-code').classList.toggle('hidden');">See row/columns code</a>
        <pre class="two-columns-code hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
            {!! htmlspecialchars('
<div class="row -mx-4 md:flex">
    <div class="md:w-1/2 px-4">
        <p>'.$faker->paragraph.'</p>
    </div>
    <div class="md:w-1/2 px-4">
        <p>'.$faker->paragraph.'</p>
    </div>
</div>
            ') !!}
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

        <a href="#three-columns-code" class="button" onclick="document.querySelector('pre.three-columns-code').classList.toggle('hidden');">See row/columns code</a>
        <pre class="three-columns-code hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
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
</div>
            ') !!}
        </pre>

        <hr>

        <h2>Table</h2>

        <table class="table-stack" aria-label="Example table with fake contact information">
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
                    <td><img src="/styleguide/image/150x50?text=150x50" alt="" style="margin: 10px;">
                    <td>{{ $faker->firstName }}</td>
                    <td>{{ $faker->lastName }}</td>
                    <td><a href="mailto:{{ $faker->email }}">{{ $faker->email }}</a></td>
                </tr>
                @endfor
            </tbody>
        </table>

        <a href="#table-stack" class="button" onclick="document.querySelector('pre.table-stack').classList.toggle('hidden');">See table code</a>

        <pre class="table-stack hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<table class="table-stack" aria-label="Example table">
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
</table>
        ') !!}
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
            <p>{{ $faker->paragraph(10) }}</p>
        </blockquote>

        <a href="#blockquote" class="button" onclick="document.querySelector('pre.blockquote').classList.toggle('hidden');">See blockquote code</a>

        <pre class="blockquote hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<blockquote>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
</blockquote>
        ') !!}
        </pre>


        <hr>

        <h2>Buttons</h2>

        <a href="#standard-button" class="button">Standard button</a>
        <a href="#expanded-button" class="button expanded">Expanded button</a>
        <br />
        <a href="#button-examples" class="button" onclick="document.querySelector('pre.button-examples').classList.toggle('hidden');">See button code</a>

        <pre class="button-examples hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<a href="#" class="button">Standard button</a>
<a href="#" class="button expanded">Expanded button</a>
        ') !!}
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
        <p>Any valid YouTube URL starting with <code>youtu.be</code> or <code>youtube.com/watch</code> will open a lightbox with the video.</p>
        <p><a href="//www.youtube.com/watch?v=guRgefesPXE"><img src="//i.wayne.edu/youtube/guRgefesPXE" alt="School of Medicine Commencement YouTube video"></a></p>

        <a href="#media-example" class="button" onclick="document.querySelector('pre.media-example').classList.toggle('hidden');">See media code</a>

        <pre class="media-example hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<p>
    <a href="//www.youtube.com/watch?v=guRgefesPXE">
        <img src="//i.wayne.edu/youtube/guRgefesPXE" alt="Description of YouTube video">
    </a>
</p>
        ') !!}
        </pre>

        <hr>

        <h2>Responsive Embed</h2>

        <p>To make sure embedded content maintains its aspect ratio as the width of the screen changes, wrap the <code>iframe</code>, <code>object</code>, <code>embed</code>, or <code>video</code> in a container with the <code>.responsive-embed</code> class.</p>
        <div class="responsive-embed">
            <iframe width="420" height="315" src="//www.youtube.com/embed/guRgefesPXE" title="Responsive embed example" frameborder="0" allowfullscreen></iframe>
        </div>

        <a href="#responsive-embed-example" class="button" onclick="document.querySelector('pre.responsive-embed-example').classList.toggle('hidden');">See responsive embed code</a>

        <pre class="responsive-embed-example hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<div class="responsive-embed">
    <iframe width="420" height="315" src="//www.youtube.com/embed/guRgefesPXE" title="Responsive embed example" frameborder="0" allowfullscreen></iframe>
</div>
        ') !!}
        </pre>

        <hr>

        <div class="row flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <h2>Figure</h2>

                <div class="table">
                    <figure>
                        @image('/styleguide/image/400x300', 'Placeholder', 'p-10px')
                        <figcaption>{{ $faker->paragraph }}</figcaption>
                    </figure>
                </div>

                <a href="#fig-none" class="button mr-4" onclick="document.querySelector('pre.fig-none').classList.toggle('hidden');">See code</a>
                <a href="/styleguide/figure" class="button">More options</a>

                <pre class="fig-none hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
                {!! htmlspecialchars('
<figure>
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
                ') !!}
                </pre>
            </div>
        </div>

        <hr>

        <h2 class="pb-6">Colors</h2>

        <div class="flex flex-wrap -mx-4">
            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                <div class="rounded overflow-hidden">
                    <div class="text-white bg-green px-6 py-4 text-sm font-semibold relative shadow">
                        <div class="uppercase">Green</div>
                    </div>
                    <div class="text-black bg-green-lightest px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Lightest</span>
                    </div>
                    <div class="text-black bg-green-lighter px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Lighter</span>
                    </div>
                    <div class="text-white bg-green-light px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Light</span>
                    </div>
                    <div class="text-white bg-green px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Base</span>
                    </div>
                    <div class="text-white bg-green-dark px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Dark</span>
                    </div>
                    <div class="text-white bg-green-darker px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Darker</span>
                    </div>
                    <div class="text-white bg-green-darkest px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Darkest</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                <div class="rounded overflow-hidden">
                    <div class="text-black bg-yellow px-6 py-4 text-sm font-semibold relative shadow">
                        <div class="uppercase">Yellow</div>
                    </div>
                    <div class="text-black bg-yellow-lightest px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Lightest</span>
                    </div>
                    <div class="text-black bg-yellow-lighter px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Lighter</span>
                    </div>
                    <div class="text-black bg-yellow-light px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Light</span>
                    </div>
                    <div class="text-black bg-yellow px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Base</span>
                    </div>
                    <div class="text-black bg-yellow-dark px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Dark</span>
                    </div>
                    <div class="text-black bg-yellow-darker px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Darker</span>
                    </div>
                    <div class="text-white bg-yellow-darkest px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Darkest</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                <div class="rounded overflow-hidden">
                    <div class="text-black bg-grey px-6 py-4 text-sm font-semibold relative shadow">
                        <div class="uppercase">Grey</div>
                    </div>
                    <div class="text-black bg-white px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>White</span>
                    </div>
                    <div class="text-black bg-grey-lightest px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Lightest</span>
                    </div>
                    <div class="text-black bg-grey-lighter px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Lighter</span>
                    </div>
                    <div class="text-black bg-grey-light px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Light</span>
                    </div>
                    <div class="text-black bg-grey px-6 py-3 text-sm font-semibold flex justify-between flex justify-between">
                        <span>Base</span>
                    </div>
                    <div class="text-black bg-grey-dark px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Dark</span>
                    </div>
                    <div class="text-white bg-grey-darker px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Darker</span>
                    </div>
                    <div class="text-white bg-grey-darkest px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Darkest</span>
                    </div>
                    <div class="text-white bg-black px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Black</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
