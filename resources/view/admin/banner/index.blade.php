@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')
	{{-- 基礎 data --}}
	<script>
		var $url = '{{ base_path('admin/'. $config['link_tag']) .'/' }}';
	</script>
	{{-- 更新上架 排序 --}}
	<script type="text/javascript" src="{{ resources_path('ajax/admin/'. $config['folder'] .'/upd.js') }}"></script>
@endpush

@section('content')
<main>
    <h3 class="title">{{ $config['page_title'] }}</h3>
    <div class="notice"></div>
    <div class="block list">
        <a href="{{ url('admin/'. $config['link_tag'], ['id' => 0]) }}" class="button"> 在此新增 </a>

        @if($config['num_limit'] > 0)
        	最多能上傳<span class="red"> {{ $config['num_limit'] }} </span>張圖片
        @endif

        <form method="post" action="{{ url('admin/'. $config['link_tag'] .'/del') }}" id="form1" class="list_form">
        	@method('delete')
            @csrf

            <div class="t">
                <ul class="head">
                    <li class="del">選擇全部<input type="checkbox" name="all" value="1" onclick="checkall('.del_d')" /></li>
                    <li class="name">標題</li>
                    <li>圖片</li>
                    <li>連結</li>
                    <li class="no">排序</li>
                    <li class="act">上架</li>
                    <li class="upd">修改內容</li>
                </ul>

                @forelse ($data as $value)
                    <ul>
                        <li><input type="checkbox" name="id[]" value="{{ $value['id'] }}" class="del_d" /> </li>
                        <li>{{ $value['name'] }}</li>
                        <li><img src="{{ storage_path($value['pic']) }}" /></li>
                        <li>{{ $value['link'] }}</li>
                        <li>
                        	<input type='text' name='no' value="{{ $value['no'] }}" size="3"
        		            onblur="ajax_upd({{ $value['id'] }}, 'no', this.value)"/>
                        </li>
                        <li class="act">
                            <input type="checkbox" name="act" value="1"
                            onclick="ajax_upd_act({{ $value['id'] }}, this.name, $(this).prop('checked') ? 1 : 0)" @if($value['act'] == 1) checked @endif />
                        </li>
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