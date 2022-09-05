<h2>Заявка на kap.kz</h2>

<p><b>Имя:</b>{{$param->user_name}}</p>
<p><b>Телефон:</b>{{$param->phone}}</p>

@if($param->email != '')
    <p><b>Почта:</b>{{$param->email}}</p>
@endif

@if($param->magazine_name_ru != '')
    <p><b>Журнал:</b>{{$param->magazine_name_ru}}</p>
@endif

@if($param->city_name != '')
    <p><strong>Город: </strong>{{$param->city_name}}</p>
@endif

@if($param->comment != '')
    <p><strong>Коммент клиента: </strong>{{$param->comment}}</p>
@endif

@if($param->pay_type != '')
    <p><strong>Подписка: </strong>{{$param->pay_type}}</p>
@endif