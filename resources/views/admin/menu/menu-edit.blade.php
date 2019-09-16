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
                <a href="/admin/menu" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Назад</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-block">
                        @if (isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                        @if($row->menu_id > 0)
                            <form action="/admin/menu/{{$row->menu_id}}" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                @else
                                    <form action="/admin/menu" method="POST">
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="menu_id" value="{{ $row->menu_id }}">
                                        <input type="hidden" value="@if(isset($_GET['parent_id'])){{$_GET['parent_id']}}@endif" name="parent_id">

                                        <div class="box-body">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#ru" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Русский</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#kz" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Казахский</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#en" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Английский</span></a> </li>
                                                <li class="nav-item"> <a onclick="showDocumentUpload()" class="nav-link" data-toggle="tab" href="#pdf" id="pdf_tab" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Файлы</span></a> </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content tabcontent-border">
                                                <div class="tab-pane active" id="ru" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->menu_name_ru }}" type="text" class="form-control" name="menu_name_ru" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="text_editor" name="menu_text_ru" class="ckeditor form-control text_editor"><?=$row->menu_text_ru?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO title </label>
                                                            <input value="{{ $row->menu_meta_title_ru }}" type="text" class="form-control" name="menu_meta_title_ru" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->menu_meta_description_ru }}" type="text" class="form-control" name="menu_meta_description_ru" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->menu_meta_keywords_ru }}" type="text" class="form-control" name="menu_meta_keywords_ru" placeholder="Введите">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane  p-20" id="kz" role="tabpanel">
                                                    <div class="card-block1">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->menu_name_kz }}" type="text" class="form-control" name="menu_name_kz" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="text_editor2" name="menu_text_kz" class="ckeditor form-control text_editor"><?=$row->menu_text_kz?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO title </label>
                                                            <input value="{{ $row->menu_meta_title_kz }}" type="text" class="form-control" name="menu_meta_title_kz" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->menu_meta_description_kz }}" type="text" class="form-control" name="menu_meta_description_kz" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->menu_meta_keywords_kz }}" type="text" class="form-control" name="menu_meta_keywords_kz" placeholder="Введите">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-20" id="en" role="tabpanel">
                                                    <div class="card-block1">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->menu_name_en }}" type="text" class="form-control" name="menu_name_en" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="text_editor3" name="menu_text_en" class="ckeditor form-control text_editor"><?=$row->menu_text_en?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO title </label>
                                                            <input value="{{ $row->menu_meta_title_en }}" type="text" class="form-control" name="menu_meta_title_en" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->menu_meta_description_en }}" type="text" class="form-control" name="menu_meta_description_en" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->menu_meta_keywords_en }}" type="text" class="form-control" name="menu_meta_keywords_en" placeholder="Введите">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="pdf" role="tabpanel">
                                                    <div class="row" id="photo_content" style="min-height: 300px; padding: 20px">
                                                        @include('admin.index.document-loop')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Ссылка на другую страницу (если есть)</label>
                                                <input value="{{ $row->menu_redirect }}" type="text" class="form-control" name="menu_redirect" placeholder="Введите">
                                            </div>
                                          {{--  <div class="form-group">
                                                <label>Отображать на pre-header</label>
                                                <select name="is_show_header" data-placeholder="Выберите" class="form-control">
                                                    <option @if($row->is_show_header == 0) selected @endif value="0">Нет</option>
                                                    <option @if($row->is_show_header == 1) selected @endif value="1">Да</option>
                                                </select>
                                            </div>--}}
                                            <div class="form-group">
                                                <label>Отображать на header</label>
                                                <select name="is_show_main" data-placeholder="Выберите" class="form-control">
                                                    <option @if($row->is_show_main == 0) selected @endif value="0">Нет</option>
                                                    <option @if($row->is_show_main == 1) selected @endif value="1">Да</option>
                                                </select>
                                            </div>
                                            {{--<div class="form-group">
                                                <label>Отображать в футере</label>
                                                <select name="is_show_footer" data-placeholder="Выберите" class="form-control">
                                                    <option @if($row->is_show_footer == 0) selected @endif value="0">Нет</option>
                                                    <option @if($row->is_show_footer == 1) selected @endif value="1">Да</option>
                                                </select>
                                            </div>--}}
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
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="box box-primary" style="padding: 30px; text-align: center" id="file_upload_content">
                            <p>Загрузите файл</p>
                            <div style="padding: 20px; border: 1px solid #c2e2f0">
                                <img class="image-src" src="/file.png" style="width: 100%; "/>
                            </div>
                            <div style="background-color: #c2e2f0;height: 40px;margin: 0 auto;width: 2px;"></div>
                            <form id="image_multiple_form_document" enctype="multipart/form-data" method="post" class="image-form">
                                <i class="fa fa-plus"></i>
                                <input id="avatar-file" type="file" onchange="uploadMultipleDocument('index')" name="image"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection



