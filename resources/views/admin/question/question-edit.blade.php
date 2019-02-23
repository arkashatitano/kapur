@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0" >
                    {{ $title }}
                </h3>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                <a href="/admin/question" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Назад</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                        @if (isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                        @if($row->question_id > 0)
                            <form action="/admin/question/{{$row->question_id}}" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                @else
                                    <form action="/admin/question" method="POST">
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="question_id" value="{{ $row->question_id }}">
                                        <input type="hidden" value="@if(isset($_GET['parent_id'])){{$_GET['parent_id']}}@endif" name="parent_id">

                                        <div class="box-body">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#ru" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Русский</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#kz" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Казахский</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#en" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Английский</span></a> </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content tabcontent-border">
                                                <div class="tab-pane active" id="ru" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Вопрос</label>
                                                            <input value="{{ $row->question_name_ru }}" type="text" class="form-control" name="question_name_ru" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Ответ</label>
                                                            <textarea name="question_text_ru" class="ckeditor form-control text_editor"><?=$row->question_text_ru?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane  p-20" id="kz" role="tabpanel">
                                                    <div class="card-block1">
                                                        <div class="form-group">
                                                            <label>Вопрос</label>
                                                            <input value="{{ $row->question_name_kz }}" type="text" class="form-control" name="question_name_kz" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Ответ</label>
                                                            <textarea name="question_text_kz" class="ckeditor form-control text_editor"><?=$row->question_text_kz?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-20" id="en" role="tabpanel">
                                                    <div class="card-block1">
                                                        <div class="form-group">
                                                            <label>Вопрос</label>
                                                            <input value="{{ $row->question_name_en }}" type="text" class="form-control" name="question_name_en" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Ответ</label>
                                                            <textarea name="question_text_en" class="ckeditor form-control text_editor"><?=$row->question_text_en?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label>Порядковый номер сортировки</label>
                                                <input value="{{ $row->sort_num }}" type="text" class="form-control" name="sort_num" placeholder="">
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">Сохранить</button>
                                        </div>
                                    </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection



