@foreach($magazine_list as $item)

    <div class="col-md-6 col-lg-3">
        <div class="magazine">
            <a href="{{$item['magazine_url_'.$lang]}}" class="magazine__img">
                <img src="{{$item['magazine_image']}}?width=260&height=360" alt="">
            </a>
            <div class="magazine__issue">{{$item['magazine_number']}}</div>
            <div class="magazine__text">{{$item['magazine_name_'.$lang]}}</div>
        </div>
    </div>

@endforeach