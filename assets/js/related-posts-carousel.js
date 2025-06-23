(function($) {
    'use strict';

    // Initialize carousels when Elementor frontend is ready
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/related_posts_carousel.default', ($scope) => {
            const $carousel = $scope.find('.related-posts-carousel');
            const settings = $carousel.data('settings') || {};
            
            if ($carousel.length) {
                const swiper = new Swiper($carousel[0], {
                    slidesPerView: settings.slidesToShow || 3,
                    spaceBetween: 30,
                    loop: true,
                    centeredSlides: true, // Center the active slide
                    autoplay: settings.autoplay ? {
                        delay: settings.autoplaySpeed || 3000,
                        disableOnInteraction: false
                    } : false,
                    pagination: {
                        el: $carousel.find('.swiper-pagination')[0],
                        clickable: true
                    },
                    navigation: {
                        nextEl: $carousel.find('.swiper-button-next')[0],
                        prevEl: $carousel.find('.swiper-button-prev')[0]
                    },
                    breakpoints: {
                        1025: {
                            slidesPerView: settings.slidesToShow || 3
                        },
                        600: {
                            slidesPerView: 2
                        },
                        0: {
                            slidesPerView: 1
                        }
                    },
                    on: {
                        init: function() {
                            updateActiveSlide(this);
                        },
                        slideChange: function() {
                            updateActiveSlide(this);
                        },
                        touchEnd: function() {
                            updateActiveSlide(this);
                        }
                    }
                });

                function updateActiveSlide(swiper) {
                    // Remove active class from all slides
                    $carousel.find('.swiper-slide').removeClass('is-active');
                    
                    // Get the real active slide (accounting for loop)
                    const activeSlide = swiper.slides[swiper.activeIndex];
                    const $activeSlide = $(activeSlide);
                    
                    // Add active class to current slide
                    $activeSlide.addClass('is-active');
                    
                    // Update background if data-bg exists
                    const bgUrl = $activeSlide.data('bg');
                    if (bgUrl) {
                        $('body').css({
                            'background-image': `url(${bgUrl})`,
                            'background-size': 'cover',
                            'background-position': 'center',
                            'background-attachment': 'fixed',
                            'transition': 'all 0.8s ease-out',
                        });
                    }

                    // Update outside fields/buttons
                    if (window.collegeDeptCarouselOutsideFields) {
                        var realIndex = swiper.realIndex || 0;
                        var data = window.collegeDeptCarouselOutsideFields[realIndex] || {fields_html: '', buttons_html: ''};
                        var html = (data.fields_html || '') + (data.buttons_html || '');
                        $('#carousel-outside-fields').html(html);
                    }
                }
            }
        });
    });

})(jQuery); 