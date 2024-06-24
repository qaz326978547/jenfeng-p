<?php

namespace App\Controller\Web;

class SitemapController
{
	public function process()
	{
        // $news = \DB::table(config('news.table'))
        //            ->select('id', 'class_id', 'name')
		      //      ->where([['class_id', 0], ['act', 1], ['del', 0]])
		      //      ->orderBy('no', 'desc')
		      //      ->orderBy('date', 'desc')
		      //      ->orderBy('id', 'desc')
		      //      ->get();

        // $product = \DB::table(config('product.table'))
        //               ->select('id', 'class_id', 'name')
        //               ->where([['act', 1], ['del', 0]])
        //               ->orderBy('no', 'desc')
        //               ->orderBy('id', 'asc')
        //               ->get();

        // $product_class_tree = \DB::table(config('product.class_table'))->where([['act', 1], ['del', 0]])->orderBy('class_id', 'asc')->orderBy('no', 'desc')->orderBy('id', 'desc')->get(['id', 'class_id', 'name', 'updated_at'])->groupBy('class_id');

        // $product_group = \DB::table(config('product.table'))
	       //            	    ->select('id', 'class_id', 'name', 'updated_at')
	       //            	    ->where([['act', 1], ['del', 0]])
	       //            	    ->orderBy('class_id', 'asc')
	       //            	    ->orderBy('no', 'desc')
	       //            	    ->orderBy('id', 'desc')
	       //            	    ->get()
	       //            	    ->groupBy('class_id');

	    $view = \View::make("xml.sitemap", compact('news', 'product'))->render();

	    return \Response::create($view)->header('Content-Type', 'text/xml')->send();
	}
}