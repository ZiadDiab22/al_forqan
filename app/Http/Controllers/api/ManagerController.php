<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\activity;
use App\Models\emp_request;
use App\Models\employee;
use App\Models\experience;
use App\Models\role;
use App\Models\teaching_request;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|unique:users',
        ]);
        $user = new User();

        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->role_id = 7;
        $user->save();

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'status' => true,
            'user' => $user,
            'message' => 'User Created Successfully',
            'access_token' => $accessToken
        ]);
    }

    public function editUserRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        if (!(User::where('id', $request->user_id)->exists())) {
            return response()->json([
                'status' => false,
                'message' => 'not found , Wrong Id'
            ]);
        }

        $user = User::findOrFail($request->user_id);
        $user->role_id = $request->role_id;
        $user->save();

        return response([
            'status' => true,
            'message' => 'edited Successfully'
        ]);
    }

    public function showRoles()
    {
        $var = role::get();
        return response([
            'status' => true,
            'roles' => $var
        ], 200);
    }

    public function addRole(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        role::create($validatedData);

        return response([
            'status' => true,
            'message' => 'role Added Successfully',
        ]);
    }

    public function deleteRole(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $var = role::where('id', $request->id)->delete();
        return response([
            'status' => true,
            'message' => 'role deleted Successfully',
        ], 200);
    }

    public function rateTreq(Request $request)
    {
        $request->validate([
            'request_id' => 'required',
            'rating' => 'required|numeric|between:0,10',
        ]);
        $var = teaching_request::find($request->request_id);

        if (!$var) {
            return response()->json([
                'message' => "request doesn't exist."
            ], 404);
        }

        $var->update(['rating' => $request->rating]);

        if (activity::where('user_id', auth()->user()->id)->count() > 19) {
            activity::where('user_id', auth()->user()->id)->first()->delete();
        }
        activity::create([
            'user_id' => auth()->user()->id,
            'name' => 'You have evaluated a teaching request',
            'note' => $request->request_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Rating added successfully"
        ]);
    }

    public function rateEreq(Request $request)
    {
        $request->validate([
            'request_id' => 'required',
            'rating' => 'required|numeric|between:0,10',
        ]);
        $var = emp_request::find($request->request_id);

        if (!$var) {
            return response()->json([
                'message' => "request doesn't exist."
            ], 404);
        }

        $var->update(['rating' => $request->rating]);

        if (activity::where('user_id', auth()->user()->id)->count() > 19) {
            activity::where('user_id', auth()->user()->id)->first()->delete();
        }
        activity::create([
            'user_id' => auth()->user()->id,
            'name' => 'You have evaluated a job request',
            'note' => $request->request_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Rating added successfully"
        ]);
    }

    public function addExp(Request $request)
    {

        $data = $request->all();

        foreach ($data as $exp) {
            $insertData = [
                'emp_id' => $exp['emp_id'],
                'subject_id' => $exp['subject_id'],
                'class_id' => $exp['class_id'],
                'year' => $exp['year'],
                'hours_num' => $exp['hours_num']
            ];
            DB::table('experiences')->insert($insertData);
        }

        if (activity::where('user_id', auth()->user()->id)->count() > 19) {
            activity::where('user_id', auth()->user()->id)->first()->delete();
        }
        activity::create([
            'user_id' => auth()->user()->id,
            'name' => 'You have added an experience',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'added successfully.'
        ]);
    }

    public function showEmpExp($id)
    {
        $var = experience::where('emp_id', $id)
            ->join('subjects', 'experiences.subject_id', 'subjects.id')
            ->join('classses', 'experiences.class_id', 'classses.id')
            ->get([
                'experiences.id', 'emp_id', 'subjects.name as subject',
                'classses.name as class', 'year', 'hours_num',
            ]);

        $emp = employee::where('id', $id)->get(['name']);
        if ($emp->isEmpty()) {
            return response()->json([
                'message' => 'employee not found',
            ]);
        }
        $exp = null;
        $req = emp_request::where('name', $emp[0]['name'])->get(['id']);
        if (!$req->isEmpty()) {
            $req = emp_request::find($req[0]['id']);
            $exp = $req->empExps;
        } else {
            $req = teaching_request::where('name', $emp[0]['name'])->get(['id']);
            if (!$req->isEmpty()) {
                $req = teaching_request::find($req[0]['id']);
                $exp = $req->teachExps;
            }
        }

        return response()->json([
            'status' => true,
            'experiences_in_school' => $var,
            'experiences_outside_school' => $exp,
        ]);
    }
}
