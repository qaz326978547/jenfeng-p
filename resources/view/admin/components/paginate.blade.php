<div class="page">

@if ($data instanceof Illuminate\Pagination\LengthAwarePaginator)

    @if($data->currentPage() > 1)
        <a href="{{ $data->url(1) }}">第一頁</a>
    @endif
    @for ($i = 1; $i <= $data->lastPage(); $i++)
    	@if(abs($data->currentPage() - $i) <= 5)
	        @if($data->currentPage() <> $i)
	            <a href="{{ $data->url($i) }}">{{ $i }}</a>&nbsp;
	        @else &nbsp;{{ $i }}&nbsp;
	        @endif
	    @endif
    @endfor
    @if($data->currentPage() < $data->lastPage())
        <a href="{{ $data->url($data->lastPage()) }}">最末頁</a>
    @endif
    <p>共有 {{ $data->total() }} 筆資料，共有 {{ $data->lastPage() }} 頁，目前位於第 {{ $data->currentPage() }} 頁。</p>

    {{ $slot }}

@else

    <p>共有 {{ $data->count() }} 筆資料</p>

    {{ $slot }}

@endif

</div>