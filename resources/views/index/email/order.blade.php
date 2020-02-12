<h2>Заявка на kap.kz</h2>

<p><b>Имя:</b>{{$param->user_name}}</p>
<p><b>Телефон:</b>{{$param->phone}}</p>

@if($param->email != '')
    <p><b>Почта:</b>{{$param->email}}</p>
@endif

@if($param->magazine_name_ru != '')
    <p><b>Журнал:</b>{{$param->magazine_name_ru}}</p>
@endif

@if($param->pay_type != '')
    <p><b>Оплата:</b>{{$param->pay_type}}</p>
@endif

@if($param->price != '')
    <p><b>Стоимость:</b>{{$param->price}}тг</p>
@endif

@if($param->transaction_number != '' && $param->is_pay == 1)
    <p style="color: green"><strong>Оплачено, Номер транзакции: </strong>{{$param->transaction_number}}</p>
@endif

@if($param->comment != '')
    <p>{{$param->comment}}</p>
@endif

@if($param->city_name != '')
    <p><strong>Город: </strong>{{$param->city_name}}</p>
@endif

@if($param->organization_name != '')
    <p><strong>Организация: </strong>{{$param->organization_name}}</p>
@endif

@if($param->position != '')
    <p><strong>Должность: </strong>{{$param->position}}</p>
@endif

@if($param->work_phone != '')
    <p><strong>Служебный номер: </strong>{{$param->work_phone}}</p>
@endif

@if($param->fax != '')
    <p><strong>Факс: </strong>{{$param->fax}}</p>
@endif

@if($param->company_info != '')
    <p><strong>Реквизиты компании: </strong>{{$param->company_info}}</p>
@endif

@if($param->director_name != '')
    <p><strong>Директор: </strong>{{$param->director_name}}</p>
@endif