@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="content">
        <hr>

        <h2>2 Column Example</h2>
        <div class="row px-4 flex">
            <div class="w-full sm:w-1/2 pr-4">
                <p>{{ $faker->paragraph }}</p>
            </div>
            <div class="w-full sm:w-1/2 pr-4">
                <p>{{ $faker->paragraph }}</p>
            </div>
        </div>

        <a class="button" onclick="document.querySelector('pre.columns-code').classList.toggle('hidden');">See Row/Columns Code</a>
        <pre class="columns-code hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
            {!! htmlspecialchars('
<div class="row px-4 flex">
    <div class="w-full sm:w-1/2 pr-4">
        <p>'.$faker->paragraph.'</p>
    </div>
    <div class="w-full sm:w-1/2 pr-4">
        <p>'.$faker->paragraph.'</p>
    </div>
</div>
            ') !!}
        </pre>

        <hr>

        <h2>Table</h2>

        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
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

        <a class="button" onclick="document.querySelector('pre.table-stack').classList.toggle('hidden');">See Table Code</a>

        <pre class="table-stack hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<table>
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
        ') !!}
        </pre>

        <hr>

        <h2>Abbreviations</h2>

        <p><abbr title="Wayne State University">WSU</abbr></p>

        <hr>

        <div class="row px-4 flex">
            <div class="w-full md:w-1/3">
                <h2>Unordered lists</h2>

                <ul>
                    <li>First</li>
                    <li>Second</li>
                    <li>Third</li>
                </ul>
            </div>

            <div class="w-full md:w-1/3">
                <h2>Ordered lists</h2>

                <ol>
                    <li>First</li>
                    <li>Second</li>
                    <li>Third</li>
                </ol>
            </div>

            <div class="w-full md:w-1/3">
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
            {{ $faker->paragraph(10) }}
        </blockquote>

        <a class="button" onclick="document.querySelector('pre.blockquote').classList.toggle('hidden');">See blockquote code</a>

        <pre class="blockquote hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<blockquote>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
</blockquote>
        ') !!}
        </pre>


        <hr>

        <h2>Buttons</h2>

        <a href="#" class="button">Standard Button</a>
        <a href="#" class="button expanded">Expanded Button</a>

        <a class="button" onclick="document.querySelector('pre.button-examples').classList.toggle('hidden');">See Button Code</a>

        <pre class="button-examples hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<a href="#" class="button">Standard Button</a>
<a href="#" class="button expanded">Expanded Button</a>
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

        <h2>Image Icon</h2>

        <p>Images default to span 100% of the container on small view. When using the <code>.icon</code> class you can override this behavior so it defaults to its real height/width.</p>

        <p>@image('/styleguide/image/50x50?text=Icon', 'icon image', 'icon')</p>

        <a class="button" onclick="document.querySelector('pre.image-icon').classList.toggle('hidden');">See Image Icon Code</a>

        <pre class="image-icon hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<img src="/styleguide/50x50?text=Icon" class="icon" alt="">
        ') !!}
        </pre>

        <hr>

        <h2>Media</h2>
        <p>Any valid YouTube URL starting with <code>youtu.be</code> or <code>youtube.com/watch</code> will open a lightbox with the video.</p>
        <p><a href="//www.youtube.com/watch?v=guRgefesPXE"><img src="//i.wayne.edu/youtube/guRgefesPXE" alt="View YouTube Video"></a></p>

        <a class="button" onclick="document.querySelector('pre.media-example').classList.toggle('hidden');">See Media Code</a>

        <pre class="media-example hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<p>
    <a href="//www.youtube.com/watch?v=guRgefesPXE">
        <img src="//i.wayne.edu/youtube/guRgefesPXE">
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

        <a class="button" onclick="document.querySelector('pre.responsive-embed-example').classList.toggle('hidden');">See Responsive Embed Code</a>

        <pre class="responsive-embed-example hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {!! htmlspecialchars('
<div class="responsive-embed">
    <iframe width="420" height="315" src="//www.youtube.com/embed/guRgefesPXE" title="Responsive embed example" frameborder="0" allowfullscreen></iframe>
</div>
        ') !!}
        </pre>

        <hr>

        <div class="row flex flex-wrap">
            <div class="w-full sm:w-1/4 px-4">
                <h2>Figure (left)</h2>

                <figure class="float-left" style="margin-top: 15px;">
                    @image('/styleguide/image/150x150', 'Placeholder')
                    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
                </figure>

                <a class="button" onclick="document.querySelector('pre.fig-left').classList.toggle('hidden');">See Code</a>

                <pre class="fig-left hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
                {!! htmlspecialchars('
<figure class="float-left">
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
                ') !!}
                </pre>
            </div>

            <div class="w-full sm:w-1/4 px-4">
                <h2>Figure (center)</h2>

                <figure class="text-center">
                    @image('/styleguide/image/150x150', 'Placeholder')
                    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
                </figure>

                <a class="button" onclick="document.querySelector('pre.fig-center').classList.toggle('hidden');">See Code</a>

                <pre class="fig-center hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
                {!! htmlspecialchars('
<figure class="text-center">
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
                ') !!}
                </pre>
            </div>

            <div class="w-full sm:w-1/4 px-4">
                <h2>Figure</h2>

                <figure>
                    @image('/styleguide/image/150x150', 'Placeholder')
                    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
                </figure>

                <a class="button" onclick="document.querySelector('pre.fig-none').classList.toggle('hidden');">See Code</a>

                <pre class="fig-none hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
                {!! htmlspecialchars('
<figure>
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
                ') !!}
                </pre>
            </div>

            <div class="w-full sm:w-1/4 px-4">
                <h2>Figure (right)</h2>

                <figure class="float-right" style="margin-top: 15px;">
                    @image('/styleguide/image/150x150', 'Placeholder')
                    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
                </figure>

                <a class="button" onclick="document.querySelector('pre.fig-right').classList.toggle('hidden');">See Code</a>

                <pre class="fig-right hidden" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
                {!! htmlspecialchars('
<figure class="float-right">
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
                ') !!}
                </pre>
            </div>
        </div>

        <hr>

        <h2 class="pb-6">Colors</h2>

        <div class="flex flex-wrap">
            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                <div class="rounded overflow-hidden">
                    <div class="text-white bg-green px-6 py-4 text-sm font-semibold relative shadow">
                        <div class="uppercase">Green</div>
                    </div>
                    <div class="text-black bg-green-lightest px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Lightest</span>
                    </div>
                    <div class="text-white bg-green-lighter px-6 py-3 text-sm font-semibold flex justify-between">
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
                    <div class="text-white bg-yellow-dark px-6 py-3 text-sm font-semibold flex justify-between">
                        <span>Dark</span>
                    </div>
                    <div class="text-white bg-yellow-darker px-6 py-3 text-sm font-semibold flex justify-between">
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
                    <div class="text-white bg-grey-dark px-6 py-3 text-sm font-semibold flex justify-between">
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
