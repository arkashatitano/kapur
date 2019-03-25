<!doctype html>
<html class="no-js" lang="ru">

@include('index.layout.app')

<body>

<div class="layout">
    <div class="layout__wrapper">
    
    @include('index.layout.header')
    
    @yield('content')
    
    @include('index.layout.footer')

    </div>
</div>



<script src="/custom/js/jquery.js"></script>
<script src="/static/js/main.min.js"></script>
<script src="/static/js/separate-js/scripts.js"></script>
<script src="/custom/js/custom.js?v=18"></script>


<script>
    @if(isset($error))
        showError('{{$error}}');
    @endif
</script>

@yield('js')

</body>
</html>