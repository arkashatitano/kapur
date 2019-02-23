@foreach($seminar_list as $item)

    <div class="col-md-6 col-lg-4">
        <div class="blog">
            <a href="{{$item['seminar_url_'.$lang]}}" class="blog__img">
                <img src="{{$item['seminar_image']}}?width=360&height=250" alt="">
            </a>
            <div class="blog__date">{{\App\Http\Helpers::getDateFormat($item->seminar_date)}}</div>
            <div class="blog__text">{{$item['seminar_name_'.$lang]}}</div>
            <a href="{{$item['seminar_url_'.$lang]}}" class="button -underline">Подробнее</a>
        </div>
    </div>

@endforeach