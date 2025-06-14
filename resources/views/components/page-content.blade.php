{{--
    CMS page content
--}}
@if(empty($base['components']['page-content-row']) && empty($base['components']['page-content-column']))
    @include('partials.page-content')
@endif
