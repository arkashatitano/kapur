@extends('admin.layout.layout')

@section('content')


    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a href="/admin/order/publication?active=1" class="@if($request->active == '1') active-page @endif">Новые</a>
                </h3>
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab second-tab" >
                    <a href="/admin/order/publication" class="@if(!isset($request->active) || $request->active == '0') active-page @endif">Прочитанные</a>
                </h3>
                <div class="clear-float"></div>
            </div>
        </div>

        <div class="row white-bg">
            <div style="text-align: left" class="form-group col-md-6" >

                @if($request->active == '1')

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowDisabledAll('order')">Отметить как прочитанное</a>
                    </h4>

                @else

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowEnabledAll('order')">Отметить как непрочитанное</a>
                    </h4>

                @endif

            </div>
            <div style="text-align: right" class="form-group col-md-6" >
                <h4 class="box-title box-delete-click">
                    <a href="javascript:void(0)" onclick="deleteAll('order')">Удалить отмеченные</a>
                </h4>
            </div>

            <div class="col-md-12">
                <div class="box-body">
                    <table id="news_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>ФИО </th>
                            <th>Статья </th>
                            <th>Стоимость </th>
                            <th style="min-width: 300px">Инфо </th>
                            <th>Оплата</th>
                            <th>Дата</th>
                            <th style="width: 15px"></th>
                            <th class="no-sort" style="width: 0px; text-align: center; padding-right: 16px; padding-left: 14px;" >
                                <input onclick="selectAllCheckbox(this)" style="font-size: 15px" type="checkbox" value="1"/>
                            </th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td></td>
                            <td>
                                <form>
                                    <input value="{{$request->search}}" type="text" class="form-control" name="search" placeholder="">
                                </form>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td> {{ $key + 1 }}</td>
                                <td class="arial-font">
                                    <div>
                                        {{ $val->user_name }}
                                    </div>
                                </td>
                                <td class="arial-font">
                                    <div>
                                        {{ $val->publication_name_ru }}
                                    </div>
                                </td>
                                <td class="arial-font">
                                    <div>
                                        {{ $val->price }}тг
                                    </div>
                                </td>
                                <td>
                                    <p><strong>Почта: </strong>{{$val->email}}</p>
                                    <p><strong>Телефон: </strong>{{$val->phone}}</p>

                                    @if($val->city_name != '')
                                        <p><strong>Город: </strong>{{$val->city_name}}</p>
                                    @endif
                                </td>
                                <td>
                                    <p>{{$val->pay_type}}</p>
                                    <p>{{$val->comment}}</p>

                                    @if($val->transaction_number != '' && $val->is_pay == 1)
                                        <p style="color: green"><strong>Оплачено, номер транзакции: </strong>{{$val->transaction_number}}</p>
                                    @endif

                                    @if($val->is_pay == 0)
                                        <p style="color: red">Не оплачено</p>
                                    @endif

                                </td>
                                <td>
                                    {{ \App\Http\Helpers::getDateFormat($val->date)}}
                                </td>
                                <td style="text-align: center">


                                    <a href="javascript:void(0)" onclick="delItem(this,'{{ $val->order_id }}','order')">
                                        <i class="mdi mdi-delete" style="font-size: 20px; color: red;"></i>
                                    </a>

                                </td>

                                <td style="text-align: center;">
                                    <input class="select-all" style="font-size: 15px" type="checkbox" value="{{$val->order_id}}"/>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                    <div style="text-align: center">
                        {{ $row->appends(\Illuminate\Support\Facades\Input::except('page'))->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>


    <style>
        strong {
            font-weight: bold !important;
        }
    </style>
@endsection