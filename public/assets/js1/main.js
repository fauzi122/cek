/* -------------------------------------------------------------------
 * Template Name         : Applyou - Landing Page Template
 * Theme Author Name     : Yucel Yilmaz
 * Created Date          : 28 January 2020
 * Version               : 1.0
------------------------------------------------------------------- */

/*------------------------------------------------------------------
[Table of contents]

1.Navbar Fixed
2.Navbar Scroll Spy
3.Counters
4.Owl Carousel
5.Magnific Popup
6.Pricing Tab
7.Copyright
8.Contact Form
09.ScrollIt
10.Ripples Effect
11.Glitch Effect
------------------------------------------------------------------- */

$(document).ready(function() {
    "use strict";

    // Call all ready functions
    applyou_preloader(),
    applyou_navbarFixed(),
    applyou_navScrollSpy(),
    applyou_counterUp(),
    applyou_magnificPopupVideo(),
    applyou_owl_carousel(),
    applyou_pricingTab(),
    applyou_copyrightDynamicYear(),
    applyou_contactForm(),
    applyou_scrollIt(),
    applyou_ripplesEffect(),
    applyou_glitchEffect(),
    new WOW().init();
});


/*  ---------------------------------------------------
    Preloader
    --------------------------------------------------- */
function applyou_preloader() {
    "use-strict";

    // Variables
    var preloaderWrap           = $('.preloader-wrap'),
        loaderInner             = $('.preloader-wrap .preloader-inner');

    $(window).ready(function(){
        loaderInner.fadeOut(); 
        preloaderWrap.delay(500).fadeOut('slow');
    });   
}

/*  ---------------------------------------------------
    1.Navbar Fixed
    --------------------------------------------------- */

function applyou_navbarFixed() {
    "use-strict";
    
    // Variables
    let header              = $('.header'),
        logoTransparent     = $(".logo-transparent"),
        scrollTopBtn        = $(".scroll-top-btn"),
        logoNormal          = $(".logo-normal"),
        windowWidth         = $(window).innerWidth(),
        scrollTop           = $(window).scrollTop(),
        $dropdown           = $(".dropdown"),
        $dropdownToggle     = $(".dropdown-toggle"),
        $dropdownMenu       = $(".dropdown-menu"),
        showClass           = "show";

    // When Window On Scroll
    $(window).on('scroll',function(){
        let scrollTop       = $(this).scrollTop();

        if(scrollTop > 100 ) {
            header.addClass('header-shrink');
            scrollTopBtn.addClass('active');
            logoTransparent.hide();
            logoNormal.show();
        }else {
            header.removeClass('header-shrink');
            scrollTopBtn.removeClass('active');
            logoTransparent.show();
            logoNormal.hide();
        }
    });

    // The same process is done without page scroll to prevent errors.
    if(scrollTop > 100 ) {
        header.addClass('header-shrink');
        scrollTopBtn.addClass('active');
        logoTransparent.hide();
        logoNormal.show();
    }else {
        header.removeClass('header-shrink');
        scrollTopBtn.removeClass('active');
        logoTransparent.show();
        logoNormal.hide();
    }

    // Window On Resize Hover Dropdown
    $(window).on("resize", function() {
        let windowWidth  = $(this).innerWidth();

        if ( windowWidth > 991 ) {
            $dropdown.hover(
                function() {
                    let hasShowClass  =  $(this).hasClass(showClass);
                    if( hasShowClass!==true ){
                        $(this).addClass(showClass);
                        $(this).find($dropdownToggle).attr("aria-expanded", "true");
                        $(this).find($dropdownMenu).addClass(showClass);
                    }
                },
                function() {
                    $(this).removeClass(showClass);
                    $(this).find($dropdownToggle).attr("aria-expanded", "false");
                    $(this).find($dropdownMenu).removeClass(showClass);
                }
            );
        }else {
            $dropdown.off("mouseenter mouseleave");
            header.find('.main-menu').collapse('hide');
        }
    });
    // The same process is done without page scroll to prevent errors.
    if (windowWidth > 991 ) {
        $dropdown.hover(
            function() {
                const $this = $(this);

                var hasShowClass  = $this.hasClass(showClass);

                if(hasShowClass!==true){
                    $this.addClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "true");
                    $this.find($dropdownMenu).addClass(showClass);
                }
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
        );
    }else {
        $dropdown.off("mouseenter mouseleave");
    }

    header.find('.menu-link').on("click",function(){
        header.find('.main-menu').collapse('hide');
    });
}

/*  ---------------------------------------------------
    2.Navbar Scroll Spy
    --------------------------------------------------- */
function applyou_navScrollSpy() {
    "use-strict";

    // Scroll Spy
    $('body').scrollspy({
        target: '#fixedNavbar',
        offset: 95
    });
}

/*  ---------------------------------------------------
    3.Counters
    --------------------------------------------------- */
function applyou_counterUp() {
    "use-strict";

    $('.counter').counterUp({
        delay: 15,
        time: 2000
    });
}

