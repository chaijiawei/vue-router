<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::query()->paginate(10));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(User $user, Request  $request)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user)],
            'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($user)]
        ]);
        $user->update($data);
        return new UserResource($user);
    }
}
