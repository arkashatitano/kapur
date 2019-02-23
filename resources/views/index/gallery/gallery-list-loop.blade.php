@foreach($gallery_list as $item)

    <div class="col-md-6 col-lg-4">
        <div class="blog">
            <a href="{{$item['gallery_url_'.$lang]}}" class="blog__img">
                <img src="{{$item['gallery_image']}}?width=360&height=250" alt="">
            </a>
            <div class="blog__date">{{$item['gallery_name_'.$lang]}}</div>
            <div class="blog__text">{{$item['gallery_desc_'.$lang]}}</div>
            <a href="{{$item['gallery_url_'.$lang]}}" class="button -underline">Подробнее</a>
        </div>
    </div>

@endforeach