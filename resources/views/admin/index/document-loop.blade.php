@if(isset($document_list))

    @foreach($document_list as $item)

        <div class="col-md-12 multiple-file">
            <div class="row" style="border: 2px solid #1E88E5;padding: 10px; margin: 5px">
                <input type="hidden" name="file_url_input[]" value="{{$item['file_url']}}"/>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Фото</label>
                        <a href="{{$item['file_url']}}" target="_blank">
                            <img style="width: 100%" src="/file1.jpg"/>
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                    <a href="javascript:void(0)" onclick="deleteMultipleFile(this)">
                        <i class="mdi mdi-close " style="font-size: 29px; color: red; position: absolute; right: -10px; top: -15px;"></i>
                    </a>
                    <div class="form-group has-danger">
                        <label class="control-label">Название файла</label>
                        <textarea class="form-control form-control-danger" name="file_multiple_name_ru[]">{{$item['file_text']}}</textarea>
                        <label class="control-label" style="margin-top: 23px">Отображать</label>
                        <select class="form-control" name="file_multiple_is_show[]">
                            <option @if($item['is_show'] == 1) selected="selected" @endif>Да</option>
                            <option @if($item['is_show'] == 0) selected="selected" @endif>Нет</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

@endif


