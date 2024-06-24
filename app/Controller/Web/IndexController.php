<?php

namespace App\Controller\Web;

class IndexController
{
    /**
     * 首頁
     */
    public function index()
    {
    	//faq
    	$faq = \DB::table(config('faq.table'))
    			->where([ ['act',1],['del',0] ])
    			->orderBy('no','desc')
    			->orderBy('date','desc')
    			->orderBy('id','desc')
    			->get();

    	//課程
    	$class = \DB::table(config('contact_class.table'))
    	            ->where('del', 0)
    				->orderBy('no','desc')    				
    				->orderBy('id','desc')
    				->get();
		
		//問題
    	$quest = \DB::table(config('contact_quest.table'))
    	            ->where('del', 0)
    				->orderBy('no','desc')    				
    				->orderBy('id','desc')
    				->get();    				

        $view = \View::make('web.index',compact('faq','class','quest'))->render();

        return \Response::create($view)->send();
    }
}