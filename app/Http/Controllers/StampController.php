<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Stamp;
use App\Pass;
use App\User;

class StampController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount'        => 'required|integer|min:1|max:100',
            'pass_id'       => 'required|integer',
            'code'          => 'required|string',
        ]);

        $pass = Pass::where('id', $request->input('pass_id'))
                    ->get()->first();

        if ($pass == null)
            return response(null, 422);

        if ($request->user()->cannot('stamp', $pass))
            return response(null, 401);

        $customer = User::where('code', $request->input('code'))
                        ->get()->first();
        
        if ($customer == null)
            return response(null, 422);
            
        $customer->passes()->attach(
            $request->input('pass_id'),
            [ 'amount' => $request->input('amount') ]
        );

        return response(null, 200);
    }
}
