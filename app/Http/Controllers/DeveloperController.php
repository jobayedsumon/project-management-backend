<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $developers = Developer::withCount('projects')->latest()->get();

        return response()->json([
            'data' => $developers,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'designation' => 'required|string',
            'email' => 'required|email|unique:developers,email',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $developer = new Developer();
        $developer->name = $request->name;
        $developer->designation = $request->designation;
        $developer->email = $request->email;
        $developer->phone = $request->phone;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/developers', $imageName);
            $developer->image = $imageName;
        }

        $developer->save();

        $project_ids = $request->project_ids ? explode(',', $request->project_ids) : [];
        $developer->projects()->sync($project_ids);

        return response()->json([
            'message' => 'Developer added successfully',
            'data' => $developer,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        $developer->load('projects');

        return response()->json([
            'data' => $developer,
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'designation' => 'required|string',
            'email' => 'required|email|unique:developers,email,' . $developer->id,
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $developer->name = $request->name;
        $developer->designation = $request->designation;
        $developer->email = $request->email;
        $developer->phone = $request->phone;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/developers', $imageName);
            $developer->image = $imageName;
        }

        $developer->save();

        $project_ids = $request->project_ids ? explode(',', $request->project_ids) : [];
        $developer->projects()->sync($project_ids);

        return response()->json([
            'message' => 'Developer updated successfully',
            'data' => $developer,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        $developer->delete();

        return response()->json([
            'message' => 'Developer deleted successfully',
        ], 200);
    }
}
