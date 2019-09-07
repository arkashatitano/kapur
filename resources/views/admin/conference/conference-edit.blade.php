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
                <a href="/admin/conference" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Назад</a>
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
                        @if($row->conference_id > 0)
                            <form action="/admin/conference/{{$row->conference_id}}" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                @else
                                    <form action="/admin/conference" method="POST">
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="conference_id" value="{{ $row->conference_id }}">
                                        <input type="hidden" class="image-name" id="conference_image" name="conference_image" value="{{ $row->conference_image }}"/>

                                        <div class="box-body">

                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item"> <a onclick="showImageUpload()" class="nav-link active" data-toggle="tab" href="#ru" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Русский</span></a> </li>
                                                <li class="nav-item"> <a onclick="showImageUpload()" class="nav-link" data-toggle="tab" href="#kz" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Казахский</span></a> </li>
                                                <li class="nav-item"> <a onclick="showImageUpload()" class="nav-link" data-toggle="tab" href="#en" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Английский</span></a> </li>
                                                <li class="nav-item"> <a onclick="showDocumentUpload()" class="nav-link" data-toggle="tab" href="#pdf" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">PDF</span></a> </li>
                                            </ul>

                                            <div class="tab-content tabcontent-border">
                                                <div class="tab-pane active" id="ru" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->conference_name_ru }}" type="text" class="form-control" name="conference_name_ru" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="conference_text_ru" name="conference_text_ru" class="ckeditor form-control text_editor"><?=$row->conference_text_ru?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->conference_meta_description_ru }}" type="text" class="form-control" name="conference_meta_description_ru" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->conference_meta_keywords_ru }}" type="text" class="form-control" name="conference_meta_keywords_ru" placeholder="Введите">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="kz" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->conference_name_kz }}" type="text" class="form-control" name="conference_name_kz" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="conference_text_kz" name="conference_text_kz" class="ckeditor form-control text_editor"><?=$row->conference_text_kz?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->conference_meta_description_kz }}" type="text" class="form-control" name="conference_meta_description_kz" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->conference_meta_keywords_kz }}" type="text" class="form-control" name="conference_meta_keywords_kz" placeholder="Введите">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane " id="en" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Название</label>
                                                            <input value="{{ $row->conference_name_en }}" type="text" class="form-control" name="conference_name_en" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст</label>
                                                            <textarea id="conference_text_en" name="conference_text_en" class="ckeditor form-control text_editor"><?=$row->conference_text_en?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO description </label>
                                                            <input value="{{ $row->conference_meta_description_en }}" type="text" class="form-control" name="conference_meta_description_en" placeholder="Введите">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta SEO keywords</label>
                                                            <input value="{{ $row->conference_meta_keywords_en }}" type="text" class="form-control" name="conference_meta_keywords_en" placeholder="Введите">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="pdf" role="tabpanel">
                                                    <input type="hidden" class="pdf_url" value="{{$row['conference_pdf']}}" name="conference_pdf">
                                                    <div id="photo_content" style="min-height: 300px">
                                                        @include('admin.conference.document-loop')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Дата</label>
                                                <input id="date-format" value="{{ $row->conference_date }}" type="text" class="form-control datetimepicker-input" name="conference_date" placeholder="">
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
                                <img class="image-src" src="{{ $row->conference_image }}" style="width: 100%; "/>
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
                            <form id="image_form_document" enctype="multipart/form-data" method="post" class="image-form">
                                <i class="fa fa-plus"></i>
                                <input id="avatar-file" type="file" onchange="uploadDocument()" name="image"/>
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



