<?php

namespace App\Controller;

class RedirectionController
{
	public function process()
	{
		switch (\Request::path()) {
			// case 'variable':
			// 	# code...
			// 	break;

			default:
				return redirect('', 301)->send();
				break;
		}
	}
}