const swiper = new Swiper('.recomendation__swiper', {
    // Optional parameters
    loop: true,
    slidesPerView: 3,
    spaceBetween: 15,

    // If we need pagination
    pagination: {
        el: '.recomendation-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.recomendation-button-next',
        prevEl: '.recomendation-button-prev',
    },
    breakpoints: {
        320: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        }
    }
});

const swiper2 = new Swiper('.reviews-slider__swiper', {
    // Optional parameters
    loop: true,
    slidesPerView: 1,
    spaceBetween: 15,

    // If we need pagination
    pagination: {
        el: '.reviews-slider-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.reviews-slider-button-next',
        prevEl: '.reviews-slider-button-prev',
    },
});

const swiper3 = new Swiper('.swiper-card', {
    loop: true,
    slidesPerView: 1,
    navigation: {
        nextEl: '.swiper-card .swiper-button-next',
        prevEl: '.swiper-card .swiper-button-prev',
    }
})

const swiper4 = new Swiper('.swiper-object', {
    loop: true,
    centerSlides: true,
    slidesPerView: "auto",
    spaceBetween: 10,
})

const swiper5 = new Swiper('.swiper-ads', {
    loop: true,
    slidesPerView: 4,
    spaceBetween: 10,
    navigation: {
        nextEl: '.ads-block .swiper-button-next',
        prevEl: '.ads-block .swiper-button-prev',
    },
    pagination: {
        el: '.ads-block .swiper-pagination',
        type: 'fraction',
        formatFractionCurrent: function (number) {
            return '0' + number;
        }
    },
    breakpoints: {
        0: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 3
        },
        1280: {
            slidesPerView: 4
        },
    }
})

const swiper6 = new Swiper('.banner-swiper', {
    loop: true,
    slidesPerView: 1,
    navigation: {
        nextEl: '.banner-slider .swiper-button-next',
        prevEl: '.banner-slider .swiper-button-prev',
    },
    pagination: {
        el: '.banner-slider .swiper-pagination',
    },
})


const swiper7 = new Swiper('.swiper-catalog', {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 15,
    navigation: {
        // nextEl: '.banner-slider .swiper-button-next',
        // prevEl: '.banner-slider .swiper-button-prev',
    },
    breakpoints: {
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 2
        },
        1280: {
            slidesPerView: 4
        },
    }
})

const swiper8 = new Swiper('.swiper-invest', {
    loop: false,
    slidesPerView: 1,
    spaceBetween: 15,
    navigation: {
        // nextEl: '.banner-slider .swiper-button-next',
        // prevEl: '.banner-slider .swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: "auto"
        },
        1280: {
            slidesPerView: 3
        },
    }
})

$(function () {
    $(".mask-phone").mask("+7(999) 999 99 99");
});

$('.question-tabs__head').on('click', function () {
    $(this).next().slideToggle();
})


var sticky = new Sticky('.sticky');
