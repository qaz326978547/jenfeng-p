@extends('admin.layout.layout')

@section('content')

<main id="index">
    <h3 class="title">{{ config('system.web_title') }} - 資料總覽</h3>
    <div class="block list">

    	{{-- 2個1排 --}}
    	<ul class="row">
    		<li class="col-6">
        		<div class="data-block">
        			<div class="title">登入IP</div>
        			<div class="inner">        				
        				{{ \Request::ip() }}
        			</div>
        		</div>	
    		</li>
    		<li class="col-6">
        		<div class="data-block">
        			<div class="title">上一次更改密碼</div>
        			<div class="inner">        				
        				{{ date("Y/m/d H:i:s", strtotime($admin['updated_at'] ?? '')) }}

    				@if( strtotime($admin['updated_at'] ?? '') < strtotime("-3 month") )        				
        				<i class="fas fa-user-secret"></i> <i><a href="{{ url('admin/account/upd_pw', ['id' => \Session::get('admuser')]) }}">更改密碼</a></i>
    				@endif

        			</div>
        		</div>	
    		</li>
    	</ul>

    	<hr/>

    	{{-- 2個1排 --}}
    	<ul class="row">
    		<li class="col-6">
        		<div class="data-block">
        			<div class="title">累計瀏覽人數</div>
        			<div class="inner">        				
        				共 <i>{{ $browse_record['all'] ?? 0 }}</i> 人
        			</div>
        		</div>	
    		</li>
    		<li class="col-6">
        		<div class="data-block">
        			<div class="title">今日瀏覽人數</div>
        			<div class="inner">        				
        				共 <i>{{ $browse_record['today'] ?? 0 }}</i> 人
        			</div>
        		</div>	
    		</li>
    	</ul>

    	<hr/>

    	{{-- 4個1排 --}}
    	<div class="block-title">
    		<i class="fas fa-align-right"></i> 資料筆數
    	</div>	

    	<ul class="row">
    		<li class="col-3">
        		<div class="data-block">
        			<div class="title">編輯器圖檔筆數</div>
        			<div class="inner">        				
        				共 <i>{{ $editor_pic }}</i> 張圖檔
        			</div>
        		</div>	
    		</li>    		

    	@foreach ($count_data as $element)
    		<li class="col-3">
        		<div class="data-block">
        			<div class="title">{{ $element['title'] }}</div>
        			<div class="inner">        				
        				共 <i>{{ $element['num'] }}</i> 筆
        			</div>
        		</div>	
    		</li>
    	@endforeach

    	</ul>

    	<hr/>

    	{{-- 3個1排 --}}    	
{{--     	<div class="block-title">
    		<i class="fas fa-align-right"></i> 訂單筆數
    	</div>	

    	<ul class="row">    	

    	@foreach ($order_count_data as $element)
    		<li class="col-4">
        		<div class="data-block">
        			<div class="title">{{ $element['title'] }}</div>
        			<div class="inner">        				
        				共 <i>{{ $element['num'] }}</i> 筆
        			</div>
        		</div>	
    		</li>
		@endforeach	

    	</ul> --}}

    </div>
</main>

@endsection