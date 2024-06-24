@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')
	{{-- 基礎 data --}}
	<script>
		var $pid = {{  ($data['id'] ?? 0) }};
		var $url = '{{ base_path('admin/'. $config['link_tag']) .'/' }}';
	</script>

    {{-- 多圖上傳  --}}		@if($config['multpic_set'] == 1)
    <script type="text/javascript" src="{{ resources_path('ajax/admin/'. $config['folder'] .'/pics.js') }}"></script>
    {{-- 多圖上傳 end --}} 	@endif

    {{-- 多檔上傳  --}}      @if($config['multfile_set'] == 1)
    <script type="text/javascript" src="{{ resources_path('ajax/admin/'. $config['folder'] .'/files.js') }}"></script>
    {{-- 多檔上傳 end --}}   @endif

    <script>
        $(function() {
            // 日期
            $.datepicker.regional['zh-TW']={
                dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
                dayNamesMin:["日","一","二","三","四","五","六"],
                monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
                monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
                prevText:"上月",
                nextText:"次月",
                weekHeader:"週"
            };

            $.datepicker.setDefaults($.datepicker.regional["zh-TW"]);

            $("#date").datepicker({dateFormat:"yy-mm-dd",showMonthAfterYear:true}).val("{{ dateformat($data['date'] ?? '', 'Y-m-d') ?? '' }}");

            $('a.colorbox').colorbox({iframe:true, innerWidth:960, innerHeight:640});
        });
    </script>
@endpush

@section('content')
<main>
    <h3 class="title">{{ $config['page_title'] }} - {{ $data['title'] ?? '新增' }}</h3>
    <div class="notice"></div>
    <div class="path block">@if(empty($data)) 新增資料 @else 修改資料 @endif</div>
    <form method="post" action="" id="edit_form" enctype="multipart/form-data" class="main_form">
    	@if($action == 'upd')
    	@method('patch')
    	@endif
        @csrf
        <input type="hidden" name="action" value="{{ $action }}">

        <div class="block">
            <div class="form">

				@if(config('system.env') == 'local' || Request::query('dev') == 'page')
                @adminRow
                    @slot('title') {{ $config['col_title'] }}後台 title @endslot
                    <input name="title" type="text" value="{{ $data['title'] ?? '' }}" size="50" @if($action != 'add') disabled @endif placeholder="開發用" />
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}對應 View path @endslot
                    <input name="path" type="text" value="{{ $data['path'] ?? '' }}" size="50" @if($action != 'add') disabled @endif placeholder="開發用" />
                @endadminRow
                @endif

				@if(in_array( ($data['id'] ?? 0), $config['act_id_set']) || $action == 'add')
                @adminRow
                    @slot('title') {{ $config['col_title'] }}上架 @endslot
                    <input name="act" type="checkbox" value="1" @if(!isset($data['act']) || $data['act'] == 1) checked @endif />&nbsp;
                @endadminRow
                @endif

				@if(in_array( ($data['id'] ?? 0), $config['name_id_set']) || $action == 'add')
                @adminRow
                    @slot('title') {{ $config['col_title'] }}標題/名稱 @endslot
                    <input name="name" type="text" value="{{ $data['name'] ?? '' }}" size="50" />
                @endadminRow
                @endif

				@if(in_array( ($data['id'] ?? 0), $config['e_name_id_set']) || $action == 'add')
                @adminRow
                    @slot('title') {{ $config['col_title'] }}英文標題/名稱 @endslot
                    <input name="e_name" type="text" value="{{ $data['e_name'] ?? '' }}" size="50" />
                @endadminRow
                @endif

				@if(in_array( ($data['id'] ?? 0), $config['sub_name_id_set']) || $action == 'add')
                @adminRow
                    @slot('title') {{ $config['col_title'] }}副標題/名稱 @endslot
                    <input name="sub_name" type="text" value="{{ $data['sub_name'] ?? '' }}" size="50" />
                @endadminRow
                @endif

				@if(in_array( ($data['id'] ?? 0), $config['link_id_set']) || $action == 'add')
                @adminRow
                    @slot('title') {{ $config['col_title'] }}連結 @endslot
                    <input name="link" type="text" value="{{ $data['link'] ?? '' }}" size="50" />
                @endadminRow
                @endif

				@if(in_array( ($data['id'] ?? 0), $config['pic_id_set']) || $action == 'add')
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

{{-- 	                    @if( ($data['id'] ?? 0) == )
	                    ！ 圖片請用  *  的寬高上傳
	                    @elseif( ($data['id'] ?? 0) == )
	                    ！ 圖片請用  *  的寬高上傳
	                    @endif --}}

                    </div>
                @endadminRow
                @adminRow
                    @slot('title') {{ $config['col_title'] }}圖片 Alt @endslot
                    <input name="pic_alt" type="text" value="{{ $data['pic_alt'] ?? '' }}" size="50" />
                @endadminRow                 
                @endif

				@if($config['multpic_set'] == 1)
				@if(in_array( ($data['id'] ?? 0), $config['pics_id_set']) || $action == 'add')
                {{-- 多圖上傳 --}}
                @adminRow
                    @slot('title') 上傳多圖 @endslot
                    <input type="file" id="pics_file" size="20" multiple />
                    <a id="pics_upload" class="button" onclick="pics_upload()">上傳</a>
                    {{-- <div id="img_upload" class="demo"></div> --}}
                    <div class="notice show">
                        圖片限 {{ $config['multpic_mime'] }} 檔，檔案大小不可超過 {{ get_file_max($config['multpic_max_limit']) }}

