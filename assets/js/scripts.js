jQuery(function($){

    $('.pp-logo-default_slider-init').slick({

    arrows: false,
    slidesToShow: 2,
    slidesPerRow: 2,
    rows: 2,
    dots: true,
    autoplay: false,
    responsive: [
        {
        breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesPerRow: 2,
                rows: 2
            }
        },
        {
        breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesPerRow: 3,
                rows: 3
            }
        },
    ]
    });

    $('.pp-logo-three_slider-init').slick({

    arrows: false,
    slidesToShow: 1,
    slidesPerRow: 3,
    rows: 3,
    dots: true,
    autoplay: true,
    responsive: [
        {
        breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesPerRow: 1,
                slidesToShow: 3
            }
        },
        {
            breakpoint: 700,
                settings: {
                    slidesToShow: 1,
                    slidesPerRow: 1,
                    slidesToShow: 2
                }
            },
        {
        breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesPerRow: 1,
                slidesToShow: 1
            }
        }
    ]
    });
});