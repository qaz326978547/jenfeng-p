<!--Viewport-->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

<!--CSS-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="{{ resources_path() }}js/swiper/css/swiper.min.css">
<link rel="stylesheet" href="{{ resources_path() }}css/fontawesome/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
<link rel="stylesheet" href="{{ resources_path() }}css/bootstrap/bootstrap.css">
<link rel="stylesheet" href="{{ resources_path() }}js/mmenu/mmenu.css">
<link rel="stylesheet" href="{{ resources_path() }}js/mCustomScrollbar/jquery.mCustomScrollbar.css">
<link rel="stylesheet" href="{{ resources_path() }}css/style.css"/>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

<link rel="shortcut icon" href="{{ resources_path() }}_img/favicon.ico" type="image/x-icon" />
<link rel="Bookmark" href="{{ resources_path() }}_img/favicon.ico" type="image/x-icon" />

{{-- CSRF --}}
<meta name="_token" content="{{ csrf_token() }}" />

{!! htmlspecialchars_decode( $pages['gtm'][2]['s_info'] ) !!}
