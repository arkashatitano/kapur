@foreach($menu_list as $item)

    <a target="_blank" href="@if($item->menu_redirect == '')/{{$item['menu_url_'.$lang]}}@else{{$item['menu_redirect']}}@endif" class="docs__item">
        <div class="docs__title">{{$item['menu_name_'.$lang]}}</div>
        <div class="docs__size"></div>
    </a>

@endforeach

@foreach($news_list as $item)

    <a target="_blank" href="{{$item['news_url_'.$lang]}}" class="docs__item">
        <div class="docs__title">{{$item['news_name_'.$lang]}}</div>
        <div class="docs__size"></div>
    </a>

@endforeach

