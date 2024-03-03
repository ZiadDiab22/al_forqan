<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\activity;
use App\Models\classs;
use App\Models\emp_request;
use App\Models\military_service;
use App\Models\nationality;
use App\Models\sector;
use App\Models\social_status;
use App\Models\subject;
use App\Models\teaching_request;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function login(Request $request)
    {

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['status' => false, 'message' => 'Invalid User'], 404);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        if (activity::where('user_id', auth()->user()->id)->count() > 19) {
            activity::where('user_id', auth()->user()->id)->first()->delete();
        }
        activity::create([
            'user_id' => auth()->user()->id,
            'name' => 'You are logged in',
        ]);

        return response(
            [
                'status' => true,
                'access_token' => $accessToken
            ],
            200
        );
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        if (activity::where('user_id', auth()->user()->id)->count() > 19) {
            activity::where('user_id', auth()->user()->id)->first()->delete();
        }
        activity::create([
            'user_id' => auth()->user()->id,
            'name' => 'You are logged out',
        ]);
        return response([
            'status' => true,
            'message' => "User logged out successfully"
        ], 200);
    }

    public function showStatuses()
    {
        $var = social_status::get();
        return response([
            'status' => true,
            'result' => $var
        ], 200);
    }

    public function showMServices()
    {
        $var = military_service::get();
        return response([
            'status' => true,
            'result' => $var
        ], 200);
    }

    public function showNats()
    {
        $var = nationality::get();
        return response([
            'status' => true,
            'nationalities' => $var
        ], 200);
    }

    public function showSectors()
    {
        $var = sector::get();
        return response([
            'status' => true,
            'sectors' => $var
        ], 200);
    }

    public function showClasses()
    {
        $var = classs::get();
        return response([
            'status' => true,
            'classes' => $var
        ], 200);
    }

    public function showSubjects()
    {
        $var = subject::get();
        return response([
            'status' => true,
            'subjects' => $var
        ], 200);
    }

    public function showTreqs()
    {
        $var = teaching_request::get();
        return response([
            'status' => true,
            'subjects' => $var
        ], 200);
    }

    public function showEreqs()
    {
        $var = emp_request::get();
        return response([
            'status' => true,
            'subjects' => $var
        ], 200);
    }

    public function showActivities(Request $request)
    {
        if (auth()->user()->id != 1 || !$request->has('id')) {
            $var = activity::where('user_id', auth()->user()->id)->orderby('id', 'desc')->get();

            return response()->json([
                'status' => true,
                'Last_activites' => $var,
            ]);
        } else
            $var = activity::where('user_id', $request->id)->orderby('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'Last_activites' => $var,
        ]);
    }
}
