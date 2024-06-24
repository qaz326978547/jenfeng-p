<script>
    var base_path = '{{ base_path() }}';
    var resources_path = '{{ resources_path() }}';
</script>
{{-- Javascript 用common載入js 加快讀取速度--}}
<script src="{{ resources_path() }}js/common.js"></script>


<script>
    // mmenu控制
    document.addEventListener(
        "DOMContentLoaded", () => {
            new Mmenu( "#menu", {
                navbar: {
                    title: 'Menu' //手機選單標題選單文字
                },
                navbars: [
                    {
                        'position': 'top',
                        'content': [
                            'prev',
                            'title',
                            'close'
                        ]
                    }
                ],
                "pageScroll": true,
                'extensions': [
                    'theme-dark',
                    'border-full',
                    'pagedim-black',
                ],
            },{
                offCanvas: {
                    clone: true
                },
                pageScroll: {
                    scrollOffset: 65
                }
            });

            var menu = document.querySelector('#mm-menu');
            var menuItem = menu.querySelectorAll('.dropdown-menu , .dropdown-item , .nav-link');
            menu.classList.remove('collapse' , 'navbar-collapse');
            menuItem.forEach(el => el.classList.remove('dropdown-menu','dropdown-item','nav-link'))            
        }
    );
</script>
{{-- 返回 重定向 提示訊息 錯誤訊息、Ajax CSRF、驗證器 --}}
<script type="text/javascript" src="{{ resources_path() }}js/devtool.js"></script>
<script type="text/javascript">
	var base_path = '{{ base_path() }}';

	$(function() {
		$('body').append(@json(View::make('common.includes.alert-box')->render()));

		@if(Session::has('message'))
		alert_box('{!! Session::get('message') !!}');
		@endif

		@if(Session::has('errors'))
		alert_box('{!! join('<br>', Session::get('errors')->all()) !!}');
		@endif
	});

	// 修正fancybox造成的上一頁問題
	$.fancybox.defaults.hash = false;
</script>