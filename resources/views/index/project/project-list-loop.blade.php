@foreach($project_list as $item)

    <div class="col-md-6 col-lg-4">
        <a href="{{$item['project_url_'.$lang]}}" class="news">
            <div class="news__date">{{\App\Http\Helpers::getDateFormat3($item->project_date)}}</div>
            <div class="news__title">{{$item['project_name_'.$lang]}}</div>
        </a>
    </div>

@endforeach