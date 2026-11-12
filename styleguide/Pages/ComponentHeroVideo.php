<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroVideo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero video',
                'id' => 105100116,
                'content' => [
                    'main' => '<p>The ability to use the "Hero video" component requires specific formatting of files and use of the hero promotion group.</p>
<p>Start with a 16:9 4K videoo and convert to WebM (VP9) format for best compatibility.</p>
<p>First frame screenshot</p>
<p><pre>$ ffmpeg -i hero-full.mov -frames:v 1 hero-full-frame1.jpg</pre></p>
<p>Convert to WebM VP9 format</p>
<p><pre>$ ffmpeg -i hero-full.mov -vf scale=1280:720 -c:v libvpx-vp9 -b:v 1M -crf 30 hero-full-720p.webm</pre></p>
<p>Resize the first frame screenshot to 3200px wide with Photoshop and save it at 5% quality jpg.</p>
<p>Upload it to the &quot;hero-assets&quot; folder and copy the full URL to use in the &#39;alt text&#39; for the video.</p>',
                ],
            ],
        ]);
    }
}
