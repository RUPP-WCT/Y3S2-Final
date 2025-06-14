<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\AccountRoles;
use Illuminate\Http\Request;

class AccountRolesController extends Controller
{
    public function index () {
        $roles = AccountRoles::all();
        return response()->json($roles);
    }
}
