<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'project_id' => 'required|numeric|integer',
            'name' => 'required|string|max:255'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ], 422);
        }

        $team = Team::create([
            'project_id' => $request->project_id,
            'name' => $request->name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Team created Successfully',
            'team' => $team
        ], 201);
    }

    public function assignTeamMember(Request $request, Team $team)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|numeric|integer'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ], 422);
        }

        $member = $team->members()->create(['user_id' => $request->user_id]);

        return response()->json([
            'status' => true,
            'message' => 'Team Member addded Successfully',
            'team_member_id' => $member->id
        ], 201);
    }

    public function removeTeamMember(Request $request, Team $team)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|numeric|integer'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ], 422);
        }

        $member = $team->members()->where('user_id', $request->user_id)->first();
        $member->delete();

        return response()->json([
            'status' => true,
            'message' => 'Team Member removed Successfully',
            'team_member_id' => $member->id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json([
            'status' => true,
            'message' => 'Team Deleted Successfully',
            'team' => $team
        ], 200);
    }
}
