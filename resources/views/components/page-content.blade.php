{{--
    CMS page content
--}}

<div class="content">
    @include('components.page-title', ['title' => $title ?? $base['page']['title']])

    {!! $base['page']['content']['main'] !!}

    @if(empty($base['components']['page-content-row']) && empty($base['components']['page-content-column']))
        <div class="content">
            {!! $base['page']['content']['main'] !!}
        </div>
    @endif
</div>
