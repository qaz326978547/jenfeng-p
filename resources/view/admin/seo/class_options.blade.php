@isset($class_tree[$class_id])
    @foreach ($class_tree[$class_id] as $data)
    	@php
    		$level = count(explode(';', $data['history'])) + 1;
    	@endphp

    	@if($level + 1 < $sys_level)
			<optgroup label="@for ($i = 0; $i < $level * 3; $i++)&nbsp;@endfor {{ $data['name'] }}">
				{!! get_product_rack_class_options($data['id'], $found, $sys_level, $class_tree, $folder) !!}
			</optgroup>
    	@else
			<option value="{{ $data['id'] }}" @if($found == $data['id']) selected @endif>@for ($i = 0; $i < $level * 3; $i++)&nbsp;@endfor{{ $data['name'] }}</option>
    	@endif
    @endforeach
@endisset