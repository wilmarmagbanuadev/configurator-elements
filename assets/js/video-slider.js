jQuery(function($) {
    $(document).ready(function() {
        $(".video-slider").each(function() {
            //controls
            $arrow = ($(this).attr('arrow') === 'true') ? true : false;
            $dots = ($(this).attr('dots') === 'true') ? true : false;
            $infinite = ($(this).attr('infinite') === 'true') ? true : false;
            $autoplay = ($(this).attr('autoplay') === 'true') ? true : false;
            $pauseonhover = ($(this).attr('pauseonhover') === 'true') ? true : false;
            $autoplayspeed = parseInt($(this).attr('autoplayspeed'));
            $slidestoshow = parseInt($(this).attr('slidestoshow'));
            $slidestoscroll = parseInt($(this).attr('slidestoscroll'));

            // tablet
            $slidestoshow_tab = parseInt($(this).attr('tab_slidestoshow'));

            // mobile
            $slidestoshow_mobile = parseInt($(this).attr('mobile_slidestoshow'));


            $("#" + $(this).attr('id')).slick({
                arrows: $arrow,
                dots: $dots,
                infinite: $infinite,
                autoplay: $autoplay,
                pauseOnHover: $pauseonhover,
                autoplaySpeed: $autoplayspeed,
                slidesToShow: $slidestoshow,
                slidesToScroll: $slidestoscroll,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        arrows: false,
                        dots: false,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        fades: true,
                        slidesToShow: $slidestoshow_tab,
                    }
                }, {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        dots: false,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        fades: true,
                        slidesToShow: $slidestoshow_mobile,
                    }
                }, ]
            });

        });
    });
});