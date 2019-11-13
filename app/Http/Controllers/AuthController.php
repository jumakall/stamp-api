<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\User;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|string|min:2',
            'email'             => 'required|email|unique:users',
            'password'          => 'required|string|min:6',
            'terms_of_service'  => 'accepted',
        ]);

        try {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::create([
                'name'      => $name,
                'email'     => $email,
                'password'  => $password,
                'terms_accepted_at' => Carbon::now(),
                'api_token' => Str::random(64),
                'code'      => strtolower(Str::random(10)),
            ]);

            return response([
                'api_token'     => $user->api_token,
                'name'          => $user->name,
                'is_vendor'     => false,
                'code'          => $user->code,
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(null, 500);
        }
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        $hash = app()->make('hash');
        $email = $request->input('email');
        $password = $request->input('password');
        
        try
        {
            $user = User::where('email', $email)
                        ->get()->first();

            if ($user === null || !$hash->check($password, $user->password))
                return response(['password' => ['Credentials won\'t match anything on our record.']], 401);

            return response([
                'api_token' => $user->api_token,
                'name'      => $user->name,
                'is_vendor' => (bool)$user->is_vendor,
                'code'      => $user->code,
            ], 200);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(null, 500);
        }
    }
}
