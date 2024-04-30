@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Any link to a valid YouTube URL starting with "youtu.be" or "youtube.com/watch" will open a lightbox to play the video.</p>

        <h2>Use the poster image from YouTube</h2>
        <p>This example provides a high resolution image 1280x720px without a play button. Use the class "play-video-button" to apply a play button to this image.</p>
        <a href="//www.youtube.com/watch?v=PHqfwq033yQ" class="play-video-button block my-4">
            @image("//i.wayne.edu/youtube/PHqfwq033yQ/max", "Warrior Strong", "lazy")
        </a>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<a href="//www.youtube.com/watch?v=yourVideoID" class="play-video-button">
    <img src="//i.wayne.edu/youtube/yourVideoID/max" alt="Description of YouTube video">
</a>') !!}
</pre>
        <p>This second example serves up a smaller version of the poster image with a play button already on it at 480x270px.</p>
        <a href="//www.youtube.com/watch?v=PHqfwq033yQ" class="block my-4">
            @image("//i.wayne.edu/youtube/PHqfwq033yQ", "Warrior Strong", "lazy")
        </a>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<a href="//www.youtube.com/watch?v=yourVideoID">
    <img src="//i.wayne.edu/youtube/yourVideoID" alt="Description of YouTube video">
</a>') !!}
</pre>

        <h2>Embed a video</h2>
        <p>To make sure embedded content maintains its aspect ratio as the width of the screen changes, wrap the embedded object in a div container with the <code>responsive-embed</code> class.</p>
        <div class="responsive-embed">
            <iframe width="420" height="315" src="//www.youtube.com/embed/PHqfwq033yQ" title="Responsive embed example" allowfullscreen></iframe>
        </div>
<pre class="code-block" tabindex="0">
{!! htmlspecialchars('<div class="responsive-embed">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/PHqfwq033yQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>') !!}
</pre>



    </div>
@endsection
