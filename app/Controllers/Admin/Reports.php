<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Reports extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $userCount = $db->table('users')->countAllResults();

        return view('admin/reports/overview', ['userCount' => $userCount]);
    }
}
