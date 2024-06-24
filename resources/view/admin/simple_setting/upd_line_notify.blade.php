@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')

@endpush

@section('content')
<main>
    <h3 class="title">設定 - LINE Notify</h3>
    <div class="notice"></div>
    <form name="member" method="post" action="{{ url('admin/simple_setting', ['id' => 1]) }}" id="edit_form" class="normal_form">
    	@method('patch')
        @csrf
        
	    <div class="block">
	        <div class="form">

                @adminRow
                    @slot('title') Token @endslot
                    <input type="text" name="line_notify_token" value="{{ $data['line_notify_token'] ?? '' }}" size="50" />
                @endadminRow

	        </div>         
	    </div>
	    <div class="button">
	        <input class="button" value="更新資料" onclick="validate('#edit_form', 'simple_setting.rule', 'simple_setting.rule_message')" />
	        <input type="reset" name="reset" class="button" value="重新輸入" />    	        
	    </div>  
	</form>  
</main>
@endsection
