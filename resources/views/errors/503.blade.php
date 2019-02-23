@extends('index.layout.layout')

@section('meta-tags')

    <title>Ничего не найдено</title>

@endsection



@section('content')

    <main role="main" class="layout__main">

        <!-- Page Begin -->
        <div class="page">

            <!-- Page Content Begin -->
            <div class="page__content">
                <div class="container">
                    <div class="not-found">

                        <p>Такой страницы не существует...</p>

                        <p>Вы можете воспользоваться Поиском по сайту, чтобы найти то,
                            <br>что вас интересует, либо <a href="/">перейти на главную</a>
                        </p>

                        <img src="/static/img/content/not-found-img.png" alt="" class="not-found__img">

                    </div>
                </div>
            </div>
            <!--/. Page Content Begin -->

        </div>
        <!--./ Page End -->

    </main>

@endsection