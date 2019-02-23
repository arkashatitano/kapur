@foreach($document_list as $item)

    <a target="_blank" href="{{$item['document_pdf']}}" class="docs__item">
        <div class="docs__title">{{$item['document_name_'.$lang]}}</div>
        <div class="docs__size">{{$item['document_pdf_size']}} mb</div>
    </a>

@endforeach