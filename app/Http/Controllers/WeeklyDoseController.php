<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeeklyDoseRequest;
use App\Models\WeeklyDose;

class WeeklyDoseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('weeklydose')->with([
            'weeklydoses' => WeeklyDose::all()->sortByDesc('created_at'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\WeeklyDoseRequest  $request
     * @return \App\Models\WeeklyDose
     */
    public function store(WeeklyDoseRequest $request)
    {
        $validated = $request->validated();

        return WeeklyDose::create([
            'description' => $validated['description'],
            'url' => $validated['url'],
            'recommended_by' => $validated['recommended_by'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Social\WeeklyDose  $weeklyDose
     * @return void
     */
    public function show(WeeklyDose $weeklyDose)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Social\WeeklyDose  $weeklyDose
     * @return void
     */
    public function edit(WeeklyDose $weeklyDose)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\WeeklyDoseRequest  $request
     * @param  \App\Models\Social\WeeklyDose  $weeklyDose
     * @return void
     */
    public function update(WeeklyDoseRequest $request, WeeklyDose $weeklyDose)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Social\WeeklyDose  $weeklyDose
     * @return void
     */
    public function destroy(WeeklyDose $weeklyDose)
    {
        //
    }
}
