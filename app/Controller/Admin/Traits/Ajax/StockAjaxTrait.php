<?php

namespace App\Controller\Admin\Traits\Ajax;

trait StockAjaxTrait
{
    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    /**
     * 取得庫存資料
     */
    public function ajax_stock_get($pid)
    {
        $stock_table = $this->config['stock_table'];
        $color_table = $this->config['color_table'];
        $size_table = $this->config['size_table'];

        if ($pid == 0) {
            // 新增時 顯示暫存
            $color_where = [['session_id', \Session::getId()], ['pid', $pid], ['del', 0]];
            $size_where = [['session_id', \Session::getId()], ['pid', $pid], ['del', 0]];
        } else {
            $color_where = [['pid', $pid], ['del', 0]];
            $size_where = [['pid', $pid], ['del', 0]];
        }

        $color_data = [];
        $size_data = [];
        $stock_data = [];

        if ($this->config['color_set'] == 1) {
   	 		$color_data = \DB::table($color_table)->where($color_where)->orderBy('id', 'asc')->get();
        }

        if ($this->config['size_set'] == 1) {
        	$size_data = \DB::table($size_table)->where($size_where)->orderBy('id', 'asc')->get();
        }
        
        //製作庫存表 COLOR SIZE 皆啟用  -----------------------------------------------------
        if ($this->config['color_set'] == 1 and $this->config['size_set'] == 1) {
            foreach ($size_data as $key1 => $size) {
                $tmp = [];
                foreach ($color_data as $key2 => $color) {
                    if ($pid == 0) {
                        // 新增時 顯示暫存
                        $where = [['session_id', \Session::getId()], ['pid', $pid], ['cid', $color['id']], ['sid', $size['id']]];
                    } else {
                        $where = [['pid', $pid], ['cid', $color['id']], ['sid', $size['id']]];
                    }

                    $sqldata = \DB::table($stock_table)->where($where)->get()->toArray();

                    if (empty($sqldata)) {
                        $last_id = \DB::table($stock_table)->insertGetId([
                            'pid' => $pid,
                            'cid' => $color['id'],
                            'sid' => $size['id'],
                            'session_id' => \Session::getId(),
                        ]);

                        $sqldata[] = \DB::table($stock_table)->find($last_id);
                    }

                    $tmp = array_merge($tmp, $sqldata);
                }

                $tmp = \Arr::add($tmp, 'size_name', $size['name']);
                $stock_data = array_merge($stock_data, [$tmp]);
            }
        }
        //製作庫存表 僅COLOR 啟用  -----------------------------------------------------
        if ($this->config['color_set'] == 1 and $this->config['size_set'] == 0) {
            foreach ($color_data as $key => $color) {
                if ($pid == 0) {
                    // 新增時 顯示暫存
                    $where = [['session_id', \Session::getId()], ['pid', $pid], ['cid', $color['id']], ['sid', 0]];
                } else {
                    $where = [['pid', $pid], ['cid', $color['id']], ['sid', 0]];
                }

                $sqldata = \DB::table($stock_table)->where($where)->get()->toArray();

                if (empty($sqldata)) {
                    $last_id = \DB::table($stock_table)->insertGetId([
                        'pid' => $pid,
                        'cid' => $color['id'],
                        'session_id' => \Session::getId(),
                    ]);

                    $sqldata[] = \DB::table($stock_table)->find($last_id);
                }

                $sqldata = \Arr::add($sqldata, 'color_name', $color['name']);
                $stock_data = array_merge($stock_data, [$sqldata]);
            }
        }
        //製作庫存表 僅SIZE 啟用  -----------------------------------------------------
        if ($this->config['color_set'] == 0 and $this->config['size_set'] == 1) {
            foreach ($size_data as $key => $size) {
                if ($pid == 0) {
                    // 新增時 顯示暫存
                    $where = [['session_id', \Session::getId()], ['pid', $pid], ['cid', 0], ['sid', $size['id']]];
                } else {
                    $where = [['pid', $pid], ['cid', 0], ['sid', $size['id']]];
                }

                $sqldata = \DB::table($stock_table)->where($where)->get()->toArray();

                if (empty($sqldata)) {
                    $last_id = \DB::table($stock_table)->insertGetId([
                        'pid' => $pid,
                        'sid' => $size['id'],
                        'session_id' => \Session::getId(),
                    ]);

                    $sqldata[] = \DB::table($stock_table)->find($last_id);
                }

                $sqldata = \Arr::add($sqldata, 'size_name', $size['name']);
                $stock_data = array_merge($stock_data, [$sqldata]);
            }
        }
        //製作庫存欄位 兩者皆未啟用  -----------------------------------------------------
        if ($this->config['color_set'] == 0 and $this->config['size_set'] == 0) {
            if ($pid == 0) {
                // 新增時 顯示暫存
                $where = [['session_id', \Session::getId()], ['pid', $pid], ['cid', 0], ['sid', 0]];
            } else {
                $where = [['pid', $pid], ['cid', 0], ['sid', 0]];
            }

            $sqldata = \DB::table($stock_table)->where($where)->get()->toArray();

            if (empty($sqldata)) {
                $last_id = \DB::table($stock_table)->insertGetId([
                    'pid' => $pid,
                    'session_id' => \Session::getId(),
                ]);

                $sqldata[] = \DB::table($stock_table)->find($last_id);
            }

            $stock_data = array_merge($stock_data, [$sqldata]);
        }
        //製作完畢-------------------------------------------------------------------------

        $html = \View::make("admin.{$this->config['folder']}.stock", compact('stock_data', 'color_data'))->with('config', $this->config)->render();

        return \JsonResponse::create(['html' => $html])->send();
    }

    /**
     * 更新庫存數量
     */
    public function ajax_stock_upd($pid, $id)
    {
        $rule = ['num' => 'filled|numeric|integer'];
        $rule_message = [
			'num.filled'  => '數量不能為空值',
			'num.numeric' => '請輸入數字',
			'num.integer' => '請輸入整數',
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (
            \DB::table($this->config['stock_table'])->where('id', $id)->update(['num' => \Request::input('num')])
        ) {
            $message['success'] = '更新成功';
        } else {
            $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }
}