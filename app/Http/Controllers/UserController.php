<?php

namespace App\Http\Controllers;

use App\Http\Requests\users\UserCreateRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function createuser(UserCreateRequest $request): mixed
    {
        //validation data
        $validated = $request->validated();

        // save user on database
        $response = $this->users->CreateUser($validated);

        // return response json
        return response()->json([
            $response
        ]);
    }
}
