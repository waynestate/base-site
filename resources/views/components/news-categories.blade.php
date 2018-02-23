{{--
    $categories => array // [['category_id', 'site_id', 'is_active', 'category', 'slug']]
    $selected_category => array // ['category_id', 'site_id', 'is_active', 'category', 'slug']
--}}
<h2>Filter by category</h2>

<ul>
    @foreach($categories as $category)
        <li{!! $selected_category['category_id'] == $category['category_id'] ? ' class="selected"': '' !!}><a href="/{{ ($site['subsite-folder'] !== null) ? $site['subsite-folder'] : '' }}news/category/{{ $category['slug'] }}">{{ $category['category'] }}</a></li>
    @endforeach
</ul>
