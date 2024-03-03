<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\additional_course;
use App\Models\emp_exp;
use App\Models\emp_request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmpRequestController extends Controller
{
    public function addEmpRequest(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'birth_date' => 'required',
            'academic_qualification' => 'required',
            'current_work' => 'required',
            'wanted_work' => 'required',
            'social_status_id' => 'required',
            'military_service_id' => 'required',
            'address' => 'required',
            'tele_num' => 'required',
            'mobile_num' => 'required',
            'certificate_photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'identity_photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $image1 = Str::random(32) . "." . $request->certificate_photo->getClientOriginalExtension();
        $image2 = Str::random(32) . "." . $request->identity_photo->getClientOriginalExtension();

        $validatedData['certificate_photo'] = $image1;
        $validatedData['identity_photo'] = $image2;

        $req = emp_request::create($validatedData);

        Storage::disk('publicCers')->put($image1, file_get_contents($request->certificate_photo));
        Storage::disk('publicIdentities')->put($image2, file_get_contents($request->identity_photo));

        return response([
            'status' => true,
            'message' => 'request added Successfully',
            'added_request_id' => $req->id,
        ], 200);
    }

    public function addECourse(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'request_id' => 'required',
        ]);

        $cor = new additional_course();
        $cor->name = $request->name;
        $cor->request_type_id = 2;
        $cor->request_id =  $request->request_id;
        $cor->save();

        return response([
            'status' => true,
            'message' => "Course added Successfully"
        ], 200);
    }

    public function addEexp(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'request_id' => 'required',
        ]);

        emp_exp::create($validatedData);

        return response([
            'status' => true,
            'message' => "exp added Successfully"
        ], 200);
    }
}
