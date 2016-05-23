jQuery(function($) {
	
    var wow = new WOW({offset:50,mobile:false}); wow.init();

    var isChrome = !!window.chrome && !!window.chrome.webstore;
    if(isChrome==true){
        $('.top a h2').addClass("text-gd");
    }

    if($(window).width()<=991){
        $('body').append('<div class="back-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></div>');
        $(window).scroll(function () {
            if($(this).scrollTop() > 300 ){ 
                $('.back-to-top').fadeIn(); 
            }
            else{
                $('.back-to-top').fadeOut();
            }
        });
        $('.back-to-top').click(function(){
            $("body,html").animate({ scrollTop: 0 }, 800 );
            return false;
        });
    }

    if($('body').find(".slider").length > 0){
        $('.slider').camera({
            height: 'auto',
            loader: 'pie',
            pagination: false,
            thumbnails: false,
            hover: false,
            opacityOnGrid: false,
        });
    }

    $('.feature').owlCarousel({
        loop:true,
        responsive:{
            0:{ items:1 },
            480:{ items:2 },
            991:{ items:2 },
            1199:{items:3 },
            1200:{items:4 },
        },
        margin:20,
        dots:true,
        nav:false,
        autoplay:true,
        autoplayTimeout:10000,
        smartSpeed:1500,
    });

    $('.feature .owl-controls').append('<i class="fa fa-angle-right smooth prev"></i>');
    $('.feature .owl-controls').prepend('<i class="fa fa-angle-left smooth next"></i>');
    $('.owl-controls .next').click(function(){
        $('.feature .owl-next').trigger("click");
    });
    $('.owl-controls .prev').click(function(){
        $('.feature .owl-prev').trigger("click");
    })

    $('.news-list').owlCarousel({
        loop:true,
        items: 1,
        margin:20,
        dots:false,
        nav:true,
        navText:['<i class="fa fa-angle-left smooth"></i>','<i class="fa fa-angle-right smooth"></i>'],
        autoplay:true,
        autoHeight:true,
        autoplayTimeout:8000,
        smartSpeed:1500,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
    });

    $(".fancybox").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'elastic',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
    });

    $(".map").click(function () {
        $(".map iframe").css("pointer-events", "auto");
    });
    $(".map iframe").mouseleave(function() {
        $(".map iframe").css("pointer-events", "none"); 
    });

    CloudZoom.quickStart();
});

    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            events: {
                'onReady': onPlayerReady,
            }
        });
    }
    function onPlayerReady(event) {
        event.target.mute();
    }


$(window).load(function(){
    $('.load').fadeOut(1000);
});