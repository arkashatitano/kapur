@foreach($certificate_list as $item)

    <div class="col-md-6 col-lg-3 lg__item" data-src="{{$item['certificate_image']}}">
        <div class="notes">
            <a href="#" class="notes__img">
                <img title="{{$item['certificate_name_'.$lang]}}" src="{{$item['certificate_image']}}?width=260&height=360" alt="">
            </a>
            {{--<div class="notes__title">{{$item['certificate_name_'.$lang]}}</div>--}}
        </div>
    </div>

@endforeach