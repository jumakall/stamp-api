<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pass;
use DB;

class PassController extends Controller
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

    public function getIndex(Request $request)
    {
        $id = $request->user()->id;

        return DB::select("SELECT pass_id as id, passes.name, SUM(amount) as stamps, passes.max_stamps
        FROM stamps
            INNER JOIN passes
            ON passes.id = stamps.pass_id
        WHERE stamps.user_id = $id
        GROUP BY pass_id;");
    }
}
