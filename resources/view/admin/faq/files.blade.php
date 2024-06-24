@forelse ($data as $value)
	<div class="item">
		<div class="del s-button" onclick="files_del({{ $value['id'] }})"><i class="fas fa-times"></i></div>

		<div>
			名稱:
			<input type="text" onblur="files_upd({{ $value['id'] }}, 'name', this.value)" value="{{ $value['name'] }}" placeholder="檔案名稱">
		</div>
		<div>
			排序:
			<input type="text" onblur="files_upd({{ $value['id'] }}, 'no', this.value)" value="{{ $value['no'] }}" placeholder="排序">
		</div>

		<div>
			<input class="button" type="button" value="下載檔案" onclick="location.href='{{ url('tool-download', ['download_table' => $download_table, 'column' => 'file', 'id' => $value['id']]) }}?note='" />
		</div>

		<div>
			<a href="https://docs.google.com/viewer?embedded=true&url={{ host_path(storage_path($value['file'])) }}" class="button colorbox" style="width: 100%; margin: 0px">檢視檔案</a>
		</div>
	</div>
@empty
	<div>暫無任何檔案</div>
@endforelse

<script type="text/javascript">
    $(function(){
    	$('a.colorbox').colorbox({iframe:true, innerWidth:960, innerHeight:640});
    });
</script>