<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Controller;
// 特性
use App\Controller\Admin\Traits\Ajax\UpdAjaxTrait;

class SimpleSettingController extends Controller
{
	use UpdAjaxTrait;

    /**
     * $config.
     *
     * @var array
     */
	protected $config;

	public function __construct()
	{
		$this->config = config('simple_setting');
	}

	/**
	 * 首頁
	 */
	public function index()
	{
		$page = \Request::query('page' , 1);

		$data = \DB::table($this->config['table'])
				   ->where('del', 0)
				   ->orderBy('id', 'asc')
				   ->paginate($this->config['page_show'], ['*'], 'page', $page)
				   ->withPath(base_path(\Request::path()));

		$view = \View::make("admin.{$this->config['folder']}.index", compact('data'))->with('config', $this->config)->render();

		return \Response::create($view)->send();
	}

	/**
	 * 修改 line_notify 頁面
	 */
	public function show_upd_line_notify()
	{
		$data = \DB::table($this->config['table'])->find(1);

		$view = \View::make("admin.{$this->config['folder']}.upd_line_notify", compact('data'))->render();
			
		return \Response::create($view)->send();
	}


	/**
	 * 編輯頁面
	 */
	public function edit($id)
	{
		$action = empty($id) ? 'add' : 'upd';

		$data = \DB::table($this->config['table'])->find($id);

		$view = \View::make("admin.{$this->config['folder']}.edit", compact('data', 'action'))->with('config', $this->config)->render();

		return \Response::create($view)->send();
	}

	/**
	 * 新增
	 */
	public function add($id)
	{
    	// 需求狀況處理 - 需要返回 並顯示錯誤訊息
    	$error = $this->condition_process();
    	if(!empty($error)) {
    		return back()->withErrors($error)->send();
    	}

		// 針對 Request資料 做各種判斷處理
		$this->request_if();

		// 寫入資料表的內容
		$values = \Request::except('_token', '_method', 'action', 'upload_pic');

		if(\DB::table($this->config['table'])->insert($values)) {
			return back()->with('message', '新增成功')->send();
		} else {
			return back()->withErrors('新增失敗')->send();
		}
	}

	/**
	 * 更新
	 */
	public function upd($id)
	{
    	// 需求狀況處理 - 需要返回 並顯示錯誤訊息
    	$error = $this->condition_process($id);
    	if(!empty($error)) {
    		return back()->withErrors($error)->send();
    	}

		// 針對 Request資料 做各種判斷處理
		$this->request_if($id);

		// 寫入資料表的內容
		$values = \Request::except('_token', '_method', 'action', 'upload_pic');

		if(\DB::table($this->config['table'])->where('id', $id)->update($values)) {
			return back()->with('message', '更新成功')->send();
		} else {
			return back()->withErrors('更新失敗')->send();
		}
	}

	/**
	 * 單筆刪除 / 多筆刪除
	 */
	public function del($id)
	{
		if(\Request::has('id') && is_array(\Request::input('id'))) {
			$id = \Request::input('id');
		}

		if($this->soft_delete($id, $this->config['table'])) {
			return back()->with('message', '刪除成功')->send();
		} else {
			return back()->withErrors('刪除失敗')->send();
		}
	}

    /**
     * 需求狀況處理 - 需回傳錯誤訊息的各種狀況
     *
     * @param  int $id
     * @return string 狀況內容失敗時 回傳訊息
     */
    private function condition_process($id = 0)
    {
    	//
    }

    /**
     * 透過 Request資料判斷 Request物件內容修改和執行狀況
     *
     * @param  int $id
     * @return void
     */
	private function request_if($id = 0)
	{

	}
}