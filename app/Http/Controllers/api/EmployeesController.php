<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\absences_and_vacation;
use App\Models\activity;
use App\Models\administrative_vacation;
use App\Models\emp_courses;
use App\Models\emp_qualifications;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\employee;
use App\Models\Punishment;
use App\Models\reward;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
  public function addEmp(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required',
      'birth_date' => 'required',
      'birth_city' => 'required',
      'sector_id' => 'required',
      'work' => 'required',
      'from' => 'required',
      'nationality_id' => 'required',
      'address' => 'required',
      'childs_num' => 'required',
      'rest_place' => 'required',
      'comp_num' => 'required',
      'contracted' => 'required',
      'active' => 'required',
      'mother_name' => 'required',
      'father_name' => 'required',
      'autograph_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
      'nat_num' => 'required',
      'AppBook_num' => 'required',
      'start_date' => 'required',
      'AppBook_date' => 'required',
      'military' => 'required',
      'social_status_id' => 'required',
    ]);

    $image1 = Str::random(32) . "." . $request->autograph_photo->getClientOriginalExtension();

    $validatedData['autograph_photo'] = $image1;

    if ($request->has('subject')) {
      $validatedData['subject'] = $request->subject;
    }
    if ($request->has('tele_num')) {
      $validatedData['tele_num'] = $request->tele_num;
    }
    if ($request->has('mobile_num')) {
      $validatedData['mobile_num'] = $request->mobile_num;
    }
    if ($request->has('leave_date')) {
      $validatedData['leave_date'] = $request->leave_date;
    }
    if ($request->has('military_rank')) {
      $validatedData['military_rank'] = $request->military_rank;
    }
    if ($request->has('school')) {
      $validatedData['school'] = $request->school;
    }

    $emp = employee::create($validatedData);

    Storage::disk('publicAutographs')->put($image1, file_get_contents($request->autograph_photo));

    if (activity::where('user_id', auth()->user()->id)->count() > 19) {
      activity::where('user_id', auth()->user()->id)->first()->delete();
    }
    activity::create([
      'user_id' => auth()->user()->id,
      'name' => 'You have added an employee',
      'note' => employee::orderby('id', 'desc')->first()->id,
    ]);

    return response()->json([
      'status' => true,
      'message' => 'Employee added Successfully',
      'added_employee_id' => $emp->id,
    ]);
  }

  public function editEmp(Request $request)
  {
    $request->validate([
      'id' => 'required',
    ]);


    if (!(employee::where('id', $request->id)->exists())) {
      return response()->json([
        'status' => false,
        'message' => 'Wrong id , employee dosent exists',
      ]);
    }

    $data = $request->all();

    $emp = employee::findOrFail($request->id);

    $empArray = $emp->toArray();

    if ($request->hasFile('autograph_photo')) {
      $image1 = Str::random(32) . "." . $request->autograph_photo->getClientOriginalExtension();
      $data['autograph_photo'] = $image1;
      Storage::disk('publicAutographs')->put($image1, file_get_contents($request->autograph_photo));
    }

    foreach ($data as $key => $value) {
      if (array_key_exists($key, $empArray)) {
        $emp->{$key} = $value;
      }
    }

    $emp->save();

    return response()->json([
      'status' => true,
      'message' => "Employee edited Successfully",
    ]);
  }

  public function deleteEmp($id)
  {
    if (!(employee::where('id', $id)->exists())) {
      return response()->json([
        'status' => false,
        'message' => 'Wrong id , employee dosent exists',
      ]);
    }

    employee::where('id', $id)->delete();

    return response()->json([
      'status' => true,
      'message' => "Employee deleted Successfully",
    ]);
  }

  public function showEmps()
  {
    $var = employee::get();
    return response()->json([
      'status' => true,
      'data' => $var,
    ]);
  }

  public function addEmpQua(Request $request)
  {

    $data = $request->all();

    foreach ($data as $qua) {
      $insertData = [
        'emp_id' => $qua['emp_id'],
        'name' => $qua['name'],
        'date' => $qua['date'],
        'resource' => $qua['resource'],
      ];

      if (array_key_exists('note', $qua)) {
        $insertData['note'] = $qua['note'];
      }

      DB::table('emp_qualifications')->insert($insertData);
    }

    return response()->json([
      'status' => true,
      'message' => "added Successfully"
    ]);
  }

  public function addEmpcourse(Request $request)
  {

    $data = $request->all();

    foreach ($data as $cor) {
      $insertData = [
        'emp_id' => $cor['emp_id'],
        'name' => $cor['name'],
        'date' => $cor['date'],
        'duration' => $cor['duration'],
        'type' => $cor['type'],
        'place' => $cor['place'],
      ];
      DB::table('emp_courses')->insert($insertData);
    }

    return response()->json([
      'status' => true,
      'message' => "added Successfully"
    ]);
  }

  public function addEmpPun(Request $request)
  {
    $validatedData = $request->validate([
      'emp_id' => 'required',
      'name' => 'required',
      'type' => 'required',
      'resourse' => 'required',
      'date' => 'required',
    ]);

    if ($request->has('note'))
      $validatedData['note'] = $request->note;

    Punishment::create($validatedData);

    return response()->json([
      'status' => true,
      'message' => "punishment added Successfully"
    ]);
  }

  public function addEmpRew(Request $request)
  {
    $validatedData = $request->validate([
      'emp_id' => 'required',
      'name' => 'required',
      'type' => 'required',
      'resourse' => 'required',
      'date' => 'required',
    ]);

    if ($request->has('note'))
      $validatedData['note'] = $request->note;

    reward::create($validatedData);

    return response()->json([
      'status' => true,
      'message' => "Reward added Successfully"
    ]);
  }

  public function addEmpAbs(Request $request)
  {
    $validatedData = $request->validate([
      'emp_id' => 'required',
      'from' => 'required',
      'to' => 'required',
      'duration' => 'required',
      'reason' => 'required',
    ]);

    absences_and_vacation::create($validatedData);

    return response()->json([
      'status' => true,
      'message' => "added Successfully"
    ]);
  }

  public function addEmpVac(Request $request)
  {
    $validatedData = $request->validate([
      'emp_id' => 'required',
      'date' => 'required',
      'duration' => 'required',
      'reason' => 'required',
    ]);

    administrative_vacation::create($validatedData);

    return response()->json([
      'status' => true,
      'message' => "added Successfully"
    ]);
  }

  public function showEmpData($id)
  {
    $var = employee::where('id', $id)->get();
    $q = emp_qualifications::where('emp_id', $id)->get();
    $cor = emp_courses::where('emp_id', $id)->get();
    $p = Punishment::where('emp_id', $id)->get();
    $r = reward::where('emp_id', $id)->get();
    $ab = absences_and_vacation::where('emp_id', $id)->get();
    $v = administrative_vacation::where('emp_id', $id)->get();

    return response()->json([
      'status' => true,
      'data' => $var,
      'emp_qualifications' => $q,
      'emp_courses' => $cor,
      'punishments' => $p,
      'rewards' => $r,
      'absences_and_vacations' => $ab,
      'administrative_vacations' => $v,
    ]);
  }
}
