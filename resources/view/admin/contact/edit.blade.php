@extends('admin.layout.layout')

@push('style')
<style>
	.list-table th{
		background:#EEEEEE;
	}
	.list-table th,.list-table td{
		padding:5px;
		border:1px #ccc solid;
	}
</style>
@endpush

@push('script')

@endpush

@section('content')
<main>
    <h3 class="title">{{ $config['page_title'] }}</h3>
    <div class="notice"></div>
    <div class="path block">@if(empty($data)) 新增資料 @else 檢視資料 @endif</div>
    <form method="post" action="" id="edit_form" enctype="multipart/form-data" class="main_form">
        @if($action == 'upd')
    	@method('patch')
    	@endif
        @csrf
        <input type="hidden" name="action" value="{{ $action }}">

        <div class="block">
            <div class="form">

                @adminRow
                    @slot('title') {{ $config['col_title'] }}報名課程 @endslot
                    {{ $data['class'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}公司名稱 @endslot
                    {{ $data['company'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}公司電話 @endslot
                    {{ $data['tel'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}主要問題 @endslot
                    {{ $data['quest'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}報名人數 @endslot
                    {{ $data['num'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}參加人員名單 @endslot

                    <table width="100%" class="list-table">
                    	<tr>
                    		<th>編號</th>
                    		<th>姓名</th>
                    		<th>手機</th>
                    		<th>職稱</th>
                    		<th>e-mail</th>
                    	</tr>
                    @foreach($list as $key => $value)
                    	<tr>
                    		<td>{{ $key+1 }}</td>
                    		<td>{{ $value['name'] }}</td>
                    		<td>{{ $value['cel'] }}</td>
                    		<td>{{ $value['job'] }}</td>
                    		<td>{{ $value['email'] }}</td>
                    	</tr>
                    @endforeach
                	</table>
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}匯款後五碼 @endslot
                    {{ $data['last5'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}發票種類 @endslot
                    @if($data['ticket']==2)
                    二聯式
                    @elseif($data['ticket']==3)
                    三聯式
                    @endif
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}發票抬頭 @endslot
                    {{ $data['ticket_name'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}統一編號 @endslot
                    {{ $data['ticket_no'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}發票寄送地址 @endslot
                    {{ $data['ticket_address'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}得知講座管道 @endslot
                    {{ $data['from'] }}
                @endadminRow

                @adminRow
                    @slot('title') {{ $config['col_title'] }}推薦人姓名 @endslot
                    {{ $data['suggest_name'] }}
                @endadminRow


                <div class="button">
                	{{-- <input class="button" value="送出資料" onclick="validate('#edit_form', '{{ $config['config'] }}.rule', '{{ $config['config'] }}.rule_message')" /> --}}
                	{{-- <input type="reset" name="reset" class="button" value="重新輸入" />   --}}
                </div>
            </div>
        </div>
    </form>
</main>
@endsection
