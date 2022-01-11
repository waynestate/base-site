@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>The style guide is specific to each site, so please be sure you are viewing the correct one at <strong>[yourdomain].wayne.edu/styleguide</strong> (ex: <a href="//mac.wayne.edu/styleguide">mac.wayne.edu/styleguide</a>).

        <p>Your style guide is a how-to resource that will help you to determine what features you can incorporate into your website and how to implement them. It provides you with the ability to customize your pages and visually enhance your content for a better user experience.</p>

        <p>There are a variety of options available to use depending on your needs, but you can explore the menu to decide which items 
        would fit best when adding or editing your pages. Some experience with basic html is beneficial and will help when incorporating 
        some of the features into your site.</p>

        <p>We do offer a <a href="//go.wayne.edu/webtraining">CMS self-paced web training</a> that covers how to edit and manage the content on your site. This training is required for university staff.</p>

        <h2>Basic text formatting</h2>
        <p class="mb-1">These HTML classes are available for formatting paragraph or span elements. Add <code>class="text-lg"</code>, replacing "text-lg" with any of the names in the list below.</p>
        <ul>
            <li>font-normal</li>
            <li><span class="font-bold">font-bold</span></li>
            <li><span class="italic">italic</span></li>
            <li><span class="text-sm">text-sm</span></li>
            <li><span class="text-base">text-base</span></li>
            <li><span class="text-lg">text-lg</span></li>
            <li><span class="text-xl">text-xl</span></li>
        </ul>

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

        <h2>Unordered lists</h2>

        <ul>
            <li>First</li>
            <li>Second</li>
            <li>Third</li>
        </ul>

        <h2>Ordered lists</h2>

        <ol>
            <li>First</li>
            <li>Second</li>
            <li>Third</li>
        </ol>

        <h2>Blockquote</h2>

        <blockquote>
            <p>&ldquo;{{ $faker->paragraph(10) }}&rdquo;</p>
            <p>&ldquo;{{ $faker->paragraph(4) }}&rdquo;</p>
            <cite>&mdash; {{ $faker->Name }}</cite>
        </blockquote>

        <h2>PDF links</h2>

        <p>Links to PDFs will automatically append the file type to the end of the link. Example: <a href="example.pdf">download brochure</a>.</p>

        <h2>Abbreviations</h2>

        <p><abbr title="Wayne State University">WSU</abbr></p>
    </div>
@endsection
