<?php

namespace App\Http\Controllers;

use App\RefRolesAccess;
use Illuminate\Http\Request;

class RefRolesAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
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
     * @param  \App\RefRolesAccess  $refRolesAccess
     * @return \Illuminate\Http\Response
     */
    public function show(RefRolesAccess $refRolesAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RefRolesAccess  $refRolesAccess
     * @return \Illuminate\Http\Response
     */
    public function edit(RefRolesAccess $refRolesAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RefRolesAccess  $refRolesAccess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefRolesAccess $refRolesAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RefRolesAccess  $refRolesAccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefRolesAccess $refRolesAccess)
    {
        //
    }
}
