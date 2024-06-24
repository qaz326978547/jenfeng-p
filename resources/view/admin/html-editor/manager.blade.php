<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="_token" content="{{ csrf_token() }}" />

	@adminStyle

	<script type="text/javascript" src="{{ resources_path('js/admin/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ resources_path('js/admin/jquery-ui-1.12.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ resources_path('js/admin/jquery-ui-timepicker-addon.js') }}"></script>
	<script type="text/javascript" src="{{ resources_path('js/admin/jquery-ui-sliderAccess.js') }}" ></script>

	<script type="text/javascript" src="{{ resources_path('js/admin/colorbox/jquery.colorbox-min.js') }}"></script>
	<script type="text/javascript" src="{{ resources_path('js/admin/fancybox/jquery.fancybox.min.js') }}"></script>

	<script type="text/javascript" src="{{ resources_path('js/admin/sweetalert.min.js') }}"></script>
	<script type="text/javascript" src="{{ resources_path('js/admin/devtool.js') }}"></script>
	<script type="text/javascript">
		var base_path = '{{ base_path() }}';
		var $pid = {{ $class_id ?? 0 }};
		var $url = '{{ base_path($config['link_tag']) .'/' }}';

		$(function() {
			$('body').append(@json(View::make('common.includes.alert-box')->render()));

			@if(Session::has('message'))
			alert_box('{!! Session::get('message') !!}');
			@endif

			@if(Session::has('errors'))
			alert_box('{!! join('<br>', Session::get('errors')->all()) !!}');
			@endif

			pics_get();

		    $(".contextMenu > .close").click(function(){
		        $(".contextMenu").hide();
				document.oncontextmenu = function(e){
			        return true;
				}
		    })
    	});

    	function show_contextMenu(event, $id) {
    		event.preventDefault();
    		$(".contextMenu").hide();

		    if(event.which == 3){
				document.oncontextmenu = function(e){
			        return false;
				}
	            $("#folder_contextMenu_" + $id).css({'top':event.pageY+'px','left':event.pageX+'px'});
	            $("#folder_contextMenu_" + $id).show();
		    }
    	}

    	function select_pic($path) {
    		parent.window.tinymceCallBackURL = $path;
			parent.$.colorbox.close();
    	};

		function pics_get() {
		    $.ajax({
		        url: $url + 'ajax/pics/' + $pid,
		        cache: false,
		        dataType: 'json',
		        type: 'GET',
		        data: {},
		        error: function(xhr) {},
		        success: function(response) {
		            $('#editpicsList').html(response['html']);
		        }
		    });
		}

		function pics_upload() {
		    var files = $("input[id=pics_file]")[0].files;
		    var formData = new FormData();

		    formData.append('pid', $pid);

		    $.each(files, function(key, value) {
		        formData.append("pics[" + value['name'] + "]", files[key]);
		    });

		    $.ajax({
		        url: $url + 'ajax/pics/' + $pid,
		        data: formData,
		        // dataType: "json",
		        type: "POST",
		        cache: false,
		        contentType: false,
		        processData: false,
		        error: function(xhr) {},
		        success: function(response) {
		            if (response['error'] != '') {
		                alert_box(response['error']);
		            }
		            pics_get();
		        },
		        complete: function(xhr) {
		        	if(xhr.status == 422) {
		        		pics_get();
		        	}
		        }
		    });
		}

		function pics_upd($id, $column, $value) {
		    $.ajax({
		        url: $url + 'ajax/pics/' + $pid + '/' + $id + '/' + $column,
		        cache: false,
		        dataType: 'json',
		        type: 'PATCH',
		        data: {
		            id: $id,
		            column: $column,
		            value: $value,
		        },
		        error: function(xhr) {},
		        success: function(response) {
		            if (response['error'] != '') {
		                alert_box(response['error']);
		            } else {
		                // alert_box(response['success']);
		                pics_get();
		            }
		        },
		        complete: function(xhr) {
		        	if(xhr.status == 422) {
		        		pics_get();
		        	}
		        }
		    });
		}

		function pics_del($id) {
            swal({
                title: "確定要刪除嗎?",
                text: "",
                // icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(willDelete) {
                if (willDelete) {
				    $.ajax({
				        url: $url + 'ajax/pics/' + $pid + '/' + $id,
				        cache: false,
				        dataType: 'json',
				        type: 'DELETE',
				        data: {
				            id: $id
				        },
				        error: function(xhr) {},
				        success: function(response) {
				            if (response['error'] != '') {
				                alert_box(response['error']);
				            } else {
				                // alert_box(response['success']);
				                pics_get();
				            }
				        }
				    });
                } else {
                    return false;
                }
            });
		}

		function add_folder_form_check() {
			if($('#add_folder_form input[name=name]').val() == '') {
				alert_box('資料夾名稱 尚未填寫');

				return false;
			}

			$('#add_folder_form').submit();
		}

		function upd_folder_name_form_check($id) {
			if($('#upd_folder_name_form_' + $id + ' input[name=name]').val() == '') {
				alert_box('資料夾名稱 尚未填寫');

				return false;
			}

			$('#upd_folder_name_form_' + $id).submit();
		}

		function folder_del($folder_id, $action) {
			event.preventDefault();

			$('#delete_folder_form').attr('action', $action);

			if(confirm('確定要刪除嗎?')) {
				$('#delete_folder_form').submit();
			}
		}

		var drag_pics_id = 0;

		function dragStart(event, $pics_id) {
			drag_pics_id = $pics_id;
		}

		function dragEnter(event, $folder_id) {
			pics_upd(drag_pics_id, 'pid', $folder_id);
		}
	</script>
	<style type="text/css">
		.contextMenu {
			display: none;
			position: absolute;
			background: rgba(67, 142, 219);
			z-index: 9999999;
			padding: 12px 0px 0px 0px;
		}
	    .contextMenu > .close{
	        position: absolute;
	        font-size: 20px;
	        color: #000;
	        top: 5px;
	        right: 0px;
	    }
	</style>
