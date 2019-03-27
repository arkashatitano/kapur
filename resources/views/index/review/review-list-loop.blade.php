@foreach($review_list as $item)

    <div class="col-md-6 col-lg-4">
        <a href="{{$item['review_url_'.$lang]}}" class="news">
            <div class="news__date">{{\App\Http\Helpers::getDateFormat($item->review_date)}}</div>
            <div class="news__title">{{$item['review_name_'.$lang]}}</div>
        </a>
    </div>

@endforeach