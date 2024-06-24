@extends('admin.layout.layout')

@push('style')

@endpush

@section('content')
<main>
    <h3 class="title">每日人數 - 資料</h3>
    <div class="notice"></div>
    <div class="block list">

        <form method="post" action="{{ url('admin/'. $config['link_tag'] .'/del') }}" id="form1" class="list_form">
        	@method('delete')
            @csrf

            <div class="t">
                <ul class="head">
                    <li class="name">人數</li>
                    <li class="upd">日期</li>
                </ul>

                @forelse ($data as $value)
                    <ul>
                        <li>{{ $value['num'] }}</li>
						<li>{{ $value['date'] }}</li>
                    </ul>
                @empty
               		<div>暫無任何資料</div>
               	@endforelse

            </div>
        </form>
    </div>
</main>
@endsection