</head>
<body>
<div id="main" style="width: auto; padding: 0px 0px">
<main>
<div class="block" style="font-size: 20px; font-weight: bold; font-family: 'Helvetica Neue';">編輯器-圖片管理 (點擊兩次選擇圖片)</div>
<div class="block">

	目前位置：{{ $now_folder_path }}

    {{-- 新增 --}}
    <form method="post" action="{{ url($config['link_tag'], ['class_id' => $class_id, 'id' => 0]) }}" class="add_folder_form" id="add_folder_form">
        @csrf
        <input type="hidden" name="class_id" value="{{ $class_id }}" />

        <input type="text" name="name" size="20" placeholder="資料夾名稱" />

        <input type="hidden" name="no" value="100" />
        {{-- 排序： <input type="text" name="no" value="100" /> --}}

        <input type="button" value="新增資料夾" class="button" onclick="add_folder_form_check();" />(對著資料夾點擊右鍵可重新命名)
    </form>

	<form id="delete_folder_form" action="" method="POST" style="display: none;">
		@method('delete')
		@csrf
	</form>

	<div id="folderList" class="subList">

	@foreach ($data as $element)
		<a href="{{ url($config['link_tag'].'/manager', ['class_id' => $element['id']]) }}" id="folder_{{ $element['id'] }}" onmousedown="show_contextMenu(event, {{ $element['id'] }})">
			<div class="item" style="border-width: 1px;" ondragenter="dragEnter(event, {{ $element['id'] }})">
				<i class="fas fa-folder"></i> {{ $element['name'] }}
				<div class="del s-button" onclick="folder_del({{ $element['id'] }} ,'{{ url($config['link_tag'], ['class_id' => $class_id, 'id' => $element['id']]) }}')"><i class="fas fa-times"></i></div>
			</div>
		</a>
		<div id="folder_contextMenu_{{ $element['id'] }}" class="contextMenu">
			<form method="post" action="{{ url($config['link_tag'], ['class_id' => $class_id, 'id' => $element['id']]) }}" id="upd_folder_name_form_{{ $element['id'] }}">
	    		@method('patch')
	    		@csrf

			    <input type="text" name="name" size="10" placeholder="" />
			    <input type="button" value="重新命名" class="button" onclick="upd_folder_name_form_check({{ $element['id'] }})" style="width: 80px" />
			</form>

			<div class="close">
				<a href="javascript:;"><i class="fas fa-times-circle"></i></a>
			</div>
		</div>
	@endforeach

	</div>

	@if($class_id != 0)
		<a href="{{ url($config['link_tag'].'/manager', ['class_id' => $back_class_id]) }}" class="button" ondragenter="dragEnter(event, {{ $back_class_id }})">上一層</a>
	@endif

	<hr>

    <input type="file" id="pics_file" size="20" multiple />
    <a id="pics_upload" class="button" onclick="pics_upload()">多圖上傳</a> (圖片可拖曳至資料夾)

	<div id="editpicsList" class="subList">
		{{-- Ajax 產生 --}}
	</div>

</div>
</main>
</div>

</body>
</html>