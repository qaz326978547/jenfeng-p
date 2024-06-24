@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')

@endpush

@section('content')
<main>
    <h3 class="title">新增帳號</h3>
    <div class="notice"></div>
    <form name="member" method="post" action="" id="pw_form" class="normal_form">
        @csrf
        
	    <div class="block">
	        <div class="form">
	            <ul class="row">
	                <li>
	                    <label>輸入帳號</label>
	                    <div> 
	                        <input type="text" name="account" value="" />
	                    </div>
	                </li>
	            </ul>
	            <ul class="row">
	                <li>
	                    <label>輸入密碼</label>
	                    <div> 
	                        <input type="password" name="password" value="" />
	                    </div>
	                </li>
	            </ul>        
	        </div>         
	    </div>
	    <div class="button">
	        <input type="reset" name="reset" class="button" value="重新輸入" />    
	        <input type="submit" class="button" value="送出資料" />
	    </div>  
	</form>  
</main>
@endsection