/*  -----------------------------------------------------
    4.Owl Carousel
    ----------------------------------------------------- */ 
function applyou_owl_carousel() {
    "use-strict";

    // Variables 
    var testimonialSlider        =  $('.testimonial-slider'),
        screenshotsSlider        =  $('.screenshots-slider');

    // Partners Slider
    screenshotsSlider.owlCarousel({
        loop:true,
        margin:30,
        nav:true,
        dots:false,
        center:true,
        stagePadding:0,
        smartSpeed:1000,
        animateOut: 'fadeOut',
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        navText: ["<span class='fa fa-angle-left'></span>","<span class='fa fa-angle-right'></span>"],
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3
            },
            768:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });

    // Testimonial Slider
    testimonialSlider.owlCarousel({
        loop:true,
        margin:30,
        nav:false,
        dots:true,
        stagePadding:0,
        smartSpeed:1000,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            768:{
                items:1
            },
            992:{
                items:1
            }
        }
    });
}

/*  -----------------------------------------------------
    5.Magnific Popup
    ----------------------------------------------------- */ 
function applyou_magnificPopupVideo() {
    "use-strict";

    // Variables
    var videoPopupItem  = $('.popup-youtube, .popup-vimeo, .popup-gmaps');

    videoPopupItem.magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
    });
}

/*  -----------------------------------------------------
    6.Pricing Tab
    ----------------------------------------------------- */ 
function applyou_pricingTab(){
    "use-scrict";

    // Variables
    var pricingTabLink       = $('.price-toggle-wrap > a'),
        pricingTabContent    = $('.pricing-tab-content');

    pricingTabLink.on("click",function(){
        pricingTabLink.removeClass('active');
        $(this).addClass('active');
        pricingTabContent.removeClass('active');
        pricingTabContent.eq($(this).index()).addClass("active animated fadeInUp");
    });
}

/*  -----------------------------------------------------
    7.Copyright
    ----------------------------------------------------- */ 
function applyou_copyrightDynamicYear() {
    "use-strict";

    // Variables
    var fullYearCopyright       = $('#fullYearCopyright'),
        getFullYearDate         = new Date().getFullYear();

    fullYearCopyright.text(getFullYearDate);
}   

/*  -----------------------------------------------------
    8.Contact Form
    ----------------------------------------------------- */ 
function applyou_contactForm() {
    "use-strict";

    // Added AutoComplete Attribute Turned Off
    $('.form-control').attr("autocomplete","off");

    $("#contactForm").on("submit",function(event) {

        // E-Mail Validation Function 
        function validateEmail(email) {
            var regexp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return regexp.test(String(email).toLowerCase());
        }

        //  Variables 
        var $this           = $(this),
            name            = $("#contactName").val().trim(),
            email           = $("#contactEmail").val().trim(),
            subject         = $("#contactSubject").val().trim(),
            message         = $("#contactMessage").val().trim(),
            validateEmail   = validateEmail(email);

        // Check empty fields
        if(name===''||email===''||message===''||subject===''){
            if($('div.empty-form').css("display") == "none"){
                $('div.empty-form').stop().slideDown(500).delay(3000).slideUp(500);
            }else {
                return false;
            }
        }else if (!validateEmail===true) {
            if($('div.email-invalid').css("display") == "none"){
                $('div.email-invalid').stop().slideDown(500).delay(3000).slideUp(500);
            }else {
                return false;
            }
        }else {
            // Once the information entered is verified, the mail form is sent. 
            $this.find(':submit').append('<span class="fas fa-spinner fa-pulse ml-3"></span>');
            $("#contactForm").find(':submit').attr('disabled','true');

            $.ajax({
                url: "vendor/send_mail.php?mail=request",
                data: {
                    contact_name:name,
                    contact_email:email,
                    contact_subject:subject,
                    contact_message:message
                },
                type: "POST",
                success: function(response) {
                    $this.find(':submit').find("span").fadeOut();
                    $("#contactForm")[0].reset();   
                    $("#contactForm").find(':submit').removeAttr('disabled');
                    $(".success-form").html(response).slideDown(500).delay(5000).slideUp(500);  
                }
            });
        }
        event.preventDefault();
    });
}    

/*  -----------------------------------------------------
    09.ScrollIt
    ----------------------------------------------------- */ 
function applyou_scrollIt() {
    "use-strict";
     
    $.scrollIt({
        upKey: 38,
        downKey: 40,
        easing: "swing",
        scrollTime: 600,
        activeClass: "active",
        onPageChange: null,
        topOffset: -15
    });
}

/*  -----------------------------------------------------
    10.Ripples Effect
    ----------------------------------------------------- */ 
function applyou_ripplesEffect() {

    "use-strict";
    
    $('.hero-ripless-banner').ripples({
        resolution: 500,
        dropRadius: 20,
        perturbance: 0.04
    });
}

/*  -----------------------------------------------------
    11.Glitch Effect
    ----------------------------------------------------- */ 
function applyou_glitchEffect() {

    "use-strict";
    
    $(".glitch-img").mgGlitch();
}
