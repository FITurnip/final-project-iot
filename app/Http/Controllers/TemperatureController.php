<?php

namespace App\Http\Controllers;

use App\Models\Temperature;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TemperatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $temperatureDatas = Temperature::all();
        $fetchTime = Carbon::now();
        $fetchTime = $fetchTime->toDateTimeString();

        return response()->json(compact('temperatureDatas','fetchTime'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $storeData = [
            'temp'=>$request->temp,
            'change_temp'=>$request->change_temp,
        ];

        Temperature::create($storeData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Temperature $temperature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Temperature $temperature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Temperature $temperature)
    {
        //
    }
}
