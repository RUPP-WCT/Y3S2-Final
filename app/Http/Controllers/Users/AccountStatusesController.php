<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\AccountStatuses;
use Illuminate\Http\Request;

class AccountStatusesController extends Controller
{
    public function index () {
        $statuses = AccountStatuses::all();
        return response()->json($statuses);
    }
}
