@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')

@endpush

@section('content')
<main>
    <h3 class="title">{{ $config['page_title'] }} - 分類</h3>
    <div class="notice"></div>
    <div id="path" class="block">
		{{ get_product_rack_path($config, $data['class_id'], $data['id'] ?? 0) }}
    </div>
    <div class="path block">@if(empty($data))新增分類資料 @else 修改分類資料@endif</div>
    <form method="post" action="" id="edit_form"  enctype="multipart/form-data" class="main_form">
        @if($action == 'upd')
    	@method('patch')
    	@endif
        @csrf
		<input type="hidden" name="id" value="{{ $data['id'] ?? 0 }}">
		<input type="hidden" name="class_id" value="{{ $data['class_id'] ?? 0 }}">

        <div class="block">
            <div class="form">

                @adminRow
                    @slot('title') {{ $config['col_title'] }}標題/名稱 @endslot
                    <input name="name" type="text" value="{{ $data['name'] ?? '' }}" size="50" />
                @endadminRow

                {{-- 圖片上傳 --}}      @if($config['pic_set'] == 1)
                @adminRow
                    @slot('title') 上傳圖片 @endslot
                    <img src="{{ storage_path($data['pic'] ?? '') ?? '' }}" width="100" /><br/>
                    <input type="file" name="upload_pic" size="20" />

				@if($config['pic_edit'] == 1)
                    <a href="javascript:;" onclick="image_editor_box('{{ base64_encode(storage_path($data['pic'] ?? '')) }}')" class="button">編輯圖片</a>
                @endif
                @endadminRow
                @adminRow
                    @slot('title') &nbsp; @endslot
                    <div class="notice show">
	                    圖片限 {{ $config['pic_mime'] }} 檔，檔案大小不可超過 {{ get_file_max($config['pic_max_limit']) }}
	                    {{-- ！ 圖片請用 {{ $config['pic_width'] }} * {{ $config['pic_height'] }} 的寬高上傳 --}}
                    </div>
                @endadminRow
                @adminRow
                    @slot('title') {{ $config['col_title'] }}圖片 Alt @endslot
                    <input name="pic_alt" type="text" value="{{ $data['pic_alt'] ?? '' }}" size="50" />
                @endadminRow                
                {{-- 圖片上傳 end  --}} @endif

				{{-- 排序 --}}
                @adminRow
                    @slot('title') {{ $config['col_title'] }}排序 @endslot
                    <input type="text" name="no" value="{{ $data['no'] ?? '100' }}" />
                @endadminRow
				{{-- 排序 end --}}

                {{-- 狀態 --}}
                @adminRow
                    @slot('title') {{ $config['col_title'] }}狀態 @endslot
                    上架<input name="act" type="checkbox" value="1" @if(!isset($data['act']) || $data['act'] == 1) checked @endif />&nbsp;
                    @if($config['p_home_set'] == 1)
                        {{ $config['p_home_name'] }}<input name="p_home" type="checkbox" value="1" @if(isset($data['p_home']) && $data['p_home'] == 1) checked @endif />&nbsp;
                    @endif
                @endadminRow
                {{-- 狀態 end --}}

                <div class="button">
                    <input class="button" value="送出資料" onclick="validate('#edit_form', '{{ $config['config'] }}.rule', '{{ $config['config'] }}.rule_message')" />
                    <input type="reset" name="reset" class="button" value="重新輸入" />
                </div>
            </div>
        </div>
    </form>
</main>
@endsection