<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\additional_course;
use App\Models\classs;
use App\Models\desired_subject;
use App\Models\emp_exp;
use App\Models\emp_request;
use App\Models\employee;
use App\Models\previous_subject;
use App\Models\subject_classs;
use App\Models\teacher_exp;
use App\Models\teaching_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function searchSubjectsbyClass(Request $request)
    {
        $var = classs::where('name', 'like', '%' . $request->name . '%')->get();

        if ($var->isEmpty())
            return response([
                'status' => 0,
                'message' => 'no results'
            ], 404);

        else
            $var = subject_classs::where('class_id', $var[0]['id'])
                ->join('subjects', 'subject_classses.subject_id', 'subjects.id')
                ->get([
                    'subject_classses.class_id', 'subjects.id as subject_id',
                    'subjects.name as subject_name',
                ]);

        return response([
            'status' => true,
            'message' => $var
        ], 200);
    }

    public function searchTReqs(Request $request)
    {
        $var = DB::table('teaching_requests')
            ->where('teaching_requests.name', 'like', '%' . $request->value . '%')
            ->orWhere('teaching_requests.academic_qualification', 'like', '%' . $request->value . '%')
            ->select(
                'name',
                'birth_date',
                'birth_city',
                'created_at',
                'study_place',
                'academic_qualification',
                'issuing_authority',
                'acquisition_year',
                'address',
                'tele_num',
                'mobile_num',
                'rating',
            );
        $var2 = DB::table('desired_subjects')
            ->where('desired_subjects.name', 'like', '%' . $request->value . '%')
            ->join('teaching_requests', 'desired_subjects.request_id', 'teaching_requests.id')
            ->select(
                'teaching_requests.name',
                'birth_date',
                'birth_city',
                'created_at',
                'study_place',
                'academic_qualification',
                'issuing_authority',
                'acquisition_year',
                'address',
                'tele_num',
                'mobile_num',
                'rating'
            )->union($var)->get();

        return response([
            'status' => true,
            'message' => $var2
        ], 200);
    }

    public function searchEReqs(Request $request)
    {
        $var = emp_request::where('name', 'like', '%' . $request->value . '%')
            ->orWhere('academic_qualification', 'like', '%' . $request->value . '%')
            ->orWhere('wanted_work', 'like', '%' . $request->value . '%')->get();

        return response()->json([
            'status' => true,
            'data' => $var,
        ]);
    }

    public function searchEmp(Request $request)
    {
        $var = employee::where('name', 'like', '%' . $request->name . '%')->get();

        if ($var->isEmpty())
            return response([
                'status' => 0,
                'message' => 'no results'
            ], 404);

        else return response([
            'status' => true,
            'message' => $var
        ], 200);
    }

    public function orderTreqs(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);

        if ($request->value == 'r') {
            $var = teaching_request::orderBy('rating', 'desc')->orderBy('created_at', 'desc')->get();
        } else if ($request->value == 'd') {
            $var = teaching_request::orderBy('created_at', 'desc')->get();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid value. Expected d or r.'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => $var
        ]);
    }

    public function orderEreqs(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);

        if ($request->value == 'r') {
            $var = emp_request::orderBy('rating', 'desc')->orderBy('created_at', 'desc')->get();
        } else if ($request->value == 'd') {
            $var = emp_request::orderBy('created_at', 'desc')->get();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid value. Expected d or r.'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => $var
        ]);
    }

    public function showReqData(Request $request)
    {
        $request->validate([
            'type' => 'integer|required',
            'id' => 'integer|required',
        ]);

        if ($request->type == 1) {
            $var = teaching_request::where('teaching_requests.id', $request->id)
                ->join('nationalities', 'teaching_requests.nationality_id', 'nationalities.id')
                ->join('military_services', 'teaching_requests.military_service_id', 'military_services.id')
                ->join('social_statuses', 'teaching_requests.social_status_id', 'social_statuses.id')
                ->get([
                    'teaching_requests.id as request_id', 'teaching_requests.name', 'birth_date',
                    'birth_city', 'academic_qualification', 'issuing_authority',
                    'acquisition_year', 'study_place', 'address',
                    'tele_num', 'mobile_num', 'rating', 'social_statuses.name as social status',
                    'military_services.name as military_service', 'nationalities.name as nationality', 'created_at'
                ]);
            $sub1 = previous_subject::where('request_id', $request->id)->get();
            $sub2 = desired_subject::where('request_id', $request->id)->get();
            $cor = additional_course::where('request_id', $request->id)->where('request_type_id', $request->type)->get();
            $ex1 = teacher_exp::where('request_id', $request->id)->get();

            return response()->json([
                'status' => true,
                'data' => $var,
                'previous_subject' => $sub1,
                'desired_subject' => $sub2,
                'skills_and_courses' => $cor,
                'experiences' => $ex1,
            ]);
        }

        if ($request->type == 2) {
            $var = emp_request::where('emp_requests.id', $request->id)
                ->join('military_services', 'emp_requests.military_service_id', 'military_services.id')
                ->join('social_statuses', 'emp_requests.social_status_id', 'social_statuses.id')
                ->get([
                    'emp_requests.id as request_id', 'emp_requests.name', 'birth_date',
                    'wanted_work', 'current_work', 'academic_qualification',
                    'identity_photo', 'certificate_photo', 'management_opinion', 'manager', 'address',
                    'tele_num', 'mobile_num', 'social_statuses.name as social status',
                    'military_services.name as military_service', 'rating', 'created_at'
                ]);
            $cor = additional_course::where('request_id', $request->id)->where('request_type_id', $request->type)->get();
            $ex1 = emp_exp::where('request_id', $request->id)->get();

            return response()->json([
                'status' => true,
                'data' => $var,
                'skills_and_courses' => $cor,
                'experiences' => $ex1,
            ]);
        }
    }

    public function filterEmps(Request $request)
    {
        $query = employee::query();

        if ($request->has('type_id')) {
            if ($request->input('type_id') == 1)
                $query->whereNotNull('subject');
            else $query->whereNull('subject');
        }

        if ($request->has('subject'))
            $query->where('subject', 'like', '%' . $request->subject . '%');

        if ($request->has('work'))
            $query->where('work', 'like', '%' . $request->work . '%');

        if ($request->has('sector_id')) {
            $query->where('sector_id', $request->input('sector_id'));
        }

        if ($request->has('contracted')) {
            $query->where('contracted', $request->input('contracted'));
        }

        if ($request->has('active')) {
            $query->where('active', $request->input('active'));
        }

        $employees = $query->get();

        return response()->json([
            'status' => true,
            'data' => $employees,
        ]);
    }
}
