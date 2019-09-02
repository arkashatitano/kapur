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
<script src="/static/js/main.min.js?v=1"></script>
<script src="/static/js/separate-js/scripts.js?v=2"></script>
<script src="/custom/js/custom.js?v=19"></script>


<script>
    @if(isset($error))
        showError('{{$error}}');
    @endif

    @if(isset($_GET['success']) && $_GET['success'] == 1)
        showMessage('Вы успешно купили журнал, на Вашу почту отправлено письмо');
    @endif

    @if(isset($_GET['error-paybox']) && $_GET['error-paybox'] == 1)
        showMessage('Ошибка при покупке');
    @endif

</script>

@yield('js')

</body>
</html>