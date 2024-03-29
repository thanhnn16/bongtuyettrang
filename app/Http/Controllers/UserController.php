<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('phone_number', 'password'), $request->filled('remember'))) {
            return response()->json([
                'message' => 'Login failed.',
            ], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('mobileAppToken')->plainTextToken;

        $UID = $user->id;
        return response()->json([
            'message' => 'Authenticated.',
            'token' => $token,
            'userId' => $UID,
        ], 200);
    }

    public function show($id): JsonResponse
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $user = User::find($request->uid);
        $currentDateTimestamp = strtotime(date('Y-m-d'));
        if ($user) {
            try {
                $user->full_name = $request->full_name;
                $user->email = $request->email;
                $user->dob = $request->dob;
                $user->address = $request->address;
                $user->avatar = $request->avatar;
                $user->gender = $request->gender;
                $user->updated_at = $currentDateTimestamp;
                $user->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'User update failed',
                ], 500);
            }
            return response()->json([
                'message' => 'User updated successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found',
                'request' => $request->uid,
            ], 404);
        }
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $user = $request->user();

        if ($request->hasFile('avatar')) {
            $oldAvatar = $user->avatar;
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('avatars', $filename, 'public');

            $user->avatar = $filename;
            $user->save();

            if ($oldAvatar) {
                Storage::disk('public')->delete('avatars/' . $oldAvatar);
            }

            $avatarUrl = asset('storage/avatars/'.$filename);

            return response()->json([
                'message' => 'Avatar uploaded successfully',
                'avatar' => $filename,
                'avatarUrl' => $avatarUrl,
            ], 200);
        } else {
            return response()->json([
                'message' => 'No file uploaded',
            ], 400);
        }
    }

    public function changePassword(Request $request): JsonResponse
    {
        $user = User::find($request->id);
        try {
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'message' => 'Password changed successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Password change failed',
            ], 500);
        }
    }
}
