@if(isset($image) && $image != null)
    @foreach($image as $key => $val)

        <div class="image-item" >
            <input type="hidden" value="{{$val['image_url']}}" name="image_list[]">
            <a href="javascript:void(0)" onclick="confirmDeleteImage(this)">
                <i class="fa fa-times" style="font-size: 20px; margin-left: 10px; color: red; position: absolute; margin-left: -30px"></i>
            </a>
            <div class="left-float" style="width: 100%;">
                <a href="{{ $val['image_url'] }}" class="fancybox">
                    <img  src="{{ $val['image_url'] }}">
                </a>
            </div>
            <div class="clear-float"></div>
        </div>

    @endforeach
@endif

@if(isset($is_ajax))
    <script type="text/javascript">
        $('a.fancybox').fancybox({
            padding: 10
        });
    </script>
@endif