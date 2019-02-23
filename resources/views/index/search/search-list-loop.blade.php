@foreach($menu_list as $item)

    <div class="news mb-10">
        <a href="@if($item->menu_redirect == '')/{{$item['menu_url_'.$lang]}}@else{{$item['menu_redirect']}}@endif" class="news__title">{{$item['menu_name_'.$lang]}}</a>
    </div>

@endforeach

@foreach($news_list as $item)

    <div class="news mb-5">
        <a href="{{$item['news_url_'.$lang]}}" class="news__title">{{$item['news_name_'.$lang]}}</a>
        <div class="news__text">
            <p>{{$item['news_desc_'.$lang]}}</p>
        </div>
        <a href="{{$item['news_url_'.$lang]}}" class="news__link">{{Lang::get('app.read_more')}}</a>
    </div>

@endforeach

@foreach($arbitrator_list as $item)

    <div class="news mb-5">
        <a href="{{$item['arbitrator_url_'.$lang]}}" class="news__title">{{$item['arbitrator_name_'.$lang]}}</a>
        <div class="news__text">
            <p>{{$item['arbitrator_desc_'.$lang]}}</p>
        </div>
        <a href="{{$item['arbitrator_url_'.$lang]}}" class="news__link">{{Lang::get('app.read_more')}}</a>
    </div>

@endforeach

