{{--
    CMS page content
--}}

<div class="content px-container-lg">
    @include('components.page-title', ['title' => $base['page']['title']])

    {!! $base['page']['content']['main'] !!}
</div>
