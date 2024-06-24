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

    {{-- 多檔上傳  --}}      @if($config['multfile_set'] == 1)
    <script type="text/javascript" src="{{ resources_path('ajax/admin/'. $config['folder'] .'/files.js') }}"></script>
    {{-- 多圖上傳 end --}}   @endif

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
    <h3 class="title">{{ $config['page_title'] }}</h3>
    <div class="notice"></div>
    <div class="path block">@if(empty($data))新增資料 @else 修改資料@endif</div>
    <form method="post" action="" id="edit_form"  enctype="multipart/form-data" class="main_form">
        @if($action == 'upd')
    	@method('patch')
    	@endif
        @csrf
        <input type="hidden" name="id" value="{{ $data['id'] ?? 0 }}">

        <div class="block">
            <div class="form">

            @if(config($config['config'] . '_class.sys_level') > 1)  	
                @adminRow
                    @slot('title') {{ $config['col_title'] }}分類 @endslot
					<select name="class_id">
						{!! get_product_rack_class_select($data['class_id'] ?? 0, $config['config']) !!}
					</select>
                @endadminRow
            @else
            	<input type="hidden" name="class_id" value="0">	    
            @endif
            	
                @adminRow
                    @slot('title') {{ $config['col_title'] }}問題/標題 @endslot
                    <input name="name" type="text" value="{{ $data['name'] ?? '' }}" size="50" />
                @endadminRow

				{{-- 日期 --}}      @if($config['date_set'] == 1)
                @adminRow
                    @slot('title') {{ $config['col_title'] }}日期 @endslot
                    <input name="date" type="text" id="date" value="{{ dateformat($data['date'] ?? '', 'Y-m-d') ?? '' }}" size="20" readonly="readonly" />
                @endadminRow
				{{-- 日期 end  --}} @endif

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

				{{-- youtube 影片嵌入 --}}   @if($config['utube_set'] == 1)
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
				{{-- youtube 影片嵌入 end--}} @endif

                {{-- 檔案上傳 --}}      @if($config['file_set'] == 1)
                @adminRow
                    @slot('title') 上傳檔案 @endslot
                    <input type="file" name="upload_file" size="20" />
                    <div class="notice show">
                        檔案限 {{ $config['file_mime'] }} 檔 , 大小限制 {{ get_file_max($config['file_max_limit']) }} 內！
                    </div>
                    @if(!empty($data['file']))
                    <a href="{{ url('tool-download', ['table' => $config['table'], 'column' => 'file', 'id' => $data['id'] ?? 0]) }}?note=" class="button file">下載檔案</a>
                    <a href="https://docs.google.com/viewer?embedded=true&url={{ host_path(storage_path($data['file'] ?? '')) }}" class="button colorbox">檢視檔案</a>
                    @endif
                @endadminRow
                {{-- 檔案上傳 end--}}   @endif

                {{-- 多檔上傳 --}}      @if($config['multfile_set'] == 1)
                @adminRow
                    @slot('title') 上傳檔案 @endslot
                    <input type="file" id="files_file" size="20" multiple />
                    <a id="files_upload" class="button" onclick="files_upload()">上傳</a>
                    <div class="notice show">
                        檔案限 {{ $config['multfile_mime'] }} 檔，檔案大小不可超過 {{ get_file_max($config['multfile_max_limit']) }}
                    </div>
                @endadminRow
                @adminRow
                    @slot('title') 已上傳檔案 @endslot
                    <div id="filesList" class="subList"></div>
                @endadminRow
                {{-- 多檔上傳 end --}}  @endif

                {{-- 排序 --}}      @if($config['no_set'] == 1)
                @adminRow
                    @slot('title') {{ $config['col_title'] }}排序 @endslot
                    <input type="text" name="no" value="{{ $data['no'] ?? '100' }}" />
                @endadminRow
                {{-- 排序 end --}}  @endif

                {{-- 狀態 --}}
                @adminRow
                    @slot('title') {{ $config['col_title'] }}狀態 @endslot
                    上架<input name="act" type="checkbox" value="1" @if(!isset($data['act']) || $data['act'] == 1) checked @endif />&nbsp;

                    @foreach ($config['p_checkbox_have'] as $col)
	                    @if($config[$col.'_set'] == 1)
	                        {{ $config[$col.'_name'] }}<input name="{{ $col }}" type="checkbox" value="1" @if(isset($data[$col]) && $data[$col] == 1) checked @endif />&nbsp;
	                    @endif
                    @endforeach
                @endadminRow
                {{-- 狀態 end --}}

                {{-- s_info --}}      @if($config['s_info_set'] == 1)
                @adminRow
                    @slot('title') {{ $config['col_title'].$config['s_info_title'] }} @endslot
                    <textarea name="s_info">{{ $data['s_info'] ?? '' }}</textarea>
                @endadminRow
                {{-- s_info end --}}  @endif

                {{-- info 編輯器 --}}      @if($config['info_set'] == 1)
                @adminRow
                    @slot('title') {{ $config['col_title'].$config['info_title'] }} @endslot
                    <textarea name="info" class="tinymce_editor">{!! $data['info'] ?? '' !!}</textarea>
                @endadminRow
                {{-- info 編輯器 end --}}  @endif

                {{-- info2 編輯器 --}}      @if($config['info2_set'] == 1)
                @adminRow
                    @slot('title') {{ $config['col_title'].$config['info2_title'] }} @endslot
                    <textarea name="info2" class="tinymce_editor">{!! $data['info2'] ?? '' !!}</textarea>
                @endadminRow
                {{-- info2 編輯器 end --}}  @endif

                {{-- info3 編輯器 --}}      @if($config['info3_set'] == 1)
                @adminRow
                    @slot('title') {{ $config['col_title'].$config['info3_title'] }} @endslot
                    <textarea name="info3" class="tinymce_editor">{!! $data['info3'] ?? '' !!}</textarea>
                @endadminRow
                {{-- info3 編輯器 end --}}  @endif

                {{-- info4 編輯器 --}}      @if($config['info4_set'] == 1)
                @adminRow
                    @slot('title') {{ $config['col_title'].$config['info4_title'] }} @endslot
                    <textarea name="info4" class="tinymce_editor">{!! $data['info4'] ?? '' !!}</textarea>
                @endadminRow
                {{-- info4 編輯器 end --}}  @endif

                {{-- info5 編輯器 --}}      @if($config['info5_set'] == 1)
                @adminRow
                    @slot('title') {{ $config['col_title'].$config['info5_title'] }} @endslot
                    <textarea name="info5" class="tinymce_editor">{!! $data['info5'] ?? '' !!}</textarea>
                @endadminRow
                {{-- info5 編輯器 end --}}  @endif

                <div class="button">
                	<input class="button" value="送出資料" onclick="validate('#edit_form', '{{ $config['config'] }}.rule', '{{ $config['config'] }}.rule_message')" />
                    <input type="reset"  name="reset" class="button" value="重新輸入" />
                </div>
            </div>
        </div>
    </form>
</main>
@endsection