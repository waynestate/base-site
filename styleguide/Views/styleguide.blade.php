@extends('partials.content-area')

@section('content')
    <h1 class="page-title">{{ $page['title'] }}</h1>

    <hr>

    <h2>2 Column Example</h2>
    <div class="row">
        <div class="small-12 large-6 columns">
            <p>{{ $faker->paragraph }}</p>
        </div>
        <div class="small-12 large-6 columns">
            <p>{{ $faker->paragraph }}</p>
        </div>
    </div>

    <a class="button" onclick="$('pre.columns-code').toggleClass('hide');">See Row/Columns Code</a>
    <pre class="columns-code hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
        {{ htmlspecialchars('
    <div class="row">
        <div class="small-12 large-6 columns">
            <p>'.$faker->paragraph.'</p>
        </div>
        <div class="small-12 large-6 columns">
            <p>'.$faker->paragraph.'</p>
        </div>
    </div>
        ') }}
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

    <a class="button" onclick="$('pre.table-stack').toggleClass('hide');">See Table Code</a>

    <pre class="table-stack hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
    {{ htmlspecialchars('
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
    ') }}
    </pre>

    <hr>

    <h2>Abbreviations</h2>

    <p><abbr title="Wayne State University">WSU</abbr></p>

    <hr>

    <div class="row">
        <div class="small-12 large-4 columns">
            <h2>Unordered lists</h2>

            <ul>
                <li>First</li>
                <li>Second</li>
                <li>Third</li>
            </ul>
        </div>

        <div class="small-12 large-4 columns">
            <h2>Ordered lists</h2>

            <ol>
                <li>First</li>
                <li>Second</li>
                <li>Third</li>
            </ol>
        </div>

        <div class="small-12 large-4 columns">
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

    <a class="button" onclick="$('pre.blockquote').toggleClass('hide');">See blockquote code</a>

    <pre class="blockquote hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
    {{ htmlspecialchars('
<blockquote>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
</blockquote>
    ') }}
    </pre>


    <hr>

    <h2>Buttons</h2>

    <a href="#" class="button">Standard Button</a>
    <a href="#" class="button expanded">Expanded Button</a>

    <a class="button" onclick="$('pre.button-examples').toggleClass('hide');">See Button Code</a>

    <pre class="button-examples hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
    {{ htmlspecialchars('
<a href="#" class="button">Standard Button</a>
<a href="#" class="button expanded">Expanded Button</a>
    ') }}
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

    <p><img src="/styleguide/image/50x50?text=Icon" class="icon" alt="icon image"></p>

    <a class="button" onclick="$('pre.image-icon').toggleClass('hide');">See Image Icon Code</a>

    <pre class="image-icon hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
    {{ htmlspecialchars('
<img src="/styleguide/50x50?text=Icon" class="icon" alt="">
    ') }}
    </pre>

    <hr>

    <h2>Maginific Pop-up</h2>
    <p>Any valid YouTube URL starting with <code>youtu.be</code> or <code>youtube.com/watch</code> will open a lightbox with the video.</p>
    <p><a href="//www.youtube.com/watch?v=guRgefesPXE"><img src="//i.wayne.edu/youtube/guRgefesPXE" alt="View YouTube Video"></a></p>

    <a class="button" onclick="$('pre.maginific-popup-example').toggleClass('hide');">See Maginific Pop-up Code</a>

    <pre class="maginific-popup-example hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
    {{ htmlspecialchars('
<p>
    <a href="//www.youtube.com/watch?v=guRgefesPXE">
        <img src="//i.wayne.edu/youtube/guRgefesPXE">
    </a>
</p>
    ') }}
    </pre>

    <hr>

    <h2>Responsive Embed</h2>

    <p>To make sure embedded content maintains its aspect ratio as the width of the screen changes, wrap the <code>iframe</code>, <code>object</code>, <code>embed</code>, or <code>video</code> in a container with the <code>.responsive-embed</code> class.</p>
    <div class="responsive-embed">
        <iframe width="420" height="315" src="//www.youtube.com/embed/guRgefesPXE" frameborder="0" allowfullscreen></iframe>
    </div>

    <a class="button" onclick="$('pre.responsive-embed-example').toggleClass('hide');">See Responsive Embed Code</a>

    <pre class="responsive-embed-example hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
    {{ htmlspecialchars('
<div class="responsive-embed">
    <iframe width="420" height="315" src="//www.youtube.com/embed/guRgefesPXE" frameborder="0" allowfullscreen></iframe>
</div>
    ') }}
    </pre>

    <hr>

    <div class="row">
        <div class="large-3 columns">
            <h2>Figure (left)</h2>

            <figure class="float-left" style="margin-top: 15px;">
                <img src="/styleguide/image/150x150" alt="Placeholder">
                <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
            </figure>

            <a class="button" onclick="$('pre.fig-left').toggleClass('hide');">See Code</a>

            <pre class="fig-left hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
            {{ htmlspecialchars('
<figure class="float-left">
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
            ') }}
            </pre>
        </div>

        <div class="large-3 columns">
            <h2>Figure (center)</h2>

            <figure class="text-center">
                <img src="/styleguide/image/150x150" alt="Placeholder">
                <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
            </figure>

            <a class="button" onclick="$('pre.fig-center').toggleClass('hide');">See Code</a>

            <pre class="fig-center hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
            {{ htmlspecialchars('
<figure class="text-center">
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
            ') }}
            </pre>
        </div>

        <div class="large-3 columns">
            <h2>Figure</h2>

            <figure>
                <img src="/styleguide/image/150x150" alt="Placeholder">
                <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
            </figure>

            <a class="button" onclick="$('pre.fig-none').toggleClass('hide');">See Code</a>

            <pre class="fig-none hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
            {{ htmlspecialchars('
<figure>
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
            ') }}
            </pre>
        </div>

        <div class="large-3 columns">
            <h2>Figure (right)</h2>

            <figure class="float-right" style="margin-top: 15px;">
                <img src="/styleguide/image/150x150" alt="Placeholder">
                <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
            </figure>

            <a class="button clearfix" onclick="$('pre.fig-right').toggleClass('hide');">See Code</a>

            <pre class="fig-right hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
            {{ htmlspecialchars('
<figure class="float-right">
    <img src="/styleguide/image/150x150" alt="Placeholder">
    <figcaption>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</figcaption>
</figure>
            ') }}
            </pre>
        </div>
    </div>
@endsection
