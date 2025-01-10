$(document).ready(function(){
    //owl carousel
    $('.owl-carousel').owlCarousel({
        loop: false,
        margin: 10,
        nav: false,
        stagePadding: 50,
        dots: false,
        responsive:{
            0:{
                items:1
            },
            768:{
                items:2
            },
            1024:{
                items:3
            },
            1440:{
                items:5
            }
        }
    });

    //form resubmit protection
    $(".submit-form").submit(function (){
        $(".submit-btn").attr("disabled", true);
    });

    //TomSelect
    var settings = {};
    new TomSelect('#city_id', settings);

    //navScroll
    $("a[href^='#highlights'], a[href^='#sales'], a[href^='#accessories'],a[href^='#packs'], a[href^='#consoles'], a[href^='#wanteds'], a[href^='#games'], a[href^='#series']").click(function(e) {
        e.preventDefault();

        var position = $($(this).attr("href")).offset().top-90;

        $("body, html").animate({
            scrollTop: position
        }, 10 );
    });

    //message scroll
    /* $(document).ready(function(){
        var position = $('#newMessage').offset().top-570;

        $("body, html").animate({
            scrollTop: position
        }, 10 );
    }); */
});
 