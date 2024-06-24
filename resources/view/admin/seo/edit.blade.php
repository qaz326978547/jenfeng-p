@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')
	{{-- 基礎 data --}}
	<script>
		var $pid = {{ $data['id'] ?? 0 }};
		var $url = '{{ base_path('admin/'. $config['link_tag']) .'/' }}';
	</script>

    {{-- 多圖上傳  --}}		@if($config['multpic_set'] == 1)
    <script type="text/javascript" src="{{ resources_path('ajax/admin/'. $config['folder'] .'/pics.js') }}"></script>
    {{-- 多圖上傳 end --}} 	@endif

@endpush

@section('content')
<main>
    <h3 class="title">{{ $config['page_title'] }}</h3>
    <div class="notice"></div>
    <div id="path" class="block">
		{{ get_product_rack_path($config, $class_id, 0, $data['id'] ?? 0) }}
    </div>
    <div class="path block">@if(empty($data))新增資料 @else 修改資料@endif</div>
    <form method="post" action="" id="edit_form"  enctype="multipart/form-data" class="main_form">
        @if($action == 'upd')
    	@method('patch')
    	@endif
        @csrf
        <input type="hidden" name="id" value="{{ $data['id'] ?? 0 }}">
        <input type="hidden" name="class_id" value="{{ $class_id }}" />

        <div class="block">
            <div class="form">
				@if(config('system.env') == 'local')
                @adminRow
                    @slot('title') {{ $config['col_title'] }}tag (Group By) @endslot
                    <input name="tag" type="text" value="{{ $data['tag'] ?? '' }}" size="50" @if($action != 'add') disabled @endif placeholder="開發用" />
                @endadminRow
                @endif

                @adminRow
                    @slot('title') {{ $config['col_title'] }}title @endslot
                    <input name="title" type="text" value="{{ $data['title'] ?? '' }}" size="50" />
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}description @endslot
                    <textarea name="description" rows="5" cols="60">{{ $data['description'] ?? '' }}</textarea>
                    <div class="notice show">換行無效果</div>
                @endadminRow

                {{-- 圖片上傳 --}}      @if($config['pic_set'] == 1)
                @adminRow
                    @slot('title') image @endslot
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
	                    ！ 圖片請用 200 * 200 以上的寬高上傳
                    </div>
                @endadminRow
                @adminRow
                    @slot('title') {{ $config['col_title'] }}image Alt @endslot
                    <input name="pic_alt" type="text" value="{{ $data['pic_alt'] ?? '' }}" size="50" />
                @endadminRow                   
                {{-- 圖片上傳 end  --}} @endif

                {{-- 多圖上傳 --}}      @if($config['multpic_set'] == 1)
                @adminRow
                    @slot('title') 上傳其他圖片 @endslot
                    <input type="file" id="pics_file" size="20" multiple />
                    <a id="pics_upload" class="button" onclick="pics_upload()">上傳</a>
                    {{-- <div id="img_upload" class="demo"></div> --}}
                    <div class="notice show">
                        圖片限 {{ $config['multpic_mime'] }} 檔，檔案大小不可超過 {{ get_file_max($config['multpic_max_limit']) }}
                        {{-- ！ 圖片請用 {{ $config['multpic_width'] }} * {{ $config['multpic_height'] }} 的寬高上傳 --}}
                    </div>
                @endadminRow
                @adminRow
                    @slot('title') 已上傳其他圖片 @endslot
                    <div id="picsList" class="subList"></div>
                @endadminRow
                {{-- 多圖上傳 end--}}   @endif

{{--                 @adminRow
                    @slot('title') {{ $config['col_title'] }}url @endslot
                    <input name="url" type="text" value="{{ $data['url'] ?? '' }}" size="50" />
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}type @endslot
                    <input name="type" type="text" value="{{ $data['type'] ?? '' }}" size="50" />
                @endadminRow --}}

                @adminRow
                    @slot('title') {{ $config['col_title'] }}keyword @endslot
                    <input name="keyword" type="text" value="{{ $data['keyword'] ?? '' }}" size="50" />
                @endadminRow

                <div class="button">
                    <input class="button" value="送出資料" onclick="validate('#edit_form', '{{ $config['config'] }}.rule', '{{ $config['config'] }}.rule_message')" />
                    <input type="reset"  name="reset" class="button" value="重新輸入" />
                </div>
            </div>
        </div>
    </form>
</main>
@endsection