@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')

@endpush

@section('content')
<main>
    <h3 class="title">更新管理者密碼</h3>
    <div class="notice"></div>
    <form name="member" method="post" action="" id="pw_form" class="normal_form">
    	@method('patch')
        @csrf
        
	    <div class="block">
	        <div class="form">
	            <ul class="row">
	                <li>
	                    <label>輸入新密碼</label>
	                    <div> 
	                        <input type="password" name="password" value="" />
	                    </div>
	                </li>
	            </ul>
	            <ul class="row">
	                <li>
	                    <label>確認新密碼</label>
	                    <div> 
	                        <input type="password" name="confirm" value="" />
	                    </div>
	                </li>
	            </ul>        
	        </div>         
	    </div>
	    <div class="button">
	        <input type="reset" name="reset" class="button" value="重新輸入" />    
	        <input class="button" value="更新密碼" onclick="validate('#pw_form', 'validate.admin_upd_pw.rule', 'validate.admin_upd_pw.rule_message')" />
	    </div>  
	</form>  
</main>
@endsection
