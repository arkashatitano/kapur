@if(isset($row->document_pdf) && $row->document_pdf != null)
    <div class="image-item" >
        <div class="left-float" style="width: 100%;">
            <a href="{{$row->document_pdf}}" target="_blank">
                <img  src="/file.png">
            </a>
        </div>
        <div class="clear-float"></div>
    </div>
@endif

