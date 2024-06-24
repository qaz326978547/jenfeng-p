<?php

namespace App\Middleware;

class BrowseRecord
{
    public function handle()
    {
    	if (! \Str::contains(\Request::path(), ['admin', 'cron']) && ! \Agent::isRobot()) {
			$date = \Date::now()->toDateString();

			if (\DB::table(config('browse.record_table'))->where([['date', $date]])->doesntExist()) {
				\DB::table(config('browse.record_table'))->insert(['num' => 0, 'date' => $date]);
			}

			// 檢查 session 今天是否已經記錄
			if (\Session::get('browse_record_check.' . $date) != true) {
				\DB::table(config('browse.record_table'))->where([['date', $date]])->increment('num');
				\Session::put('browse_record_check.' . $date, true);

				$ips = [
		            'HTTP_CLIENT_IP'           => \Request::server('HTTP_CLIENT_IP'),
		            'HTTP_X_FORWARDED_FOR'     => \Request::server('HTTP_X_FORWARDED_FOR'),
		            'HTTP_X_FORWARDED'         => \Request::server('HTTP_X_FORWARDED'),
		            'HTTP_X_CLUSTER_CLIENT_IP' => \Request::server('HTTP_X_CLUSTER_CLIENT_IP'),
		            'HTTP_FORWARDED_FOR'       => \Request::server('HTTP_FORWARDED_FOR'),
		            'HTTP_FORWARDED'           => \Request::server('HTTP_FORWARDED'),
		            'REMOTE_ADDR'              => \Request::server('REMOTE_ADDR'),
		            'HTTP_VIA'                 => \Request::server('HTTP_VIA'),
		        ];

				\Log::channel('browse-record')->info($date . ' :', $ips);
			}	
		}	

        return 'success';
    }
}