<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
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

    public function store(StoreProfileRequest $request)
    {
        $user_id = Auth::user()->id;
        $validated =  $request->validated();
        $validated['user_id'] = $user_id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("photos", 'public');
            $validated['imega'] = $path;
        }
        
        $profile = Profile::create($validated);

        return response()->json($profile, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $profile = Profile::where('user_id', $id)->first();

        return response()->json($profile, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
