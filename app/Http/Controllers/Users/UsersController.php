<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{

    public function create (Request $request) {

        $requestData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|regex:/^@[\w]+$/|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dob' => 'nullable|date',
            'current_address' => 'nullable|string|max:255',
            'gender_id' => 'required|exists:genders,gender_id',
        ]);

        User::create([
            'name' => $requestData['name'],
            'username' => $requestData['username'],
            'email' => $requestData['email'],
            'password' => bcrypt($requestData['password']),
            'avatar' => $requestData['avatar'] ?? null,
            'dob' => $requestData['dob'] ?? null,
            'current_address' => $requestData['current_address'] ?? null,
            'gender_id' => $requestData['gender_id'],
            'account_status_id' => 2,
            'account_role_id' => 1,
        ]);

        return response()->json([
            'message' => 'User created successfully.',
        ], Response::HTTP_CREATED);
    }

    public function show () {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $user = User::with([
            'gender',
            'accountStatus',
            'accountRole',
        ])->where('username', $user->username)->first();

        return response()->json($user, Response::HTTP_OK);
    }

    public function update (Request $request) {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $requestData = $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|regex:/^@[\w]+$/|max:255|unique:users,username,' . $user->user_id,
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->user_id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dob' => 'nullable|date',
            'current_address' => 'nullable|string|max:255',
            'gender_id' => 'nullable|exists:genders,gender_id',
            'account_role_id' => 'nullable|exists:account_roles,account_role_id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->fill(collect($requestData)->except(['avatar', 'password'])->toArray());

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if (!empty($requestData['password'])) {
            $user->password = bcrypt($requestData['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user,
        ], Response::HTTP_OK);
    }
}
