@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$menu['menu_meta_title_'.$lang]}}</title>
    <meta name="description" content="{{$menu['menu_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$menu['menu_meta_keywords_'.$lang]}}"/>

@endsection


@section('content')

    <main role="main" class="layout__main">
        <div class="page">
            <section class="container">
                <ul class="breadcrumbs">
                    <li class="breadcrumbs__item -back">
                        <a href="/" class="breadcrumbs__link">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 11.0001H7.83L13.42 5.41006L12 4.00006L4 12.0001L12 20.0001L13.41 18.5901L7.83 13.0001H20V11.0001Z" fill="#218F44" />
                            </svg>
                            Назад
                        </a>
                    </li>

                    <li class="breadcrumbs__item">
                        <a href="/" class="breadcrumbs__link">{{Lang::get('app.homepage')}}</a>
                    </li>
                    <li class="breadcrumbs__item -active">{{$menu['menu_name_'.$lang]}}</li>
                </ul>

                <article class="article">
                    <header class="article__header">
                        <h1 class="article__title">{{$menu['menu_name_'.$lang]}}</h1>
                    </header>
                    <div class="article__body">
                        <div class="row" data-gutter="50">
                            <div class="col-lg-6">
                                {!! $menu['menu_text_'.$lang] !!}
                            </div>
                            <div class="col-lg-6 order-lg-first">
                                <div id="jsYandexMap" class="article__map"></div>
                            </div>
                        </div>
                    </div>
                </article>

            </section>


        </div>
    </main>



@endsection

@section('js')

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(init);
        var yandexMap;

        function init() {

            // Карта Алматы
            yandexMap = new ymaps.Map("jsYandexMap", {
                center: [{{\App\Http\Helpers::getInfoText(21)}}], // Координаты объекта
                zoom: 15, // Маштаб карты
                controls: [] // Отключаем элементы управления.
            });

            // Добавим на карту ползунок масштаба и линейку.
            yandexMap.controls.add(
                    new ymaps.control.ZoomControl()
            );

            // Отключаем zoom на скролле мыши
            yandexMap.behaviors.disable('scrollZoom');

            yandexPlacemark = new ymaps.Placemark([{{\App\Http\Helpers::getInfoText(21)}}], { // Координаты метки объекта
                balloonContent: "Капур" // Надпись метки
            }, {
                iconLayout: 'default#image',

                // Своё изображение иконки метки
                iconImageHref: "static/img/general/ic-map-marker.svg",

                // Размер мкетки
                iconImageSize: [80, 90],

                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-40, -45]
            });

            yandexMap.geoObjects.add(yandexPlacemark);
            //myPlacemark.balloon.open();
        }
    </script>

@endsection