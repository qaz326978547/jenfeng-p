<?php
// AhWei - fezexp9987@gmail.com - line: fezexp

namespace AhWei\DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Repository
{
    protected static $db;

    public static function table($table)
    {
        self::$db = DB::table($table);

        return new self();
    }

    public static function raw($value)
    {
        return DB::raw($value);
    }

    public function __call($method_name, $arguments)
    {
        // 最後回傳結果區
        $end_methood = [
            'insert',           // return int
            'insertGetId',      // return int
            'insertUsing',      // return bool
            'create',           // return Model|$this
            'update',           // return int
            'updateOrInsert',   // return bool
            'delete',           // return mixed
            'increment',        // return int
            'decrement',        // return int

            'find',             // return Model|Collection|Builder[]|Builder|null
            'first',            // return Model|object|BuildsQueries|null
            'value',            // return mixed
            'pluck',            // return Collection
            'get',              // return Collection|Builder[]
            'paginate',         // return LengthAwarePaginator
            'simplePaginate',   // return Paginator

            'exists',           // return bool
            'doesntExist',      // return bool

            'count',            // return int
            'min',              // return mixed
            'max',              // return mixed
            'sum',              // return mixed
            'avg',              // return mixed
            'average',          // return mixed
            'aggregate',        // return mixed
            'numericAggregate', // return mixed

            'implode',          // return string

            'findMany',         // return Collection
            'findOrFail',       // return Model|Collection
            'findOrNew',        // return Model
            'firstOrNew',       // return Model
            'firstOrCreate',    // return Model
            'updateOrCreate',   // return Model
            'firstOrFail',      // return Model|Builder
            'forceCreate',      // return Model|$this
            'forceDelete',      // return mixed
            'chunk',            // return bool
            'each',             // return bool
            'matching',         // return Builder
            'getQuery',         // return Builder
            'getBindings',      // return array
            'getRawBindings',   // return array
            'getModel',         // return Model
            'newQuery',         // return Builder

            'truncate',         // return void
            'toSql',            // return strung
        ];

        if (in_array($method_name, $end_methood)) {
            // 寫入創建時間 更新時間
            if ($method_name == 'insert' or $method_name == 'insertGetId') {
                $arguments[0] = array_merge($arguments[0], ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            }

            // 寫入更新時間
            if ($method_name == 'update') {
                $arguments[0] = array_merge($arguments[0], ['updated_at' => Carbon::now()]);
            }

            return self::$db->{$method_name}(...$arguments);

        } else {
            self::$db = self::$db->{$method_name}(...$arguments);

            return new self();
        }
    }
}