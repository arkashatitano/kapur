<p>Уважаемый <b>{{$param->user_name}}</b>,</p>

<p>Благодарим Вас за покупку журнала <a href="{{$param->magazine_url}}">{{$param->magazine_name}}</a></p>

<strong>Скачать файл: </strong>

@foreach($param->document_list as $key => $item)

    <p>
        {{$key+1}}. <a href="{{$item->file_url}}">{{$item['file_name_ru']}}</a>
    </p>

@endforeach