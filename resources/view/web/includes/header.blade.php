{{-- 選單 --}}
<header class="navbar navbar-expand-md">
	<div class="container position-relative">
		<div class="w-100 d-flex align-items-center justify-content-between">
			<a href="#menu" class="navbar-toggler hamburger hamburger--collapse">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</a>
			<div class="collapse navbar-collapse" id="menu">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="{{ base_path() }}#activities" title="活動內容"><span>活動內容</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ base_path() }}#faq" title="F&Q"><span>F&Q</span></a
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ base_path() }}#register" title="立即報名"><span>立即報名</span></a>
					</li>
					<li class="nav-item left-button">
						<a class="nav-link d-flex align-items-center"  data-src="#privacy" title="隱私政策" data-fancybox="" data-animation-duration="600" href="javascript:;" title="隱私政策"><span>隱私政策</span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>

<div id="privacy" class="light-box">
	<div class="fs-30 fw-600 text-center">隱私權保護政策</div>
	<div class="line"></div>
	<div class="editor">
		{!! htmlspecialchars_decode($pages['privacy'][1]['info']) !!}
	</div>
</div>



