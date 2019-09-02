@foreach($publication_list as $item)

    <div class="col-md-6 col-lg-4">
        <div class="blog @if($item->publication_price > 0) -locked @endif ">
            <a href="{{$item['publication_url_'.$lang]}}" class="blog__img">
                <img src="{{$item['publication_image']}}?width=360&height=250" alt="">
            </a>
            <div class="blog__date">{{\App\Http\Helpers::getDateFormat3($item->publication_date)}}</div>
            <div class="blog__text">{{$item['publication_name_'.$lang]}}</div>
            <a href="{{$item['publication_url_'.$lang]}}" class="button -underline">Подробнее</a>
        </div>
    </div>

@endforeach