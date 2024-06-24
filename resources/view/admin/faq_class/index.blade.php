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
    <h3 class="title">{{ $config['page_title'] }} - 分類</h3>
    <div class="notice"></div>
    <div id="path" class="block">
        {{ get_product_rack_path($config, $class_id) }}
    </div>
    <div class="block list">
        {{-- 新增 --}}
        <form method="post" action="{{ url('admin/'. $config['link_tag'], ['class_id' => $class_id, 'id' => 0]) }}" class="add_form quick_form">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class_id }}" />
            <input type="hidden" name="act" value="1" />
            名稱：<input type="text" name="name" size="20" />
            排序： <input type="text" name="no" value="100" />
            <input type="submit" value="新增類別" class="button"/>
        </form>

        <form method="post" action="{{ url('admin/'. $config['link_tag'], ['class_id' => $class_id, 'id' => 'del']) }}" id="form1" class="list_form">
            @method('delete')
            @csrf

            <div class="t">
                <ul class="head">
                    <li class="del">選擇全部<input type="checkbox" name="all" value="1" onclick="checkall('.del_d')" /></li>
                    <li class="name">標題</li>
                    <li class="no">排序</li>
                    <li class="act">上架</li>

                @if($config['p_home_set'] == 1) {{-- 首頁上架 --}}
                	<li class="act">{{ $config['p_home_name'] }} </li>
                @endif

                    <li class="upd">修改內容</li>
                </ul>
                @forelse ($data as $value)
                    <ul>
                        <li><input type="checkbox" name="id[]" value="{{ $value['id'] }}" class="del_d" /> </li>

                    @if($end_class_check)
                        <li><a href="javascript:;" class='path'>{{ $value['name'] }}</a></li>
                    @else
                        <li><a href="{{ url('admin/'. $config['link_tag'], ['class_id' => $value['id']]) }}" class='path'>{{ $value['name'] }}</a></li>
                    @endif

                        <li>
                        	<input type='text' name='no' value="{{ $value['no'] }}" size="3"
        		            onblur="ajax_upd({{ $value['id'] }}, 'no', this.value)"/>
                        </li>

                        <li class="act">
                            <input type="checkbox" name="act" value="1"
                            onclick="ajax_upd_act({{ $value['id'] }}, this.name, $(this).prop('checked') ? 1 : 0, 'p_rack')" @if($value['act'] == 1) checked @endif />
                        </li>

                    @if($config['p_home_set'] == 1) {{-- 首頁上架 --}}
                        <li class="act">
                            <input type="checkbox" name="p_home" value="1"
                            onclick="ajax_upd_act({{ $value['id'] }}, this.name, $(this).prop('checked') ? 1 : 0, 'p_rack')" @if($value['p_home'] == 1) checked @endif />
                        </li>
                    @endif

                        <li>
                            <a href="{{ url('admin/'. $config['link_tag'], ['class_id' => $class_id, 'id' => $value['id']]) }}" class="s-button">
                            	<i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:;" class="s-button" onclick="$('#delete-form').attr('action', '{{ url('admin/'. $config['link_tag'], ['class_id' => $class_id, 'id' => $value['id']]) }}'); delete_form_confirm('#delete-form');">
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