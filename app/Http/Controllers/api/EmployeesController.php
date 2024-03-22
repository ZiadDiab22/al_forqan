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
use Illuminate\Support\Arr;
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

    if ($request->has('emp_id')) {

      if (!(employee::where('id', $request->emp_id)->exists())) {
        return response()->json([
          'status' => false,
          'message' => 'Wrong id , employee dosent exists',
        ]);
      }

      $data = $request->all();

      $emp = employee::findOrFail($request->emp_id);

      if ($request->hasFile('autograph_photo')) {
        $image1 = Str::random(32) . "." . $request->autograph_photo->getClientOriginalExtension();
        $data['autograph_photo'] = $image1;
        Storage::disk('publicAutographs')->put($image1, file_get_contents($request->autograph_photo));
      }

      $emp->update($data);

      return response()->json([
        'status' => true,
        'message' => "Employee edited Successfully",
      ]);
    }

    if ($request->has('autograph_photo')) {
      $image1 = Str::random(32) . "." . $request->autograph_photo->getClientOriginalExtension();
      $validatedData['autograph_photo'] = $image1;
      Storage::disk('publicAutographs')->put($image1, file_get_contents($request->autograph_photo));
    }

    $headers = ['subject', 'tele_num', 'mobile_num', 'leave_date', 'military_rank', 'school'];

    foreach ($headers as $h) {
      if ($request->has($h)) {
        $validatedData[$h] = $request->{$h};
      }
    }

    $emp = employee::create($validatedData);

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

    emp_qualifications::where('emp_id', $data['qua1']['emp_id'])->delete();

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

    emp_courses::where('emp_id', $data['cor1']['emp_id'])->delete();

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
    $data = $request->all();

    Punishment::where('emp_id', $data['pun1']['emp_id'])->delete();

    foreach ($data as $pun) {
      $insertData = [
        'emp_id' => $pun['emp_id'],
        'name' => $pun['name'],
        'note' => Arr::exists($pun, 'note') ? $pun['note'] : null,
        'date' => $pun['date'],
        'resourse' => $pun['resourse'],
        'type' => $pun['type'],
      ];
      DB::table('punishments')->insert($insertData);
    }

    return response()->json([
      'status' => true,
      'message' => "added Successfully"
    ]);
  }

  public function addEmpRew(Request $request)
  {

    $data = $request->all();

    reward::where('emp_id', $data['rew1']['emp_id'])->delete();

    foreach ($data as $rew) {
      $insertData = [
        'emp_id' => $rew['emp_id'],
        'name' => $rew['name'],
        'note' => Arr::exists($rew, 'note') ? $rew['note'] : null,
        'date' => $rew['date'],
        'resourse' => $rew['resourse'],
        'type' => $rew['type'],
      ];
      DB::table('rewards')->insert($insertData);
    }

    return response()->json([
      'status' => true,
      'message' => "added Successfully"
    ]);
  }

  public function addEmpAbs(Request $request)
  {
    $data = $request->all();

    absences_and_vacation::where('emp_id', $data['abs1']['emp_id'])->delete();

    foreach ($data as $abs) {
      $insertData = [
        'emp_id' => $abs['emp_id'],
        'from' => $abs['from'],
        'to' => $abs['to'],
        'duration' => $abs['duration'],
        'reason' => $abs['reason'],
      ];
      DB::table('absences_and_vacations')->insert($insertData);
    }

    return response()->json([
      'status' => true,
      'message' => "added Successfully"
    ]);
  }

  public function addEmpVac(Request $request)
  {
    $data = $request->all();

    administrative_vacation::where('emp_id', $data['vac1']['emp_id'])->delete();

    foreach ($data as $abs) {
      $insertData = [
        'emp_id' => $abs['emp_id'],
        'date' => $abs['date'],
        'duration' => $abs['duration'],
        'reason' => $abs['reason'],
      ];
      DB::table('administrative_vacations')->insert($insertData);
    }

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
