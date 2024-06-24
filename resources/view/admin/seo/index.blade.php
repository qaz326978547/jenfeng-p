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
    <div id="path" class="block">
        {{ get_product_rack_path($config, $class_id) }}
    </div>
    <div class="block list">
    	@if(config('system.env') == 'local')
        {{-- 新增 --}}
        <form method="post" action="{{ url('admin/'. $config['link_tag'], ['class_id' => $class_id, 'id' => 0]) }}" class="add_form quick_form">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class_id }}" />
            <input type="hidden" name="id" value="0" />
            名稱：<input type="text" name="name" size="20" />
            tag： <input type="text" name="tag" value="" placeholder="取DB 方便用 不一定要記id" />
            <input type="submit" value="新增" class="button"/>
        </form>
        @endif

        <form method="post" action="{{ url('admin/'. $config['link_tag'], ['class_id' => $class_id, 'id' => 'del']) }}" id="form1" class="list_form">
            @method('delete')
            @csrf

            <div class="t">
                <ul class="head">
                	{{-- <li class="del">選擇全部<input type="checkbox" name="all" value="1" onclick="checkall('.del_d')" /></li> --}}
                    <li class="name">標題</li>

                    <li class="upd">修改內容</li>
                </ul>

                @forelse ($data as $value)
                    <ul>
                        {{-- <li>
                        	<input type="checkbox" name="id[]" value="{{ $value['id'] }}" class="del_d" />
                        </li> --}}

                        <li>
                        	<a href="{{ url('admin/'. $config['link_tag'], ['class_id' => $value['class_id'], 'id' => $value['id']]) }}">{{ $value['name'] }}</a>
                        </li>

                        <li>
                            <a href="{{ url('admin/'. $config['link_tag'], ['class_id' => $value['class_id'], 'id' => $value['id']]) }}" class="s-button">
                            	<i class="fas fa-edit"></i>
                            </a>

                            @if(config('system.env') == 'local')
                            <a href="javascript:;" class="s-button" onclick="$('#delete-form').attr('action', '{{ url('admin/'. $config['link_tag'], ['class_id' => $class_id, 'id' => $value['id']]) }}'); delete_form_confirm('#delete-form');">
                            	<i class="far fa-trash-alt"></i>
                            </a>
                            @endif

                        </li>
                    </ul>
                @empty
               		<div>暫無任何資料</div>
               	@endforelse
            </div>
            @adminPaginate(['data' => $data])
{{--                 <input type="button" name="del" value="刪除資料" class="button" onclick="delete_form_confirm('.list_form');" />
                <input type="reset" name="reset" value="重新輸入"  class="button" /> --}}
            @endadminPaginate
        </form>
    </div>
</main>
@endsection