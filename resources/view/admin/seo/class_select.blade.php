<option value="0" hidden>--請選擇分類--</option>

@foreach ($class_tree[0] ?? [] as $data)
	@if($sys_level > 2)
		<optgroup label="{{ $data['name'] }}">
			{!! get_product_rack_class_options($data['id'], $found, $sys_level, $class_tree, $folder) !!}
		</optgroup>
	@else
		<option value="{{ $data['id'] }}" @if($data['id'] == $found) selected @endif>{{ $data['name'] }}</option>
	@endif
@endforeach