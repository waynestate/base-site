@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>The style guide is specific to each site, so please be sure you are viewing the correct one at <strong>[yourdomain].wayne.edu/styleguide</strong> (ex: <a href="//mac.wayne.edu/styleguide">mac.wayne.edu/styleguide</a>).

        <p>Your style guide is a how-to resource that will help you to determine what features you can incorporate into your website and how to implement them. It provides you with the ability to customize your pages and visually enhance your content for a better user <a class="external-link">experience</a>.</p>

        <p>There are a variety of options available to use depending on your needs, but you can explore the menu to decide which items 
        would fit best when adding or editing your pages. Some experience with basic html is beneficial and will help when incorporating 
        some of the features into your site.</p>

        <p>We do offer a <a href="https://go.wayne.edu/webtraining">CMS self-paced web training</a> that covers how to edit and manage the content on your site. This training is required for university staff.</p>
        
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
        
        <h1>&lt;h1&gt; Heading level 1</h1>
        <p>Heading level 1 is the title of the webpage. This is only used once per page. Content creators should focus on heading level 2 - heading level 6 on their webpages.</p>
        
        <h2>&lt;h2&gt; Heading level 2</h2>
        <p>Heading level 2 contains a primary section of content. All heading text should be brief, clear, informative and unique. Headings should not be utilized to format content. There can be multiple heading 2’s on a page. </p>
        
        <h3>&lt;h3&gt; Heading level 3</h3>
        <p>Heading level 3 is a subsection of a heading level 2. All heading text should be brief, clear, informative and unique. Headings should not be utilized to format content. There can be multiple heading 3’s on a page but they must be under the content of a heading level 2 and related to the content of a heading level 2.</p>

        <h4>&lt;h4&gt; Heading level 4</h4>
        <p>Heading level 4 is a subsection of a heading level 3. All heading text should be brief, clear, informative and unique. Headings should not be utilized to format content. There can be multiple heading 4’s on a page but they must be under the content of a heading level 3 and related to the content of a heading level 3.</p>

        <h5>&lt;h5&gt; Heading level 5</h5>
        <p>Heading level 5 is a subsection of a heading level 4. These are not common and we do recommend restructuring your content if you get to a heading level 5. You may want to create a new page or condense your information. </p>

        <h6>&lt;h6&gt; Heading level 6</h6>
        <p>Heading level 6 is a subsection of a heading level 5. These are not common and we do recommend restructuring your content if you get to a heading level 6. You may want to create a new page or condense your information. </p>

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
