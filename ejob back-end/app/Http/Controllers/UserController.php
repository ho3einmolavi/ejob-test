<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return _response('' , 400 , "wrong information");
        }

        return _response($this->respondWithToken($token) , 200 , "Login was successful");
    }

    public function register(CreateRequest $request)
    {
        $user = $this->repository->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = auth('api')->login($user);
        //$token = auth('api')->setTTL(7200)->login($user);
        return _response($this->respondWithToken($token) , 200 , "Register was successful");
    }

    public function me()
    {
        return _response(new UserResource(auth()->user()));
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ];
    }
}
