//'use strict';

$(function() {

    /*
    |--------------------------------------------------------------------------
    | Responsive iframe inside bootstrap modal
    |--------------------------------------------------------------------------
    */

    /*let iframeModal = document.getElementById('iframe-modal');
    let iframeModalItem = iframeModal.querySelector('.jsBmEmbedItem');

    document.addEventListener('click', function(e){
        if(e.target.classList.contains('jsBmButton')){
            let dataVideo = {
                'src': e.target.getAttribute('data-bmSrc'),
                //'height': e.target.getAttribute('data-bmHeight'),
                //'width': e.target.getAttribute('data-bmWidth')
            };

            for(let key in dataVideo){
                iframeModalItem.setAttribute(key, dataVideo[key]);
            };

            $('#iframe-modal').on('hidden.bs.modal', function(){
                iframeModalItem.innerHTML = '';
                iframeModalItem.setAttribute("src", "");
            });
        }
    });*/

    /*
    |--------------------------------------------------------------------------
    | Sticky Header
    |--------------------------------------------------------------------------
    */

    var stickyDiv = document.querySelectorAll('.sticky');

    function positionCalculation(index){
        var posTop = 0;
        for(var i = index; i > -1; i--){
            posTop += stickyDiv[i].getBoundingClientRect().height;
        }
        return posTop;
    }

    function neighborHeight(i){
        if(i > 0){
            return stickyDiv[i-1].getBoundingClientRect().top + stickyDiv[i-1].getBoundingClientRect().height;
        }
        return 0;
    }

    function positionDetermination(){
        for(var i = 0; i < stickyDiv.length; i++){
            if(stickyDiv[i].getBoundingClientRect().top + window.pageYOffset  <= window.pageYOffset + neighborHeight(i)){
                if(!stickyDiv[i].spacer){
                    stickyDiv[i].spacer = document.createElement('div');
                    stickyDiv[i].spacer.style.position = 'static';
                    stickyDiv[i].spacer.style.width = stickyDiv[i].getBoundingClientRect().width + 'px';
                    stickyDiv[i].spacer.style.height = stickyDiv[i].getBoundingClientRect().height + 'px';
                    stickyDiv[i].spacer.style.display = 'block';
                    stickyDiv[i].spacer.style.verticalAlign = 'baseline';
                    stickyDiv[i].spacer.style.float = 'none';

                    stickyDiv[i].parentNode.insertBefore(stickyDiv[i].spacer, stickyDiv[i]);
                }

                stickyDiv[i].classList.add(stickyDiv[i].dataset.classFixed);
                if(i > 0){
                    stickyDiv[i].style.top =  positionCalculation(i-1) + 'px';
                }

                if(stickyDiv[i].getBoundingClientRect().top <= stickyDiv[i].spacer.getBoundingClientRect().top){
                    stickyDiv[i].parentNode.removeChild(stickyDiv[i].spacer);
                    stickyDiv[i].classList.remove(stickyDiv[i].dataset.classFixed);
                    stickyDiv[i].spacer = null;
                }
            }
        };
    };

    /*
    |--------------------------------------------------------------------------
    | Spoiler Text
    |--------------------------------------------------------------------------
    */

    let containerHeight = document.querySelectorAll(".jsSpoilerInner");
    let uncoverLink = document.querySelectorAll(".jsSpoilerMore");

    for(let i = 0; i < containerHeight.length; i++){
        let openData = uncoverLink[i].dataset.open;
        let closeData = uncoverLink[i].dataset.close;
        let curHeight = containerHeight[i].dataset.height;

        uncoverLink[i].innerHTML = openData;
        containerHeight[i].style.maxHeight = curHeight + "px";

        uncoverLink[i].addEventListener("click", function(){
            if(containerHeight[i].classList.contains("-open")){

                containerHeight[i].classList.remove("-open");

                uncoverLink[i].innerHTML = openData;

                containerHeight[i].style.maxHeight = curHeight + "px";

            } else {
                containerHeight[i].removeAttribute("style");

                containerHeight[i].classList.add("-open");

                uncoverLink[i].innerHTML = closeData;

            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Entry Slider
    |--------------------------------------------------------------------------
    */

    var swiperOptions = {
        speed: 600,
        autoHeight: true, //enable auto height
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        mousewheel: false,
        spaceBetween: 0,
        navigation: {
            nextEl: '.jsEntryNext',
            prevEl: '.jsEntryPrev',
        },
        pagination: {
            el: '.jsEntryPagination',
        },
        slidesPerView: 1,
    };

    var imgSlider = new Swiper(".jsImgSlider", swiperOptions);

	var entrySlider = new Swiper('.jsEntrySlider', swiperOptions);

    if (entrySlider.length > 0 ) {
        entrySlider.controller.control = imgSlider;
    }

    if (imgSlider.length > 0 ) {
        imgSlider.controller.control = entrySlider;
    }

    /*
    |--------------------------------------------------------------------------
    | Partners Slider
    |--------------------------------------------------------------------------
    */

    let parnersSlider = new Swiper('.jsPartnersSlider', {
        speed: 600,
        autoHeight: true, //enable auto height
        mousewheel: false,
        spaceBetween: 15,
        navigation: {
            nextEl: '.jsPartnersNext',
            prevEl: '.jsPartnersPrev',
        },
        slidesPerView: 4,
        breakpoints: {
            1024: {
                slidesPerView: 4,
            },
            768: {
                slidesPerView: 3,
            },
            640: {
                slidesPerView: 2,
            },
            320: {
                slidesPerView: 2,
            }
        }
    });

    let parnersSlider2 = new Swiper('.jsPartnersSlider2', {
        speed: 600,
        autoHeight: true, //enable auto height
        mousewheel: false,
        spaceBetween: 15,
        navigation: {
            nextEl: '.jsPartnersNext2',
            prevEl: '.jsPartnersPrev2',
        },
        slidesPerView: 4,
        breakpoints: {
            1024: {
                slidesPerView: 4,
            },
            768: {
                slidesPerView: 3,
            },
            640: {
                slidesPerView: 2,
            },
            320: {
                slidesPerView: 2,
            }
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Light Gallery
    |--------------------------------------------------------------------------
    */

	$('.lg').lightGallery({
		selector: ".lg__item",
	});

    /*
    |--------------------------------------------------------------------------
    | Polyfill object-fit/object-position on <img>: IE9, IE10, IE11, Edge, Safari, ...
    | https://github.com/bfred-it/object-fit-images
    |--------------------------------------------------------------------------
    */

    objectFitImages();
    // if you use jQuery, the code is: $(function () { objectFitImages() });

    /*
    |--------------------------------------------------------------------------
    | Main Menu
    |--------------------------------------------------------------------------
    */

    $('#collapse-menu').on('click', function(e) {
        $('body').toggleClass('opened-menu');
        $('.main-menu').toggleClass('clicked');
    });

});
