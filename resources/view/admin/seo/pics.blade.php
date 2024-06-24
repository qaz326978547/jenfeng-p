@forelse ($data as $value)
	<div class="item">
		<div class="del s-button" onclick="pics_del({{ $value['id'] }})"><i class="fas fa-times"></i></div>
		<div class="open s-button" onclick="$.fancybox.open({src : '{{ storage_path($value['pic']) }}' });"><i class="fas fa-search"></i></div>

	@if($config['multpic_edit'] == 1)
		<div class="edit-pic s-button" onclick="image_editor_box('{{ base64_encode(storage_path($value['pic'])) }}')"><i class="fas fa-pencil-alt"></i></div>
	@endif

		<div class="pic" style="background-image:url({{ storage_path($value['pic']) }})"></div>

		<div>
			排序:
			<input type="text" onblur="pics_upd({{ $value['id'] }}, 'no', this.value)" value="{{ $value['no'] }}" placeholder="排序">
		</div>
{{-- 		<div>
			名稱:
			<input type="text" onblur="pics_upd({{ $value['id'] }}, 'name', this.value)" value="{{ $value['name'] }}" placeholder="圖片名稱">
		</div> --}}

	</div>
@empty
	<div>暫無任何圖片</div>
@endforelse