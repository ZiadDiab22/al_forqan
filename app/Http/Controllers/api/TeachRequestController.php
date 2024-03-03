<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\teacher_exp;
use App\Models\teaching_request;
use App\Models\previous_subject;
use App\Models\additional_course;
use App\Models\desired_subject;
use Illuminate\Support\Facades\DB;

class TeachRequestController extends Controller
{
    public function addTeachingRequest(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'birth_date' => 'required',
            'birth_city' => 'required',
            'nationality_id' => 'required',
            'academic_qualification' => 'required',
            'issuing_authority' => 'required',
            'acquisition_year' => 'required',
            'study_place' => 'required',
            'social_status_id' => 'required',
            'military_service_id' => 'required',
            'address' => 'required',
            'tele_num' => 'required',
            'mobile_num' => 'required',
        ]);

        $req = teaching_request::create($validatedData);

        return response([
            'status' => true,
            'message' => 'request added Successfully',
            'added_request_id' => $req->id,
        ], 200);
    }

    public function editTeachingRequest(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);


        if (!(teaching_request::where('id', $request->id)->exists())) {
            return response()->json([
                'status' => false,
                'message' => 'Wrong id , request dosent exists',
            ]);
        }

        $data = $request->all();

        $req = teaching_request::findOrFail($request->id);

        $reqArray = $req->toArray();

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $reqArray)) {
                $req->{$key} = $value;
            }
        }

        $req->save();

        return response()->json([
            'status' => true,
            'message' => "request edited Successfully",
        ]);
    }

    public function deleteTeachingRequest($id)
    {
        if (!(teaching_request::where('id', $id)->exists())) {
            return response()->json([
                'status' => false,
                'message' => 'Wrong id , request dosent exists',
            ]);
        }

        teaching_request::where('id', $id)->delete();

        return response()->json([
            'status' => true,
            'message' => "request deleted Successfully",
        ]);
    }

    public function addTCourse(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'request_id' => 'required',
        ]);

        $cor = new additional_course();
        $cor->name = $request->name;
        $cor->request_type_id = 1;
        $cor->request_id =  $request->request_id;
        $cor->save();

        return response([
            'status' => true,
            'message' => "Course added Successfully"
        ], 200);
    }

    public function addPSub(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'request_id' => 'required',
        ]);

        $sub = new previous_subject();
        $sub->name = $request->name;
        $sub->request_id =  $request->request_id;
        $sub->save();

        return response([
            'status' => true,
            'message' => "subject added Successfully"
        ], 200);
    }

    public function addDSub(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'request_id' => 'required',
        ]);

        $sub = new desired_subject();
        $sub->name = $request->name;
        $sub->request_id =  $request->request_id;
        $sub->save();

        return response([
            'status' => true,
            'message' => "subject added Successfully"
        ], 200);
    }

    public function addTexp(Request $request)
    {
        $request->validate([
            'work' => 'required',
            'work_place' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'request_id' => 'required',
        ]);

        $exp = new teacher_exp();
        $exp->work = $request->work;
        $exp->work_place = $request->work_place;
        $exp->from_date = $request->from_date;
        $exp->to_date = $request->to_date;
        $exp->request_id = $request->request_id;

        $diffInMonths = Carbon::parse($request->from_date)->diffInMonths(Carbon::parse($request->to_date));
        $exp->years_num = round($diffInMonths / 12, 2);

        $exp->save();

        return response([
            'status' => true,
            'message' => "exp added Successfully"
        ], 200);
    }
}
