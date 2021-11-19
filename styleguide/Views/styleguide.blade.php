@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Welcome to your Styleguide! The styles listed on this page are available to you in the CMS.</p>

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

        <hr>

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

        <hr>

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
