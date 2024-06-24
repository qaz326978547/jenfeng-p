<?php

if (!function_exists('get_product_rack_path')) {
    // 路徑
    function get_product_rack_path($config, $class_id = 0, $cid = 0, $pid = 0)
    {
        $table = $config['table'];
        $link_tag = \Str::is('*_class', $config['link_tag']) ? $config['link_tag'] : $config['link_tag'] . '_class';

        echo '目前路徑 > <a href="' . url('admin/' . $link_tag . '/0') . '" >根目錄</a>';
        $path = '';

        if (!empty($pid)) {
            $data = \DB::table("$table")->find($pid);
            $path = ' > ' . $data['name'] . ' (修改)';
        }

        $table = \Str::is('*_class', $table) ? $config['table'] : $config['table'] . '_class';

        if (!empty($cid)) {
            $data = \DB::table("$table")->find($cid);
            $path = ' > ' . $data['name'] . ' (修改)';
        }

        if (!empty($class_id)) {
            $data = \DB::table("$table")->find($class_id);
            $path = ' > ' . '<a href="' . url('admin/' . $link_tag, ['class_id' => $data['id']]) . '" >' . $data['name'] . '</a>' . $path;
            $history = explode(';', $data['history']);
            $data = \DB::table("$table")->whereIn('id', $history)->orderBy('id', 'asc')->get();
            foreach ($data as $key => $value) {
                echo ' > ';
                echo '<a href="' . url('admin/' . $link_tag, ['class_id' => $value['id']]) . '" >';
                echo $value['name'];
                echo '</a>';
            }
        }

        echo $path;
    }
}

if (!function_exists('get_product_rack_class_select')) {
    // 分類 select
    function get_product_rack_class_select($found, $config)
    {
        $folder = config($config)['folder'];
        $class_table = config($config)['class_table'];
        $sys_level = config($config . '_class')['sys_level'];
        $class_tree = \DB::table($class_table)->where([['del', 0]])->orderBy('no', 'desc')->orderBy('id', 'desc')->get()->groupBy('class_id');

        return \View::make("admin.{$folder}.class_select", compact('found', 'sys_level', 'class_tree', 'folder'))->render();
    }
}

if (!function_exists('get_product_rack_class_options')) {
    // 分類 options
    function get_product_rack_class_options($class_id, $found, $sys_level, $class_tree, $folder)
    {
        return \View::make("admin.{$folder}.class_options", compact('class_id', 'found', 'sys_level', 'class_tree', 'folder'))->render();
    }
}

if (!function_exists('get_product_rack_class_childs')) {
    // 分類 childs
    function get_product_rack_class_childs($id, $class_tree, $child_ids = array())
    {

        if (!empty($class_tree[$id])) {
            foreach ($class_tree[$id] as $class) {
                array_push($child_ids, $class['id']);
                $child_ids = get_product_rack_class_childs($class['id'], $class_tree, $child_ids);
            }
        }

        return $child_ids;
    }
}