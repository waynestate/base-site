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

    <h2>Accordion</h2>

    @if(isset($accordion))
        @include('components.accordion', ['items' => $accordion])
    @endif

    <a class="button" onclick="$('pre.accordions').toggleClass('hide');">See Accordion Code</a>

    <pre class="accordions hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
    {{ htmlspecialchars('
<ul class="accordion">
    <li class="is-active">
        <a href="#panel1a">Accordion 1</a>
        <div id="panel1a">
            <p>Panel 1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>
    <li>
        <a href="#panel2a">Accordion 2</a>
        <div id="panel2a">
            <p>Panel 2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>
    <li>
        <a href="#panel3a">Accordion 3</a>
        <div id="panel3a">
            <p>Panel 3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </li>
</ul>
    ') }}
    </pre>

    <hr>

    <h2>Table Stack</h2>

    <table class="table-stack">
    	<thead>
    		<tr>
    			<th>First Name</th>
    			<th>Last Name</th>
    			<th>Email</th>
    		</tr>
    	</thead>

    	<tbody>
            @for ($i = 0; $i < 10; $i++)
            <tr valign="top">
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
<table class="table-stack">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <tr valign="top">
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
    ') }}
    </pre>

    <hr>

    <h2>Blockquote</h2>

    <blockquote>
        {{ $faker->paragraph(10) }}
    </blockquote>

    <hr>

    <h2>Buttons</h2>

    <a href="http://foundation.zurb.com/sites/docs/button.html#basics" class="button">Standard Button</a>
    <a href="http://foundation.zurb.com/sites/docs/button.html#sizing" class="button expanded">Expanded Button</a>

    <a class="button" onclick="$('pre.button-examples').toggleClass('hide');">See Button Code</a>

    <pre class="button-examples hide" style="background: #EAEAEA; margin-bottom: 10px; overflow: scroll;">
    {{ htmlspecialchars('
<a href="http://foundation.zurb.com/sites/docs/button.html#basics" class="button">Standard Button</a>
<a href="http://foundation.zurb.com/sites/docs/button.html#sizing" class="button expanded">Expanded Button</a>
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

    <h2>Links that should not pick up SPF JS</h2>

    <ul>
        <li><a href="filename.pdf">Anything with a file extension</a> Ex: <code>.pdf</code></li>
        <li><a href="/styleguide" target="_blank">Relative URLs that open in new window</a> <code>target="_blank"</code></li>
    </ul>

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
@endsection
