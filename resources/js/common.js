// jquery
document.write('<script src="' + resources_path + 'js/jquery.js"></script>');
// activeNavigation
document.write('<script src="' + resources_path + 'js/jquery.activeNavigation.js"></script>');


// swiper
var hasSwiper = document.querySelectorAll('.swiper-container');

if (hasSwiper.length > 0) {
    document.write('<script src="' + resources_path + 'js/swiper/js/swiper.min.js"></script>');
    document.write('<script src="' + resources_path + 'js/swiper/js/swiper.animate1.0.3.min.js"></script>');
}

// fancybox
var hasFancybox = document.querySelectorAll('[data-fancybox]');
if (hasFancybox.length > 0) {
    document.write('<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>');
}

// clicker_box
document.write('<script src="' + resources_path + 'js/clicker_box.js"></script>');
// scrollTo
document.write('<script src="' + resources_path + 'js/jquery.scrollTo.min.js"></script>');
// waypoint
document.write('<script src="' + resources_path + 'js/waypoint/jquery.waypoints.min.js"></script>');
// mmenu
document.write('<script src="' + resources_path + 'js/mmenu/mmenu.polyfills.js"></script>');
document.write('<script src="' + resources_path + 'js/mmenu/mmenu.js"></script>');
//mCustomScrollbar
document.write('<script src="' + resources_path + 'js/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>');

// ez-plus
document.write('<script src="' + resources_path + 'js/jquery.ez-plus.js"></script>');

// bootstrap
document.write('<script src="' + resources_path + 'js/bootstrap.min.js"></script>');

// custom
document.write('<script src="' + resources_path + 'js/script.js"></script>');

