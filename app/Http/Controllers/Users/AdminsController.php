<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminsController extends Controller
{

    public function index(Request $request)
    {
        $filters = $request->validate([
            'order_by' => 'nullable|string|in:name,email,created_at',
            'order_direction' => 'nullable|string|in:asc,desc',
            'search' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'role_id' => 'nullable|integer|exists:account_roles,account_role_id',
            'gender_id' => 'nullable|integer|exists:genders,gender_id',
            'status_id' => 'nullable|integer|exists:account_statuses,account_status_id',
        ]);

        $users = User::with([
            'gender',
            'accountStatus',
            'accountRole',
        ])
            ->when($filters['search'] ?? null, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->when($filters['role_id'] ?? null, function ($query, $roleId) {
                return $query->where('account_role_id', $roleId);
            })
            ->when($filters['gender_id'] ?? null, function ($query, $genderId) {
                return $query->where('gender_id', $genderId);
            })
            ->when($filters['status_id'] ?? null, function ($query, $statusId) {
                return $query->where('account_status_id', $statusId);
            })
            ->when($filters['order_by'] ?? null, function ($query, $orderBy, $orderDirection = 'asc') use ($filters) {
                $orderDirection = $filters['order_direction'] ?? 'asc';
                return $query->orderBy($orderBy, $orderDirection);
            }, function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->paginate($filters['per_page'] ?? 10);

        return response()->json($users, Response::HTTP_OK);

    }

    public function show(string $username)
    {

        $user = User::with([
            'gender',
            'accountStatus',
            'accountRole',
        ])
            ->where('username', $username)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($user, Response::HTTP_OK);
    }

    public function update(Request $request, string $username)
    {
        $user = User::where('username', $username)->first();

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
            'account_status_id' => 'nullable|exists:account_statuses,account_status_id',
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

        return response()->json(['message' => 'User updated successfully'], Response::HTTP_OK);
    }


    public function destroy(string $username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
}
