@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')
	{{-- 基礎 data --}}
	<script>
		var $url = '{{ base_path('admin/'. $config['link_tag']) .'/' }}';
	</script>
@endpush

@section('content')
<main>
    <h3 class="title">{{ $config['page_title'] }}</h3>
    <div class="notice"></div>
    <div class="block list">

    	<a href="{{ url('admin/'. $config['link_tag'] . '/excel', ['action' => 'download_all']) }}?process={{ Request::query('search_process', '') }}&ticket_process={{ Request::query('search_ticket_process', '') }}&s_date={{ Request::query('s_date', '') }}&e_date={{ Request::query('e_date', '') }}" class="button">Excel匯出</a>
    	
        <form method="post" action="{{ url('admin/'. $config['link_tag'] .'/del') }}" id="form1" class="list_form">
            @method('delete')
            @csrf

            <div class="t">
                <ul class="head">
                    <li class="del">選擇全部<input type="checkbox" name="all" value="1" onclick="checkall('.del_d')" /></li>
                    <li class="name">公司名稱</li>
                    <li class="name">公司電話</li>
                    <li>留言日期</li>
                    <li class="upd">修改內容</li>
                </ul>

                @forelse ($data as $value)
                    <ul>
                        <li><input type="checkbox" name="id[]" value="{{ $value['id'] }}" class="del_d" /> </li>
                        <li>{{ $value['company'] }}</li>
                        <li>{{ $value['tel'] }}</li>
                        <li>{{ $value['created_at'] }}</li>
                        <li>
                            <a href="{{ url('admin/'. $config['link_tag'], ['id' => $value['id']]) }}" class="s-button">
                            	<i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:;" class="s-button" onclick="$('#delete-form').attr('action', '{{ url('admin/'. $config['link_tag'], ['id' => $value['id']]) }}'); delete_form_confirm('#delete-form');">
                            	<i class="far fa-trash-alt"></i>
                            </a>
                        </li>
                    </ul>
                @empty
               		<div>暫無任何資料</div>
               	@endforelse

            </div>

            @adminPaginate(['data' => $data])
                <input type="button" name="del" value="刪除資料" class="button" onclick="delete_form_confirm('.list_form');" />
                {{-- <input type="reset" name="reset" value="重新輸入"  class="button" /> --}}
            @endadminPaginate

        </form>
    </div>
</main>
@endsection