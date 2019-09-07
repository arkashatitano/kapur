<div class="modal-content"><script>
        $("head").append($('<link href="/custom/tinymce/css/basic.min.css" rel="stylesheet">'))
                .append($('<link href="/custom/tinymce/css/dropzone.min.css" rel="stylesheet">'))
                .append($('<link href="/custom/tinymce/css/modal_uploadimage.css" rel="stylesheet">'));
    </script>
    <div class="modal-uploadimage">
        <div class="modal-header modal-thumbnail" style="display: block">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                <li role="presentation" class="active"><a href="#tab_image_new" aria-controls="tab_image_new" role="tab" data-toggle="tab">Загрузите фото</a></li>
                {{--<li role="presentation"><a href="#tab_image_list" aria-controls="tab_image_list" role="tab" data-toggle="tab">Жолданған суреттерден талдау</a></li>--}}
            </ul>
        </div>
        <div class="modal-body">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_image_new">
                    {{--<h4>Выберите фото</h4>--}}
                    <form action="" method="post" class="dropzone" enctype="multipart/form-data" id="js-upload-form">
                        <div class="form-inline">
                            <div class="form-group">
                                <button onclick="$('#drop-zone').trigger('click');" class="btn btn-default" type="button">Выбор фото</button>
                            </div>

                        </div>
                        <h4></h4>
                        <div class="upload-drop-zone dz-clickable" id="drop-zone">
                            Переместите фото сюда
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" value="фото на kap.kz" name="title" id="input_image_title" class="form-control" required="" placeholder="Напишите название фото">
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon-copyright">Ⓒ</span>
                                    <input type="text" id="input_image_copyright" name="copyright" class="form-control" value="kap.kz" placeholder="Источник" aria-describedby="basic-addon-copyright">
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-primary" id="js-upload-submit">Загрузить</button>
                            </div>
                        </div>
                        <input name="__RequestVerificationToken" type="hidden" value="CfDJ8DIOsG7ZqfdEnILuRHnYeS6bX3Bb9n_GIciVgMquObY3QmkwaYPHpkUXeKIalrkG0Q7QtnDhwjZu7zg1GbUYPyiQ5aeolJ97Mom36q9Juas2Q-iPjhPtv6bXBX-ssCKeFFXeM1IRhd_QhD4i7L_zpHqzJf_zUtwxNeGtwO8L4q7-5iUBtHB_6unIi2L4rII_Dw"></form>
                </div>
                <div role="tabpanel" class="tab-pane form-horizontal" id="tab_image_list">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <div class="checkbox checkbox-info checkbox-inline">
                                <input id="checkbox_image_self" type="checkbox">
                                <label for="checkbox_image_self"> Список </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" id="input_search_image" class="form-control" placeholder="Поиск...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" id="button_search_image" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-bordered table-condensed" id="table_image_list">
                                <thead>
                                <tr><th>#</th><th>Название фото</th><th>2</th><th style="width:50px;">1</th></tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <img src="/images/loading.gif" style="margin:0 auto;" class="img-responsive">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-right" id="image_list_pagination">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/custom/tinymce/js/dropzone.min.js"></script>
    <script>


        $(function () {


            $("#button_search_image").on("click", function () {
                var querySelf = $("#checkbox_image_self").is(":checked") ? 1 : 0;
                keyWord = $("#input_search_image").val();
                if (!$.trim(keyWord)) {
                    showError('Укажите название фото!');
                    $("#input_search_image").focus();
                    return;
                }
                getImageList(1, querySelf, true, keyWord);
            });
            $("#input_search_image").on("keydown", function (e) {
                var ev = e ? e : window.event,
                        src = ev.srcElement ? ev.srcElement : ev.target,
                        keyCode = ev.keyCode ? ev.keyCode : ev.which;
                if (keyCode == 13) {
                    $("#button_search_image").trigger("click");
                }
            })

        })

        $(function () {
            $.getScript("/custom/tinymce/js/dropzone.min.js", function () {
                var dropZone = new Dropzone("div#drop-zone",
                        { url: "/image/upload/base",
                            method: "POST",
                            acceptedFiles:"*",
                            autoProcessQueue: false,
                            maxFiles:1,
                            paramName: "file",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            maxFilesize: 50 });

                dropZone.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                dropZone.on("sending", function (file, xhr, formData) {
                    formData.append('resourceTypeId', 3);
                    formData.append('title', $("#input_image_title").val());
                    formData.append('copyright', $("#input_image_copyright").val());
                });

                dropZone.on("success", function (file, data) {
                    if (data["status"] == "success") {
                        $("#image-modal").modal("hide");
                        showMessage(data.message);
                        eval("setEditorImagelUrl" + "('" + JSON.stringify(data["data"]) + "')");
                    } else {
                        showError(data.message);
                    }
                });

                dropZone.on("drop", function () {
                    $("div#drop-zone").addClass('upload-drop-zone');
                })
                dropZone.on("dragover", function () {
                    $("div#drop-zone").addClass('drop');
                })
                dropZone.on("dragleave", function () {
                    $("div#drop-zone").addClass('upload-drop-zone');
                })
                $("#js-upload-submit").on("click", function () {
                    var title = $("#input_image_title").val();
                    if (!$.trim(title)) {
                        showError('Укажите название фото!');
                        $("#input_image_title").focus();
                        return;
                    }

                    var copyright = $("#input_image_copyright").val();
                    if (!$.trim(copyright)) {
                        showError('Укажите источник!');
                        $("#input_image_copyright").focus();
                        return false;
                    }

                    dropZone.processQueue();
                })
            })
        })

        function setEditorImagelUrl(data) {
            data = $.parseJSON(data);
            tinymce.activeEditor.execCommand('mceInsertContent', false, '<img src="' + data["url"] + '" alt="' + data["title"] + '" data-copyright="' + data["copyright"]+'" />');
        }
    </script></div>