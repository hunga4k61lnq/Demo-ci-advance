jQuery(function($) {
	
    var wow = new WOW({offset:50,mobile:false}); wow.init();

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

    $(".map").click(function () {
        $(".map iframe").css("pointer-events", "auto");
    });
    $(".map iframe").mouseleave(function() {
        $(".map iframe").css("pointer-events", "none"); 
    });

    if($('body').find(".slider").length > 0){
        $('.slider').camera({
            height: '30%',
            minHeight: '200px',
            loader: 'pie',
            pagination: false,
            thumbnails: false,
            hover: false,
            opacityOnGrid: false,
        });
    }

    $('.category li').each(function(){
        if($(this).find('ul > li').length>0){
            $(this).prepend('<span class="smooth"></span>');
        }
    });


    $('.category li span').click(function(){
        if($(window).width()<=991){
            var ul = $(this).nextAll('ul');
            if(ul.is(":hidden")){
                $(this).addClass('mn-d');
                ul.slideDown();
            }
            else{
                $(this).removeClass('mn-d');
                ul.slideUp();
            }
        }
    });

    $('.category button').click(function(){
        if($('.category').hasClass('tran')){
            $(this).children('i').removeClass('fa-caret-left').addClass('fa-caret-right');
            $('.category').removeClass('tran');
            return false;
        }
        else{
            $(this).children('i').removeClass('fa-caret-right').addClass('fa-caret-left');
            $('.category').addClass('tran');
            return false;
        }
    })

    CloudZoom.quickStart();

    $('.single-pro-tab a[href^="#"]').click(function() {      
        $('.single-pro-tab a').removeClass("active");
        $('html,body').animate({ scrollTop: $(this.hash).offset().top - 50}, 800);  
        $(this).addClass('active');
        // if($('.primary-menu').hasClass('mo')){
        //     $('.primary-menu ul').slideUp();
        //     $('.primary-menu button i').removeClass('fa-times').addClass('fa-bars');
        // }
        return false;
    });
    $(window).scroll(function () {
        $('.single-ptab-ct section').each(function() {
            if($(window).scrollTop() + ($(window).height()/2) >= $(this).offset().top){
                var id = $(this).attr('id'); 
                $('.single-pro-tab a').each(function() {
                    if('#'+id == $(this).attr('href')){
                        $('.single-pro-tab a').removeClass("active");
                        $(this).addClass("active");
                    }
                });
            }
        });
    });

    if($('body').find('.single-pro-tab').length>0){
        var hi= $('.single-pro-tab').offset().top;
    }
    $(window).scroll(function () {      
        if($(this).scrollTop() >= hi ){ 
            $('.single-pro-content').addClass('fix'); 
        }
        else{
            $('.single-pro-content').removeClass('fix'); 
        }
    });

    $('.list-related').owlCarousel({
        loop:true,
        responsive:{
            0:{ items:1 },
            480:{ items:2 },
            768:{ items:3 },
            992:{items:4 },
        },
        margin:30,
        dots:false,
        nav:true,
        navText:['<i class="fa fa-angle-left smooth" aria-hidden="true"></i>','<i class="fa fa-angle-right smooth" aria-hidden="true"></i>'],
        autoplay:true,
        autoplayTimeout:8000,
        smartSpeed:1500,
    });

});
