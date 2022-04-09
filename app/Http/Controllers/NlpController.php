<?php

namespace App\Http\Controllers;

use App\Models\Nlp;
use Illuminate\Http\Request;

class NlpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Nlp::filter($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nlp  $nlp
     * @return \Illuminate\Http\Response
     */
    public function show(Nlp $nlp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nlp  $nlp
     * @return \Illuminate\Http\Response
     */
    public function edit(Nlp $nlp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nlp  $nlp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nlp $nlp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nlp  $nlp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nlp $nlp)
    {
        //
    }
}