{{-- 	                    @if( ($data['id'] ?? 0) == )
	                    ！ 圖片請用  *  的寬高上傳
	                    @elseif( ($data['id'] ?? 0) == )
	                    ！ 圖片請用  *  的寬高上傳
	                    @endif --}}

                    </div>
                @endadminRow
                @adminRow
                    @slot('title') 已上傳多圖 @endslot
                    <div id="picsList" class="subList"></div>
                @endadminRow
                {{-- 多圖上傳 end--}}
                @endif
                @endif

                @if(in_array( ($data['id'] ?? 0), $config['file_id_set']) || $action == 'add')
                @adminRow
                    @slot('title') 上傳檔案 @endslot
                    <input type="file" name="upload_file" size="20" />
                    <div class="notice show">
                        檔案限 {{ $config['file_mime'] }} 檔 , 大小限制 {{ get_file_max($config['file_max_limit']) }} 內！
                    </div>
                    @if(!empty($data['file']))
                    <a href="{{ url('tool-download', ['table' => $config['table'], 'column' => 'file', 'id' => $data['id']]) }}?note=" class="button file">下載檔案</a>
                    <a href="https://docs.google.com/viewer?embedded=true&url={{ host_path(storage_path($data['file'])) }}" class="button colorbox">檢視檔案</a>
                    @endif
                @endadminRow
                @endif

                @if($config['multfile_set'] == 1)
                @if(in_array( ($data['id'] ?? 0), $config['files_id_set']) || $action == 'add')
                {{-- 多檔上傳 --}}
                @adminRow
                    @slot('title') 上傳檔案 @endslot
                    <input type="file" id="files_file" size="20" multiple />
                    <a id="files_upload" class="button" onclick="files_upload()">上傳</a>

                    <div class="progress">
                        <div class="bar" id="files_bar"></div>
                        <div class="percent" id="files_percent">0%</div>
                    </div>

                    <div class="notice show">
                        檔案限 {{ $config['multfile_mime'] }} 檔，檔案大小不可超過 {{ get_file_max($config['multfile_max_limit']) }}
                    </div>
                @endadminRow
                @adminRow
                    @slot('title') 已上傳檔案 @endslot
                    <div id="filesList" class="subList"></div>
                @endadminRow
                {{-- 多檔上傳 end --}}
                @endif
                @endif

				@if(in_array( ($data['id'] ?? 0), $config['utube_id_set']) || $action == 'add')
				{{-- youtube 影片嵌入 --}}
				@adminRow
					@slot('title') 影音連結 @endslot
					<input name="utube" type="text" value="{{ $data['utube'] ?? '' }}" size="60"/>
				@endadminRow
				@adminRow
					@slot('title') &nbsp; @endslot
		            <div class="notice show">
		                連結範例：https://www.youtube.com/watch?v=JtHd7RZvTiU <br>
		                <p style="padding-left: 14ex">https://youtu.be/JtHd7RZvTiU</p>
		            </div>
				@endadminRow
				@if(!empty($data['utube']))
					@adminRow
						@slot('title') &nbsp; @endslot
	                <div>
	                    <span class="video">
	                        <iframe width="560" height="315" src="{{ get_youtube_code($data['utube']) }}" frameborder="0" allowfullscreen></iframe>
	                    </span>
	                </div>
					@endadminRow
				@endif
				{{-- youtube 影片嵌入 end--}}
				@endif

				@if(in_array( ($data['id'] ?? 0), $config['s_info_id_set']) || $action == 'add')
                @adminRow
                    @slot('title') {{ $config['col_title'] }}
                    	@if($data['id']<>2)
                    	簡短敘述 
                    	@else
                    	head部分
                    	@endif
                    @endslot
                    <textarea name="s_info">{{ $data['s_info'] ?? '' }}</textarea>
                @endadminRow
                @endif

				@if(in_array( ($data['id'] ?? 0), $config['info_id_set']) || $action == 'add')
                {{-- info 編輯器 --}}
                @adminRow
                    @slot('title') 
                    @if($data['id']<>2)
                    	{{ $config['col_title'] }}詳細介紹 
                    	@else
                    	body部分
                    	@endif                    
                    @endslot
                    <textarea name="info" @if($data['id']<>2) class="tinymce_editor" @endif>{!! $data['info'] ?? '' !!}</textarea>
                @endadminRow
                {{-- info 編輯器 end --}}
                @endif

                <div class="button">
               		<input class="button" value="送出資料" onclick="validate('#edit_form', '{{ $config['config'] }}.rule', '{{ $config['config'] }}.rule_message')" />
               		<input type="reset" name="reset" class="button" value="重新輸入" />
                </div>
            </div>
        </div>
    </form>
</main>
@endsection