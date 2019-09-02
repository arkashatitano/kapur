@foreach($conference_list as $item)

    <div class="col-md-6 col-lg-4">
        <a href="{{$item['conference_url_'.$lang]}}" class="news">
            <div class="news__date">{{\App\Http\Helpers::getDateFormat3($item->conference_date)}}</div>
            <div class="news__title">{{$item['conference_name_'.$lang]}}</div>
        </a>
    </div>

@endforeach