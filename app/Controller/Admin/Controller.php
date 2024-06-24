<?php

namespace App\Controller\Admin;

use App\Controller\UploadTrait;

abstract class Controller
{
    use UploadTrait;

    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    /**
     * 檔案清理 - 透過id 欄位名稱 找出檔案路徑
     *
     * @param  int $id
     * @param  string $column
     * @return void
     */
    protected function clear_file($id, $column)
    {
        $path = \DB::table($this->config['table'])->where('id', $id)->value($column);

        \Storage::delete(str_replace(storage_path(), '', $path));
    }

    /**
     * 資料表/硬碟暫存清除
     *
     * @param  string $table
     * @param  string $rel_column 關聯欄位
     * @param  mixed $rel_value 關聯數值
     * @param  string $column 要取得的欄位名稱
     * @return int
     */
    protected function temp_clear($table, $rel_column, $rel_value, $column = 'id')
    {
        // 清理30分鐘以前的全部暫存資料
        $old_data = \DB::table($table)->where([[$rel_column, $rel_value], ['created_at', '<', \Date::now()->subMinutes(30)]])->pluck($column)->toArray();
        $column != 'id' and \Storage::delete(str_replace(storage_path(), '', $old_data));
        \DB::table($table)->where([[$rel_column, $rel_value], ['created_at', '<', \Date::now()->subMinutes(30)]])->delete();

        $data = \DB::table($table)->where([[$rel_column, $rel_value], ['session_id', \Session::getId()]])->pluck($column)->toArray();
        // 圖片或檔案刪除
        $column != 'id' and \Storage::delete(str_replace(storage_path(), '', $data));
        // 資料刪除
        return \DB::table($table)->where([[$rel_column, $rel_value], ['session_id', \Session::getId()]])->delete();
    }

    /**
     * 資料表暫存寫入
     *
     * @param  string $table
     * @param  string $rel_column 關聯欄位
     * @param  mixed $rel_value 關聯數值
     * @param  mixed $temp_value 暫存數值
     * @return int
     */
    protected function temp_write($table, $rel_column, $rel_value, $temp_value = 0)
    {
        return \DB::table($table)->where([[$rel_column, $temp_value], ['session_id', \Session::getId()]])->update([$rel_column => $rel_value]);
    }

    /**
     * 搜尋檢查 (找出 key 為 search_ 開頭)
     *
     * @param  array  $array
     * @param  string  $as
     * @param  array  $str_is 擴充用
     * @return array
     */
    protected function search_check(array $query, $as = '', array $str_is = ['search_*'])
    {
        $array = \Collection::make($query)
            ->filter(function ($value, $key) use ($str_is) {
                foreach ($str_is as $str) {
                    if (\Str::is($str, $key)) {
                        return $value;
                    }
                }
            })
            ->toArray();

        $search = [];
        $replace = str_replace('*', '', $str_is);

        foreach ($array as $key => $value) {
            $search = array_merge($search, [[str_replace($replace, $as, $key), 'like', '%' . $value . '%']]);
        }

        return $search;
    }

    /**
     * 軟刪除
     *
     * @param  int|array $id
     * @param  string $table
     * @param  string $rel_column
     * @return int
     */
    protected function soft_delete($id, $table, $rel_column = 'id')
    {
        if (is_array($id)) {
            return \DB::table($table)->whereIn($rel_column, $id)->update(['del' => 1]);
        } else {
            return \DB::table($table)->where($rel_column, $id)->update(['del' => 1]);
        }
    }

    /**
     * 真實刪除
     *
     * @param  int|array $id
     * @param  string $table
     * @param  string $rel_column
     * @return int
     */
    protected function true_delete($id, $table, $rel_column = 'id')
    {
        if (is_array($id)) {
            return \DB::table($table)->whereIn($rel_column, $id)->delete();
        } else {
            return \DB::table($table)->where($rel_column, $id)->delete();
        }
    }
}
