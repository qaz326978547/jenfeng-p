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
        <form method="post" action="{{ url('admin/'. $config['link_tag'], ['id' => 'del']) }}" id="form1" class="list_form">
            @method('delete')
            @csrf

            <div class="t">
 				<ul>
					<li>搜尋</li>
					<li>
						<input type="checkbox" name="all_product" value="1" class="search" @if(Request::query('all_product') == 1) checked @endif />全部資料
						<input type="text" name="search_name" value="{{ Request::query('search_name', '') }}" placeholder="搜尋名稱" class="search" />

					@if(config($config['config'] . '_class.sys_level') > 1)
						<select name="search_class_id" class="search">
							{!! get_product_rack_class_select(\Request::query('search_class_id'), $config['config']) !!}
						</select>
					@endif
					
					@if($config['date_set'] == 1)
						<input type="text" name="search_date" value="{{ Request::query('search_date', '') }}" placeholder="搜尋日期" class="search" />
					@endif

						<input type="checkbox" name="search_act" value="1" class="search" @if(Request::query('search_act') == 1) checked @endif />上架

					@foreach ($config['p_checkbox_have'] as $col)
						@if($config[$col.'_set'] == 1)
							<input type="checkbox" name="search_{{ $col }}" value="1" class="search" @if(Request::query('search_'.$col) == 1) checked @endif />{{ $config[$col.'_name'] }}
						@endif
					@endforeach

					</li>
				</ul>
            </div>

            <div class="t">
                <ul class="head">
                    <li class="del">選擇全部<input type="checkbox" name="all" value="1" onclick="checkall('.del_d')" /></li>

                @if(config($config['config'] . '_class.sys_level') > 1)      
                    <li>分類</li>
                @endif

                    <li class="name">標題</li>

				@if($config['date_set'] == 1)
                	<li class="date">日期</li>
                @endif

                @if($config['no_set'] == 1)
                	<li class="no">排序</li>
                @endif

                    <li class="act">上架</li>

                @foreach ($config['p_checkbox_have'] as $col)
                    @if($config[$col.'_set'] == 1)
                    	<li class="act">{{ $config[$col.'_name'] }} </li>
                    @endif
                @endforeach

                    <li class="upd">修改內容</li>
                </ul>

                @forelse ($data as $value)
                    <ul>
                        <li>
                        	<input type="checkbox" name="id[]" value="{{ $value['id'] }}" class="del_d" />
                        </li>

                    @if(config($config['config'] . '_class.sys_level') > 1)    
                        <li>{{ $value['class_name'] }}</li>
                    @endif    

                        <li>
                        	<a href="{{ url('admin/'. $config['link_tag'], ['id' => $value['id']]) }}">{{ $value['name'] }}</a>
                        </li>

                    @if($config['date_set'] == 1) {{-- 日期 --}}
                    	<li>{{ dateformat($value['date'], 'Y-m-d') }}</li>
                    @endif

					@if($config['no_set'] == 1) {{-- 排序 --}}
                    	<li>
                        	<input type='text' name='no' value="{{ $value['no'] }}" size="3"
    		            	onblur="ajax_upd({{ $value['id'] }}, 'no', this.value)"/>
                        </li>
                    @endif

                        <li class="act">
                            <input type="checkbox" name="act" value="1"
                            onclick="ajax_upd_act({{ $value['id'] }}, this.name, $(this).prop('checked') ? 1 : 0, 'p_rack')" @if($value['act'] == 1) checked @endif />
                        </li>

                    @foreach ($config['p_checkbox_have'] as $col)
                        @if($config[$col.'_set'] == 1)
                            <li class="act">
                                <input type="checkbox" name="{{ $col }}" value="1"
                                onclick="ajax_upd_act({{ $value['id'] }}, this.name, $(this).prop('checked') ? 1 : 0, 'p_rack')" @if($value[$col] == 1) checked @endif />
                            </li>
                        @endif
                    @endforeach

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