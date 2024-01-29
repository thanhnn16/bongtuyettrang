<?php

namespace App\Http\Controllers;

use App\Models\PersonalAccessToken;
use Illuminate\Http\Request;

class PersonalAccessTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalAccessToken $personalAccessToken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalAccessToken $personalAccessToken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonalAccessToken $personalAccessToken)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalAccessToken $personalAccessToken)
    {
        //
    }

    public function findToken($token) {
        return $this->where('token', hash('sha256', $token))->first();
    }
}
