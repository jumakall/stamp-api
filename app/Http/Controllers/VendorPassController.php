<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Pass;

class VendorPassController extends Controller
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

    public function index(Request $request)
    {
        return $request->user()->vendor_passes;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|string|min:2',
            'max_stamps'    => 'required|integer|min:1|max:100',
        ]);

        if ($request->user()->cannot('store', Pass::class))
            return response(null, 401);

        return $request->user()->vendor_passes()->create([
            'name'          => $request->input('name'),
            'max_stamps'    => $request->input('max_stamps'),
        ]);
    }

    public function update(Request $request, $id)
    {    
        $this->validate($request, [
            'name'          => 'filled|string|min:2',
            'max_stamps'    => 'filled|integer|min:1|max:100',
        ]);

        $pass = Pass::findOrFail($id);
        if ($request->user()->cannot('update', $pass))
            return response(null, 401);
    
        $pass->fill($request->all());
        $pass->save();

        return $pass;
    }

    public function destroy(Request $request, $id)
    {
        $pass = Pass::findOrFail($id);
        if ($request->user()->cannot('destroy', $pass))
            return response(null, 401);

        $pass->delete();
        return response(null, 200);
    }
}
