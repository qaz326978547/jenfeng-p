@php
	echo '<?xml version="1.0" encoding="UTF-8"?>';
@endphp
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

	{{-- 首頁 --}}
	<url>
		<loc>{{ host_path(base_path()) }}</loc>
		<lastmod>2022-12-27T20:00:00+08:00</lastmod>
	 	<priority>1.00</priority>
	</url>
	<url>
		<loc>{{ host_path(base_path()) }}index</loc>
		<lastmod>2022-12-27T20:00:00+08:00</lastmod>
	 	<priority>1.00</priority>
	</url>	
	{{-- 關於我們 --}}
	<url>
	  	<loc>{{ host_path(base_path()) }}about</loc>
		<lastmod>2022-12-27T20:00:00+08:00</lastmod>
	 	<priority>1.00</priority>		  	
	</url>

	{{-- 最新消息 --}}
{{-- 	<url>
	  	<loc>{{ host_path(base_path()) }}news</loc>
		<lastmod>2021-12-27T15:29:31+08:00</lastmod>
	  	<priority>0.90</priority>
	</url>
@foreach ($news as $element)
	<url>
	  	<loc>{{ host_path(url('news', ['id' => $element['id']])) }}</loc>
	  	<lastmod>{{ dateformat($element['updated_at'], 'c') }}</lastmod>
	  	<priority>0.80</priority>
	</url>
@endforeach --}}

	{{-- 產品介紹 --}}
{{-- 	<url>
	  	<loc>{{ host_path(base_path()) }}product</loc>
		<lastmod>2021-12-27T15:29:31+08:00</lastmod>
	  	<priority>0.90</priority>
	</url>
@foreach ($product as $element)
	<url>
	  	<loc>{{ host_path(url('product', ['id' => $element['id']])) }}</loc>
	  	<lastmod>{{ dateformat($element['updated_at'], 'c') }}</lastmod>
	  	<priority>0.80</priority>
	</url>
@endforeach --}}

{{-- 	<url>
		<loc>{{ host_path(base_path()) }}product</loc>
		<lastmod>2021-09-03T15:29:31+08:00</lastmod>
	  	<priority>0.90</priority>
	</url>
@foreach ($product_class_tree[0] ?? [] as $level_1_class)
	<url>
	  	<loc>{{ host_path(url('product', ['level_1_class_id' => $level_1_class['id']])) }}</loc>
	  	<lastmod>{{ dateformat($level_1_class['updated_at'], 'c') }}</lastmod>
	  	<priority>0.80</priority>
	</url>

	@foreach ($product_group[$level_1_class['id']] ?? [] as $element)
		<url>
		  	<loc>{{ host_path(url('product', ['level_1_class_id' => $level_1_class['id'], 'id' => $element['id']])) }}</loc>
		  	<lastmod>{{ dateformat($element['updated_at'], 'c') }}</lastmod>
		  	<priority>0.70</priority>		  	
		</url>
	@endforeach  
@endforeach	 --}}


	{{-- 聯絡我們 --}}
	<url>
	  	<loc>{{ host_path(base_path()) }}contact</loc>
	  	<lastmod>2022-12-27T20:00:00+08:00</lastmod>
	 	<priority>1.00</priority>
	</url>
</urlset>