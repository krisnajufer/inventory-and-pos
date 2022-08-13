<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Users;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ApiResponseHelpers;
    public function __construct()
    {
        $this->setDefaultSuccessResponse([]);
    }

    public function get(): JsonResponse
    {
        $users = Users::all();

        return $this->respondWithSuccess(['users' => $users]);
    }

    public function validatorHelper($request)
    {
        $validator = Validator::make($request, [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'type' => 'required',
            'status' => 'required'
        ]);

        return $validator;
    }

    public function post(Request $request): JsonResponse
    {
        $validator = $this->validatorHelper($request->all());
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
            if (empty($check_username)) {
                if (empty($check_email)) {
                    DB::beginTransaction();
                    try {
                        $users = Users::create([
                            'user_id' => $user_id,
                            'slug' => Str::random(16),
                            'username' => $request->username,
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'type' => $request->type,
                            'status' => $request->status
                        ]);
                        DB::commit();
                        return $this->respondCreated(['users' => $users]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return $this->respondError($e->getMessage());
                    }
                } else {
                    return $this->respondError("Email already exist");
                }
            } else {
                return $this->respondError("Username already exist");
            }
        }
    }

    public function update(Request $request, $slug): JsonResponse
    {
        $users = Users::where('slug', $slug)->first();
        $validator = $this->validatorHelper($request->all());
        if (!empty($users)) {
            if ($validator->fails()) {
                $message = $validator->errors();
                $message = str_replace(array(
                    '\'', '"',
                    ',', '{', '[', ']', '}'
                ), '', $message);
                return $this->respondError($message);
            } else {
                $check_username = Users::where('username', '<>', $users->username)
                    ->where('username', $request->username)
                    ->first();
                $check_email = Users::where('email', '<>', $users->email)
                    ->where('email', $request->email)
                    ->first();
                if (!empty($check_username)) {
                    return $this->respondError("Username already exist");
                } else {
                    if (!empty($check_email)) {
                        return $this->respondError("Email already exist");
                    } else {
                        DB::beginTransaction();
                        try {
                            $users->username = $request->username;
                            $users->email = $request->email;
                            $users->password = $request->password;
                            $users->type = $request->type;
                            $users->status = $request->status;
                            $users->save();

                            DB::commit();
                            return $this->respondWithSuccess(['users' => $users]);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            return $this->respondError($e->getMessage());
                        }
                    }
                }
            }
        } else {
            return $this->respondNotFound("user not found or not exist");
        }
    }

    public function detail($slug): JsonResponse
    {
        $users = Users::where('slug', $slug)->first();
        if (!empty($users)) {
            return $this->respondWithSuccess(['users' => $users]);
        } else {
            return $this->respondNotFound("user not found or not exist");
        }
    }

    public function delete($slug): JsonResponse
    {
        $users = Users::where('slug', $slug)->first();
        if (!empty($users)) {
            DB::beginTransaction();
            try {
                $users->delete();
                DB::commit();
                return $this->respondOk("Successfully deleted user");
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->respondError($e->getMessage());
            }
        } else {
            return $this->respondNotFound("user not found or not exist");
        }
    }
}
