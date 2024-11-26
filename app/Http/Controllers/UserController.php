<?php

namespace App\Http\Controllers;

use App\Models\{ PasswordReset, User };
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{ DB, Hash, Mail, Auth };
use App\Http\Requests\User\{ ActivateRequest, PasswordRecoveryRequest, PasswordResetRequest };
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function passwordReset(Request $request)
    {
        $error = null;

        try {
            DB::transaction(function () use ($request) {
                $user = User::where('email', $request->input('email'))->firstOrFail();
                $user->password = $request->input('password');
                $user->save();
            });
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }

        return response()->json([
            'success' => !isset($error),
            'status' => $error ?? 'success'
        ], isset($error) ? 400 : 200);
    }


    public function activate(Request $request)
    {
        $token = null;
        $error = null;

        try {
            DB::transaction(function () use ($request, &$token) {
                $user = User::where('email', $request->input('email'))->firstOrFail();
                $user->update(['active' => 1, 'email_verified_at' => date('Y-m-d H:i:s')]);
                $token = Auth::guard()->login($user);
            });
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }

        return response()->json([
            'success' => !isset($error),
            'status' => $error ?? 'success',
            'token' => $token
        ], isset($error) ? 400 : 200);
    }

    public function checkUserExistence(Request $request)
    {
        try {
            $user = User::where('email', $request->email)
                        ->where('active', 1)
                        ->first();

            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'User exists',
                    'user' => $user
                ], 200);
            }

            return $this->store($request);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function store(Request $request)
    {
        try {

            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'name' => $request->name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'active' => $request->active,
            ]);

            return response()->json([
                'success' => true,
                'user' => $user
            ], 201);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request)
    {
        try {

            User::where('email', $request->email)->update([
                'password' => $request->password,
                'name' => $request->first_name." ".$request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);

            return response()->json([
                'success' => true
            ], 200);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


}
