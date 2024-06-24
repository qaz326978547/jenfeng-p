var h = $(window).height();
var w = $(window).width();
var breakPointXL = 1200,
    breakPointLG = 992,
    breakPointMD = 768,
    breakPointSM = 576;
var header = $('header');
var headerH = header.outerHeight();

// fixed header
// var window_width = parseInt( $(window).width() );
// if( window_width < 1200 ){
//     $(window).scroll(function() {
//         var scrollTop = $(window).scrollTop();
//         if (scrollTop > 0) {
//             header.addClass('fixed-top');
//             $('main').css('padding-top' , headerH)
//         } else {
//             header.removeClass('fixed-top');
//             $('main').css('padding-top' , '0')
//         }
//     })
// }else{}



//購物車
$('#shopping-car-btn').click(function() {
    $('#header-cart').addClass('active');
    
});
$('.cart-close-btn').click(function() {
    $('#header-cart').removeClass('active');
});

// svg
jQuery('img.svg').each(function(){   
    var $img = jQuery(this);   
    var imgID = $img.attr('id');   
    var imgClass = $img.attr('class');   
    var imgURL = $img.attr('src');   
  
    jQuery.get(imgURL, function(data) {   
        // Get the SVG tag, ignore the rest   
        var $svg = jQuery(data).find('svg');   
  
        // Add replaced image's ID to the new SVG
        if(typeof imgID !== 'undefined') {   
            $svg = $svg.attr('id', imgID);   
        }   
        // Add replaced image's classes to the new SVG   
        if(typeof imgClass !== 'undefined') {   
            $svg = $svg.attr('class', imgClass+' replaced-svg');   
        }   
  
        // Remove any invalid XML tags as per http://validator.w3.org   
        $svg = $svg.removeAttr('xmlns:a');   
  
        // Check if the viewport is set, if the viewport is not set the SVG wont't scale.   
        if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {   
            $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))   
        }   
  
        // Replace image with new SVG   
        $img.replaceWith($svg);   
  
    }, 'xml');   

});  

//loading

loader();
/*====================================
*     LOADER
======================================*/
function loader(_success) {
    var obj = $('.preloader'),
        inner = $('.preloader_inner');
    var w = 0,
        t = setInterval(function() {
            w = w + 1;
            inner.find('.mesk').css('transform', 'translateX(' + w + '% )');
            if (w === 100) {

                obj.fadeOut(0);
                $('.loader-mesk').addClass('finish');
                clearInterval(t);
                w = 0;
                //loading完載入waypoint
                myWaypoint(90);
                if (_success) {
                    return _success();
                }
            }
        }, 0);
}

function myWaypoint(offsetNum){
    $('.ani').each(function(){
        var thisAnimation = $(this).attr('data-ani');
        var offset;
        var delay = $(this).attr('data-delay');
        var thisOffset = $(this).attr('data-offset');
        if(typeof(thisOffset) == 'undefined') {
            offset = offsetNum;
        } else {
            offset = thisOffset;
        }

        $(this).waypoint(function(){
            $(this.element).addClass('animate__' + thisAnimation + ' animate__animated');
            $(this.element).css({
                '-webkit-animation-delay': delay,
                '-moz-animation-delay': delay,
                'animation-delay': delay,
            });
        } , { offset: offset + '%'})
    })
    
    $('.ani-2').each(function(){
        var offset;
        var thisOffset = $(this).attr('data-offset');
        if(typeof(thisOffset) == 'undefined') {
            offset = offsetNum;
        } else {
            offset = thisOffset;
        }
        $(this).waypoint(function(){
            $(this.element).addClass('animate__animated');
        } , { offset: offset + '%'})
    })
}

$(function() {

    // hamburger
    $('.hamburger').click(function() {
        // $(this).stop().toggleClass('is-active');
        // $('body').toggleClass('active');
        // $('.navbar .collapse').collapse('toggle');
    })

    // 編輯器內的youtube iframe 自適應
    $('.editor').find('iframe').each(function() {
        if ($(this).attr('src').indexOf('yout') >= 0) {
            var thisW = $(this).attr('width');
            $(this).wrap('<div class="embed-responsive embed-responsive-16by9" style="width: 100%; max-width: ' + thisW + 'px;"></div>');
            $(this).addClass('embed-responsive-item');
        }
    })


    // back to top
    $('#back-to-top').click(function() {
        $('body,html').animate({ scrollTop: 0 }, 500);
        return false;
    })

    // back to top icon fixed on footer
    
    


    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        if (scrollTop >= 300) {
            $('header').addClass('active');
        } else {
            $('header').removeClass('active');
        }
    })

    
    // 錨點

    $('a[href*=#]:not([href=#])').click(function() {
        var target = $(this.hash);
        $('html,body').animate({
            scrollTop: target.offset().top - headerH}, 800);
        return false;
    });

    $(window).load(function(){
        if(window.location.hash) {
            $(window).scrollTo($(window.location.hash) , 800, {offset: - headerH});
        }
    });


    $(document).activeNavigation(".navbar-nav");



    



    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {






    } else {



    }


    $(document).mouseup(function(e) {
        var _con = $('.hamburger.is-active , .navbar-collapse.show'); // 设置目标区域
        if (!_con.is(e.target) && _con.has(e.target).length === 0) { // Mark 1
            _con.removeClass('active action is-active show');
        }
    });






});


document.addEventListener("touchstart", function() {}, false);