@if(isset($row->magazine_pdf) && $row->magazine_pdf != null)
    <div class="image-item" >
        <div class="left-float" style="width: 100%;">
            <a href="{{$row->magazine_pdf}}" target="_blank">
                <img  src="/file.png">
            </a>
        </div>
        <div class="clear-float"></div>
    </div>
@endif

