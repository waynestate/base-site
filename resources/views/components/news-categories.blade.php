{{--
    $categories => array // [['category_id', 'site_id', 'is_active', 'category', 'slug']]
    $selected_category => array // ['category_id', 'site_id', 'is_active', 'category', 'slug']
--}}
<h2>Filter by category</h2>

<ul>
    @foreach($categories as $category)
        <li{!! !empty($selected_category['category_id']) && $selected_category['category_id'] == $category['category_id'] ? ' class="selected"': '' !!}><a href="{{ $category['link'] }}">{{ $category['category'] }}</a></li>
    @endforeach
</ul>
