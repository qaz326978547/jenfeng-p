<?php

namespace App\Controller\Admin\Traits\Ajax;

trait UpdAjaxTrait
{
    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    /**
     * 更新 選擇器
     */
    public function ajax_upd($id, $column)
    {
        switch ($column) {
            case 'act':
                $this->ajax_upd_act($id);
                break;
            case 'no':
                $this->ajax_upd_no($id, $column);
                break;
            default:
                $message = ['success' => '', 'error' => ''];

                if (
                    \DB::table($this->config['table'])->where('id', $id)->update([$column => \Request::input('value')])
                ) {
                    $message['success'] = '更新成功';
                } else {
                    $message['error'] = '更新失敗,欄位參數：' . $column;
                }

                return \JsonResponse::create($message)->send();
                break;
        }
    }

    /**
     * 更新上架
     */
    protected function ajax_upd_act($id)
    {
        $type = \Request::input('type', 'common');
        $rule_mode = \Request::input('rule_mode', 'all');

        $rule = [
            'col' => "checkbox_num_limit:{$this->config['table']},{$this->config[\Request::input('col') . '_num']},{$type},{$rule_mode}",
        ];
        $rule_message = [
            'col.checkbox_num_limit' => $this->config['rule_message'][\Request::input('col') . '.checkbox_num_limit'],
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (
            \DB::table($this->config['table'])->where('id', $id)->update([\Request::input('col') => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 更新排序
     */
    protected function ajax_upd_no($id, $column)
    {
        $rule = ['value' => 'filled|numeric'];
        $rule_message = [
			'value.filled'  => '排序 不能為空值',
			'value.numeric' => '排序 請輸入數字',
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (
            \DB::table($this->config['table'])->where('id', $id)->update([$column => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }
}