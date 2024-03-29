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
                <a href="/admin/magazine" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Назад</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-block">
                        @if (isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                        @if($row->magazine_id > 0)
                            <form action="/admin/magazine/{{$row->magazine_id}}" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                @else
                                    <form action="/admin/magazine" method="POST">
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="magazine_id" value="{{ $row->magazine_id }}">
                                        <input type="hidden" class="image-name" id="magazine_image" name="magazine_image" value="{{ $row->magazine_image }}"/>

                                        <div class="box-body">

                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item"> <a onclick="showImageUpload()" class="nav-link active" data-toggle="tab" href="#ru" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Русский</span></a> </li>
                                                <li class="nav-item"> <a onclick="showImageUpload()" class="nav-link" data-toggle="tab" href="#kz" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Казахский</span></a> </li>
                                                <li class="nav-item"> <a onclick="showImageUpload()" class="nav-link" data-toggle="tab" href="#en" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Английский</span></a> </li>
                                                <li class="nav-item"> <a onclick="showDocumentUpload()" class="nav-link" data-toggle="tab" href="#pdf" id="pdf_tab" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Файлы</span></a> </li>
                                            </ul>

                                            <div class="tab-content tabcontent-border">
                                                <div class="tab-pane active" id="ru" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->magazine_name_ru }}" type="text" class="form-control" name="magazine_name_ru" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="text_editor" name="magazine_text_ru" class="ckeditor form-control text_editor"><?=$row->magazine_text_ru?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Дополнительная информация</label>
                                                            <textarea name="magazine_desc_ru" class="ckeditor form-control text_editor"><?=$row->magazine_desc_ru?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->magazine_meta_description_ru }}" type="text" class="form-control" name="magazine_meta_description_ru" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->magazine_meta_keywords_ru }}" type="text" class="form-control" name="magazine_meta_keywords_ru" placeholder="Введите">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="kz" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->magazine_name_kz }}" type="text" class="form-control" name="magazine_name_kz" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="text_editor2" name="magazine_text_kz" class="ckeditor form-control text_editor"><?=$row->magazine_text_kz?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Дополнительная информация</label>
                                                            <textarea name="magazine_desc_kz" class="ckeditor form-control text_editor"><?=$row->magazine_desc_kz?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->magazine_meta_description_kz }}" type="text" class="form-control" name="magazine_meta_description_kz" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->magazine_meta_keywords_kz }}" type="text" class="form-control" name="magazine_meta_keywords_kz" placeholder="Введите">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="en" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->magazine_name_en }}" type="text" class="form-control" name="magazine_name_en" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="text_editor3" name="magazine_text_en" class="ckeditor form-control text_editor"><?=$row->magazine_text_en?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Дополнительная информация</label>
                                                            <textarea name="magazine_desc_en" class="ckeditor form-control text_editor"><?=$row->magazine_desc_en?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->magazine_meta_description_en }}" type="text" class="form-control" name="magazine_meta_description_en" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->magazine_meta_keywords_en }}" type="text" class="form-control" name="magazine_meta_keywords_en" placeholder="Введите">
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
                                                <label>Номер журнала</label>
                                                <input value="{{ $row->magazine_number }}" type="text" class="form-control" name="magazine_number" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label>Стоимость журнала (без доставки)</label>
                                                <input value="{{ $row->magazine_price }}" type="number" class="form-control" name="magazine_price" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label>Стоимость доставки</label>
                                                <input value="{{ $row->magazine_price_delivery }}" type="number" class="form-control" name="magazine_price_delivery" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label>Отображать на главной странице</label>
                                                <select name="is_show_main" data-placeholder="Выберите" class="form-control">
                                                    <option @if($row->is_show_main == 0) selected @endif value="0">Нет</option>
                                                    <option @if($row->is_show_main == 1) selected @endif value="1">Да</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Дата</label>
                                                <input id="date-format" value="{{ $row->magazine_date }}" type="text" class="form-control datetimepicker-input" name="magazine_date" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label>Цвет текста заголовка</label><br/>
                                                <input value="{{ $row->text_color }}" type="text" class="form-control complex-colorpicker" name="text_color" placeholder="">
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
                        <div class="box box-primary" style="padding: 30px; text-align: center" id="image_upload_content">
                            <div style="padding: 20px; border: 1px solid #c2e2f0">
                                <img class="image-src" src="{{ $row->magazine_image }}" style="width: 100%; "/>
                            </div>
                            <div style="background-color: #c2e2f0;height: 40px;margin: 0 auto;width: 2px;"></div>
                            <form id="image_form" enctype="multipart/form-data" method="post" class="image-form">
                                <i class="fa fa-plus"></i>
                                <input id="avatar-file" type="file" onchange="uploadImage()" name="image"/>
                            </form>
                        </div>
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

@section('js')


    <script>

        $('#date-format').bootstrapMaterialDatePicker({ format: 'DD.MM.YYYY HH:mm' });

        function showImageUpload(){
            $('#image_upload_content').fadeIn(0);
            $('#file_upload_content').fadeOut(0);
        }

        function showDocumentUpload(){
            $('#image_upload_content').fadeOut(0);
            $('#file_upload_content').fadeIn(0);
        }

    </script>

@endsection



