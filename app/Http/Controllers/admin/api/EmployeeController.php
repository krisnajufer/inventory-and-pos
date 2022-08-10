<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Employees;
use App\Models\Admin\Users;

class EmployeeController extends Controller
{
    use ApiResponseHelpers;
    public function get(): JsonResponse
    {
        $employees = Employees::all();

        return $this->respondWithSuccess(['employees' => $employees]);
    }

    public function post(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'employee_address' => 'required',
            'employee_city' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'role' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'type' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            $message = $validator->errors();
            $message = str_replace(array(
                '\'', '"',
                ',', '{', '[', ']', '}'
            ), '', $message);
            return $this->respondError($message);
        } else {
            $user_id = Users::generateUserId();
            $check_username = Users::where('username', $request->username)->first();
            $check_email = Users::where('email', $request->email)->first();
            $employee_id = Employees::generateEmployeeId();
            $check_phone_number = Employees::where('phone_number', $request->phone_number)->first();

            if (empty($check_username)) {
                if (empty($check_email)) {
                    if (empty($check_phone_number)) {
                        DB::beginTransaction();
                        try {
                            $users = new Users();
                            $users->user_id = $user_id;
                            $users->slug = Str::random(16);
                            $users->username = $request->username;
                            $users->email = $request->email;
                            $users->password = bcrypt($request->password);
                            $users->type = $request->type;
                            $users->status = $request->status;

                            $employees = new Employees();
                            $employees->employee_id = $employee_id;
                            $employees->slug = Str::random(16);
                            $employees->user_id = $user_id;
                            $employees->firstname = $request->firstname;
                            $employees->lastname = $request->lastname;
                            $employees->employee_address = $request->employee_address;
                            $employees->employee_city = $request->employee_city;
                            $employees->date_of_birth = $request->date_of_birth;
                            $employees->gender = $request->gender;
                            $employees->phone_number = $request->phone_number;
                            $employees->role = $request->role;

                            $users->save();
                            $employees->save();

                            DB::commit();
                            return $this->respondCreated(['employees' => $employees, 'users' => $users]);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            return $this->respondError($e->getMessage());
                        }
                    } else {
                        return $this->respondError("Phone Number already exist");
                    }
                } else {
                    return $this->respondError("Email already exist");
                }
            } else {
                return $this->respondError("Username already exist");
            }
        }
    }


    public function detail($slug): JsonResponse
    {
        $employees = Employees::join('users as u', 'employees.user_id', '=', 'u.user_id')
            ->where('employees.slug', $slug)
            ->first();
        if (!empty($employees)) {
            return $this->respondWithSuccess(['employees' => $employees]);
        } else {
            return $this->respondNotFound("Employee not found or not exist");
        }
    }

    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'employee_address' => 'required',
            'employee_city' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'role' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'type' => 'required',
            'status' => 'required'
        ]);

        $employees = Employees::where('slug', $slug)->first();
        if (!empty($employees)) {
            if ($validator->fails()) {
                $message = $validator->errors();
                $message = str_replace(array(
                    '\'', '"',
                    ',', '{', '[', ']', '}'
                ), '', $message);
                return $this->respondError($message);
            } else {
                $users = Users::where('user_id', $employees->user_id)->first();
                $check_username = Users::where('username', $request->username)
                    ->where('username', '<>', $users->username)
                    ->first();
                $check_email = Users::where('email', $request->email)
                    ->where('email', '<>', $users->email)
                    ->first();
                $check_phone_number = Employees::where('phone_number', $request->phone_number)
                    ->where('phone_number', '<>', $employees->phone_number)
                    ->first();

                if (empty($check_username)) {
                    if (empty($check_email)) {
                        if (empty($check_phone_number)) {
                            DB::beginTransaction();
                            try {
                                $users->username = $request->username;
                                $users->email = $request->email;
                                $users->password = bcrypt($request->password);
                                $users->type = $request->type;
                                $users->status = $request->status;

                                $employees->firstname = $request->firstname;
                                $employees->lastname = $request->lastname;
                                $employees->employee_address = $request->employee_address;
                                $employees->employee_city = $request->employee_city;
                                $employees->date_of_birth = $request->date_of_birth;
                                $employees->gender = $request->gender;
                                $employees->phone_number = $request->phone_number;
                                $employees->role = $request->role;

                                $users->save();
                                $employees->save();
                                DB::commit();
                                return $this->respondWithSuccess(['employees' => $employees, 'users' => $users]);
                            } catch (\Exception $e) {
                                DB::rollBack();
                                return $this->respondError($e->getMessage());
                            }
                        } else {
                            return $this->respondError("Phone Number already exist");
                        }
                    } else {
                        return $this->respondError("Email already exist");
                    }
                } else {
                    return $this->respondError("Username already exist");
                }
            }
        } else {
            return $this->respondNotFound("Employee not found or not exist");
        }
    }

    public function delete($slug): JsonResponse
    {
        $employees = Employees::where('slug', $slug)->first();
        if (!empty($employees)) {
            $users = Users::where('user_id', $employees->user_id)->first();
            DB::beginTransaction();
            try {
                $users->delete();
                $employees->delete();
                DB::commit();
                return $this->respondOk("Successfully deleted employee");
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->respondError($e->getMessage());
            }
        } else {
            return $this->respondNotFound("Employee not found or not exist");
        }
    }
}
