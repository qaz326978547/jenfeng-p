@extends('admin.layout.layout')

@push('style')

@endpush

@push('script')

@endpush

@section('content')
<main>
    <h3 class="title">{{ $config['page_title'] }}</h3>
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

                @adminRow
                    @slot('title') {{ $config['col_title'] }}標題 @endslot
                    <input name="name" type="text"  value="{{ $data['name'] ?? '' }}" size="50" />
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}排序 @endslot
                    <input name="no" type="text"  value="{{ $data['no'] ?? '100' }}" size="10" />
                @endadminRow

                <div class="button">
               		<input class="button" value="送出資料" onclick="validate('#edit_form', '{{ $config['config'] }}.rule', '{{ $config['config'] }}.rule_message')" />
               		<input type="reset" name="reset" class="button" value="重新輸入" />
                </div>
            </div>
        </div>
    </form>
</main>
@endsection
