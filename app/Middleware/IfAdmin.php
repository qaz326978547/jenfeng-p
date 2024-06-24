<?php

namespace App\Middleware;

class IfAdmin
{
    public function handle()
    {
        if (\Session::has('admuser')) {
            return redirect('admin/index')->send();
        }

        return 'success';
    }
}