<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta http-equiv="Content-Language" content="zh-TW" />
    <meta charset="UTF-8">
	@if(\Str::contains(Request::header('host'), 'choice'))  
		<meta name="robots" content="noindex, nofollow"> 
	@endif

    @if($seo == false)
    	<title>{{ config('system.web_title') }}</title>
    @endif

	@if($seo == true)
    	<title>{{ $seo_title }}</title>

	    <meta name="description" content="{{ $seo_description }}">
		<meta name="keyword" content="{{ $seo_keyword }}">

	    <meta property="og:title" content="{{ $seo_title }}" />
	    <meta property="og:description" content="{{ $seo_description }}" />
	    <meta property="og:locale" content="zh_TW" />
	    <meta property="og:type" content="{{ $seo_type }}" />
		<meta property="og:image" content="{{ !empty($seo_image) ? $seo_image : host_path(resources_path('_img/layout/logo.png')) }}" />
	   
	    {{-- <meta property="og:site_name" content="{{ config('system.web_title') }}" /> --}}

	    <link rel="canonical" href="{{ \Request::fullUrl() }}" />
	    <meta property="og:url" content="{{ \Request::fullUrl() }}" />  
    @endif
    @include('web.includes.head')
    @stack('head')

</head>

<body class="bg" id="{{ $main_id }}">

{!! htmlspecialchars_decode( $pages['gtm'][2]['info'] ) !!}

<div class="loader-mesk"></div>
<div class="preloader">
	<div class="preloader_inner">
		<img src="{{ resources_path() }}_img/layout/loader-logo.svg" alt="">
		<div class="mesk"></div>
	</div>
</div>

<div class="template">
<!--header-->
@include('web.includes.header')
<!-- End header -->

<main>
@yield('main')
</main>

<!-- footer -->
@include('web.includes.footer')
<!-- End footer -->

</div>

@include('web.includes.script')
@stack('script')
</body>

</html>