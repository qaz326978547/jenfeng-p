<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="_token" content="{{ csrf_token() }}" />
	<title>Choice 喬義司 - 設計後台</title>

	<meta name="robots" content="noindex">

    {{-- CSS --}}
	@adminStyle
    @stack('style')

    {{-- JaveScript --}}
	@adminScript
    <script>
        var $i = 0;

        function checkall($id) {
           if($i%2==0)
            $($id).attr("checked","checked");
           else
            $($id).removeAttr("checked");
           $i++;
        };

        function delete_form_confirm($form) {
            event.preventDefault();

            swal({
                title: "確定要刪除嗎?",
                text: "",
                // icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(willDelete) {
                if (willDelete) {
                    return $($form).submit();
                } else {
                    return false;
                }
            });
        }

        // $(function(){
        //  $('input.all,input[name=all]').each(function(){
        //   var click_event =  $(this).attr('onclick');
          
        //   $(this).unbind('click').click(function(){
        //    if( $(this).is(':checked') ){ $i = 0; }
        //    else{ $i = 1; }
        //    eval(click_event);
        //   });
        //  });
        // });

    </script>
    @stack('script')

</head>
<body>
	<div class="row">
		<div id="left">
			<div id="logo">
				<a href="{{ base_path('admin/index') }}">
					<img src="{{ resources_path('images/admin/logo.png') }}" />
				</a>
			</div>

            @adminLeft
	            @slot('title') 帳號管理 @endslot
	            <a href="{{ url('admin/account/upd_pw', ['id' => Session::get('admuser')]) }}"><div>修改後台密碼</div></a>
	            <a href="{{ url('admin/logout') }}"><div>登出後台</div></a>

{{-- 		        <select onchange="location.href = '{{ base_path('admin/index?admin_lang=') }}' + this.value;">
		            <option value="tw" @if(Session::get('admin_lang') == 'tw') selected @endif >繁中</option>
		            <option value="en" @if(Session::get('admin_lang') == 'en') selected @endif >英文</option>
		        </select>  --}}
            @endadminLeft

		@if(config('system.env') == 'local' || Request::query('dev') == 'simple_setting')
{{--             @adminLeft
                @slot('title') 簡易設定 (開發用) @endslot
                <a href="{{ url('admin/simple_setting') }}"><div>管理頁面 {{ BACK_TITLE_CHAR }}</div></a>
            @endadminLeft --}}
		@endif

		@if(config('system.env') == 'local' || Request::query('dev') == 'page')
            @adminLeft
                @slot('title') Page (開發用) @endslot
                <a href="{{ url('admin/page') }}"><div>管理頁面 {{ BACK_TITLE_CHAR }}</div></a>
            @endadminLeft
		@endif


		@if(config('system.env') == 'local' || Request::query('dev') == 'browse')
{{--             @adminLeft
                @slot('title') 瀏覽 @endslot
                <a href="{{ url('admin/browse') }}"><div>管理頁面 {{ BACK_TITLE_CHAR }}</div></a>
                <a href="{{ url('admin/browse/today-data') }}"><div>每日人數 {{ BACK_TITLE_CHAR }}</div></a>
            @endadminLeft --}}
        @endif    

            @adminLeft
                @slot('title') SEO @endslot
                <a href="{{ url('admin/seo_class/0') }}"><div>管理頁面 {{ BACK_TITLE_CHAR }}</div></a>
            @endadminLeft       

            @adminLeft
                @slot('title') GTM @endslot
                <a href="{{ url('admin/page/2') }}"><div>管理頁面 {{ BACK_TITLE_CHAR }}</div></a>
            @endadminLeft   

            @adminLeft
                @slot('title') FAQ @endslot
            	@if(config('faq_class.sys_level') > 1)   
                	<a href="{{ url('admin/faq_class/0') }}"><div>分類管理 {{ BACK_TITLE_CHAR }}</div></a>
                @endif
                <a href="{{ url('admin/faq') }}"><div>管理頁面 {{ BACK_TITLE_CHAR }}</div></a>
            @endadminLeft
 

            @adminLeft
                @slot('title') 課程報名 @endslot
                {{-- <a href="{{ url('admin/simple_setting/upd_line_notify') }}"><div>LINE Notify{{ BACK_TITLE_CHAR }}</div></a> --}}
                <a href="{{ url('admin/contact') }}"><div>報名資料 {{ BACK_TITLE_CHAR }}</div></a>
                <a href="{{ url('admin/contact_class') }}"><div>課程管理 {{ BACK_TITLE_CHAR }}</div></a>
                <a href="{{ url('admin/contact_quest') }}"><div>問題管理 {{ BACK_TITLE_CHAR }}</div></a>
            @endadminLeft

            @adminLeft
                @slot('title') 隱私權政策 @endslot
                <a href="{{ url('admin/page/1') }}"><div>管理頁面 {{ BACK_TITLE_CHAR }}</div></a>
            @endadminLeft

		</div>

		<div id="main">
			@yield('content')
			{{-- 單一刪除用 --}}
			<form id="delete-form" action="" method="POST" style="display: none;">
				@method('delete')
				@csrf
			</form>
		</div>

	</div>
</body>
</html>