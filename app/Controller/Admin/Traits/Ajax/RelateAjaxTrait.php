<?php

namespace App\Controller\Admin\Traits\Ajax;

trait RelateAjaxTrait
{
    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    /**
     * 取得分類商品資料
     */
    public function ajax_relate_search()
    {
        $target_cofig = config($this->config['target_relate_config']);
        $target_table = $target_cofig['table'];
        $target_class_table = $target_cofig['class_table'] ?? '';
        $class = [];

        // 已經關聯的
        $now_relate_pid = \DB::table($this->config['relate_table'])->where([['pid', \Request::query('pid')], ['del', 0]])->pluck('relate_pid')->toArray();
        if ($target_table == $this->config['table']) {
            $now_relate_pid = array_merge($now_relate_pid, [(int) \Request::query('pid')]);
        }

        if (!empty($target_class_table) && $this->config['target_relate_group_set']) {
            // 分類
            $class = \DB::table($target_class_table)->where([['del', 0]])->orderBy('class_id', 'asc')->orderBy('no', 'desc')->orderBy('id', 'desc')->get(['id', 'class_id', 'name', 'no']);

            $class_tree = $class->groupBy('class_id');
            $class = $class->keyBy('id');

            $class_ids = get_product_rack_class_childs(0, $class_tree);
        	$class_ids_str = count($class_ids) > 0 ? implode(',', $class_ids) : 0;
        	
            $data = \DB::table($target_table)
                       ->where([['del', 0]])
                       ->whereNotIn('id', $now_relate_pid)
                       ->whereIn('class_id', $class_ids)
                       ->orderByRaw(\DB::raw("FIELD(class_id, $class_ids_str)"))
		               ->orderBy('no', 'desc')
		               ->orderBy('id', 'desc')
		               ->get()
		               ->groupBy('class_id')
		               ->transform(function ($row, $key) use ($class) {
		                    $class_name = '';
		                    $now_class_id = $key;

		                    if ($key != 0) {
			                    do {
			                        if ($class[$now_class_id]['class_id'] == 0) {
			                            $class_name = $class[$now_class_id]['name'] . $class_name;
			                        } else {
			                            $class_name = ' > ' . $class[$now_class_id]['name'] . $class_name;
			                        }

			                        $now_class_id = $class[$now_class_id]['class_id'];
			                    } while ($now_class_id != 0);

			                    $row['class_name'] = $class_name;
			                } else {
			                	$row['class_name'] = '無分類';
			                }

		                    return $row;
		               });
        } else {
            $data = \DB::table($target_table)
	                   ->when(!empty($target_class_table), function ($query) {
	                       return $query->where([['class_id', 0]]);
	                   })
	                   ->where([['del', 0]])
	                   ->whereNotIn('id', $now_relate_pid)
	                   ->orderBy('no', 'desc')
	                   ->orderBy('id', 'desc')
	                   ->get();
        }

        $need_group = $this->config['target_relate_group_set'] ? true : false;

        $html = \View::make("admin.{$this->config['folder']}.relate_options", compact('data', 'class', 'need_group'))->render();
        return \JsonResponse::create(['html' => $html])->send();
    }

    /**
     * 取得關聯
     */
    public function ajax_relate_get($pid)
    {
        if ($pid == 0) {
            // 新增時 顯示暫存
            $where = [['r.session_id', \Session::getId()], ['r.pid', $pid], ['p.del', 0]];
        } else {
            $where = [['r.pid', $pid], ['p.del', 0]];
        }

        $target_cofig = config($this->config['target_relate_config']);
        $target_table = $target_cofig['table'];

        $data = \DB::table($this->config['relate_table'] . ' as r')
	               ->leftJoin($target_table . ' as p', 'p.id', 'r.relate_pid')
	               ->select('r.id', 'r.no', 'p.name', 'p.pic')
	               ->where($where)
	               ->orderBy('id', 'desc')
	               ->get();

        $html = \View::make("admin.{$this->config['folder']}.relate", compact('data'))->render();

        return \JsonResponse::create(['html' => $html])->send();
    }

    /**
     * 新增關聯
     */
    public function ajax_relate_add($pid)
    {
        $message = ['success' => '', 'error' => ''];

        $data = [];

        foreach (\Request::input('relate_pid') as $key => $value) {
            if (\DB::table($this->config['relate_table'])->insert(['pid' => $pid, 'relate_pid' => $value, 'session_id' => \Session::getId()])) {
                $message['success'] .= $value . " 新增成功\n";
            } else {
                $message['error'] .= $value . "新增失敗\n";
            }
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 刪除關聯
     */
    public function ajax_relate_del($pid, $id)
    {
        $message = ['success' => '', 'error' => ''];

        if (\DB::table($this->config['relate_table'])->where('id', $id)->delete()) {
            $message['success'] = '刪除成功';
        } else {
            $message['error'] = '刪除失敗';
        }

        return \JsonResponse::create($message)->send();
    }
}