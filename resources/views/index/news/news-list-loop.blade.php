@foreach($news_list as $item)

    <div class="col-md-6 col-lg-4">
        <a href="{{$item['news_url_'.$lang]}}" class="news">
            <div class="news__date">{{\App\Http\Helpers::getDateFormat3($item->news_date)}}</div>
            <div class="news__title">{{$item['news_name_'.$lang]}}</div>
        </a>
    </div>

@endforeach