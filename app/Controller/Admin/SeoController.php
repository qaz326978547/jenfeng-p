<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Controller;
// 特性
use App\Controller\Admin\Traits\Ajax\PicsAjaxTrait;

class SeoController extends Controller
{
    use PicsAjaxTrait;

    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $this->config = config('seo');
    }

    /**
     * 首頁
     */
    public function index($class_id)
    {
        $page = \Request::query('page', 1);
        $where = [['class_id', $class_id], ['del', 0]];

        $data = \DB::table($this->config['table'])
		           ->where($where)
		           ->orderBy('id', 'asc')
		           ->paginate($this->config['page_show'], ['*'], 'page', $page)
		           ->withPath(base_path(\Request::path()))
		           ->appends(\Request::query());

        $view = \View::make("admin.{$this->config['folder']}.index", compact('data', 'class_id'))->with('config', $this->config)->render();

        return \Response::create($view)->send();
    }

    /**
     * 編輯頁面
     */
    public function edit($class_id, $id)
    {
        $action = empty($id) ? 'add' : 'upd';

        // 新增時暫存清理  (清空ajax直接存入資料表的pid=0)
        if ($id == 0) {
            $this->config['multpic_set'] == 1 and $this->temp_clear($this->config['pics_table'], 'pid', $id, 'pic');
        }

        $data = \DB::table($this->config['table'])->find($id);

        $view = \View::make("admin.{$this->config['folder']}.edit", compact('data', 'action', 'class_id'))->with('config', $this->config)->render();

        return \Response::create($view)->send();
    }

    /**
     * 新增
     */
    public function add($class_id, $id)
    {
        // 需求狀況處理 - 需要返回 並顯示錯誤訊息
        $error = $this->condition_process();
        if (!empty($error)) {
            return back()->withErrors($error)->send();
        }

        // 針對 Request資料 做各種判斷處理
        $this->request_if();

        // 寫入資料表的內容
        $values = \Request::except('_token', '_method', 'id', 'upload_pic', 'upload_pdf');

        if ($id = \DB::table($this->config['table'])->insertGetId($values)) {
            // 新增時暫存寫入
            $this->config['multpic_set'] == 1 and $this->temp_write($this->config['pics_table'], 'pid', $id);

            return back()->with('message', '新增成功')->send();
        } else {
            return back()->withErrors('新增失敗')->send();
        }
    }

    /**
     * 更新
     */
    public function upd($class_id, $id)
    {
        // 需求狀況處理 - 需要返回 並顯示錯誤訊息
        $error = $this->condition_process($id);
        if (!empty($error)) {
            return back()->withErrors($error)->send();
        }

        // 針對 Request資料 做各種判斷處理
        $this->request_if($id);

        // 寫入資料表的內容
        $values = \Request::except('_token', '_method', 'id', 'upload_pic', 'upload_pdf');

        if (\DB::table($this->config['table'])->where('id', $id)->update($values)) {
            return back()->with('message', '更新成功')->send();
        } else {
            return back()->withErrors('更新失敗')->send();
        }
    }

    /**
     * 單筆刪除 / 多筆刪除
     */
    public function del($class_id, $id)
    {
        if (\Request::has('id') && is_array(\Request::input('id'))) {
            $id = \Request::input('id');
        }

        if ($this->soft_delete($id, $this->config['table'])) {
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
        // 檔案上傳
        if (count(\Request::allFiles()) > 0) {
            if (\Request::hasFile('upload_pic')) {
                $pic_path = $this->image_upload(\Request::file('upload_pic'), $this->config['folder'], $this->config['pic_width']);
                \Request::merge(['pic' => $pic_path]);
            }

            // 檔案清理
            if ($id != 0) {
                \Request::has('pic') and $this->clear_file($id, 'pic');
            }
        }
    }
}