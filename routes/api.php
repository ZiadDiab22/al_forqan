<?php

use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\Api\ManagerController;
use App\Http\Controllers\Api\TeachRequestController;
use App\Http\Controllers\Api\EmpRequestController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login", [UserController::class, "login"]);
Route::get("showStatuses", [UserController::class, "showStatuses"]);
Route::get("showMServices", [UserController::class, "showMServices"]);
Route::get("showNats", [UserController::class, "showNats"]);
Route::get("showSectors", [UserController::class, "showSectors"]);
Route::post("addTeachingRequest", [TeachRequestController::class, "addTeachingRequest"]);
Route::post("editTeachingRequest", [TeachRequestController::class, "editTeachingRequest"]);
Route::get("deleteTeachingRequest/{id}", [TeachRequestController::class, "deleteTeachingRequest"]);
Route::post("addTCourse", [TeachRequestController::class, "addTCourse"]);
Route::post("addPSub", [TeachRequestController::class, "addPSub"]);
Route::post("addDSub", [TeachRequestController::class, "addDSub"]);
Route::post("addTexp", [TeachRequestController::class, "addTexp"]);
Route::post("addEmpRequest", [EmpRequestController::class, "addEmpRequest"]);
Route::post("editEmpRequest", [EmpRequestController::class, "editEmpRequest"]);
Route::get("deleteEmpRequest/{id}", [EmpRequestController::class, "deleteEmpRequest"]);
Route::post("addECourse", [EmpRequestController::class, "addECourse"]);
Route::post("addEexp", [EmpRequestController::class, "addEexp"]);
Route::get("showSubjects", [UserController::class, "showSubjects"]);
Route::get("showClasses", [UserController::class, "showClasses"]);
Route::post("searchSubjectsbyClass", [SearchController::class, "searchSubjectsbyClass"]);

Route::group(["middleware" => ["auth:api"]], function () {
    Route::post("logout", [UserController::class, "logout"]);
    Route::post("showActivities", [UserController::class, "showActivities"]);
    Route::post("register", [ManagerController::class, "register"])->middleware('checkUserId');
    Route::get("showTreqs", [UserController::class, "showTreqs"])->middleware('checkUserId');
    Route::get("showEreqs", [UserController::class, "showEreqs"])->middleware('checkUserId');
    Route::post("searchTReqs", [SearchController::class, "searchTReqs"])->middleware('checkUserId');
    Route::post("searchEReqs", [SearchController::class, "searchEReqs"])->middleware('checkUserId');
    Route::post("orderTreqs", [SearchController::class, "orderTreqs"])->middleware('checkUserId');
    Route::post("orderEreqs", [SearchController::class, "orderEreqs"])->middleware('checkUserId');
    Route::post("showReqData", [SearchController::class, "showReqData"])->middleware('checkUserId');
    Route::get("showRoles", [ManagerController::class, "showRoles"])->middleware('checkUserId');
    Route::post("addRole", [ManagerController::class, "addRole"])->middleware('checkUserId');
    Route::post("deleteRole", [ManagerController::class, "deleteRole"])->middleware('checkUserId');
    Route::post("rateTreq", [ManagerController::class, "rateTreq"])->middleware('checkUserId');
    Route::post("rateEreq", [ManagerController::class, "rateEreq"])->middleware('checkUserId');
    Route::post("addExp", [ManagerController::class, "addExp"])->middleware('checkUserId');
    Route::get("showEmpExp/{id}", [ManagerController::class, "showEmpExp"])->middleware('checkUserId');
    Route::post("addEmp", [EmployeesController::class, "addEmp"])->middleware('checkManagerId');
    Route::post("editEmp", [EmployeesController::class, "editEmp"])->middleware('checkManagerId');
    Route::get("deleteEmp/{id}", [EmployeesController::class, "deleteEmp"])->middleware('checkManagerId');
    Route::post("searchEmp", [SearchController::class, "searchEmp"])->middleware('checkUserId');
    Route::post("filterEmps", [SearchController::class, "filterEmps"])->middleware('checkUserId');
    Route::get("showEmps", [EmployeesController::class, "showEmps"])->middleware('checkUserId');
    Route::post("addEmpQua", [EmployeesController::class, "addEmpQua"])->middleware('checkUserId');
    Route::post("addEmpcourse", [EmployeesController::class, "addEmpcourse"])->middleware('checkUserId');
    Route::post("addEmpPun", [EmployeesController::class, "addEmpPun"])->middleware('checkUserId');
    Route::post("addEmpRew", [EmployeesController::class, "addEmpRew"])->middleware('checkUserId');
    Route::post("addEmpAbs", [EmployeesController::class, "addEmpAbs"])->middleware('checkUserId');
    Route::post("addEmpVac", [EmployeesController::class, "addEmpVac"])->middleware('checkUserId');
    Route::get("showEmpData/{id}", [EmployeesController::class, "showEmpData"])->middleware('checkUserId');
});
