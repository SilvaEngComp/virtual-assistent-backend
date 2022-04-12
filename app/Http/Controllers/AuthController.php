<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{

    use ApiResponser;
    public function codeValidation($cod, $is_invitation)
    {
        try {
            $user = User::where('token', 'like', substr($cod, 0, 3) . '%' . substr($cod, -3))->first();
            if ($user) {
                if ($is_invitation) {
                    return $this->success($user->build(), 'User');
                }
                $date1 = Carbon::create($user->token_time);
                $date2 = Carbon::create(now());
                if ($date1->diffInHours($date2) <= 24) {
                    $user->token = null;
                    $user->update();
                    return $this->success('User', $user->build());
                }
            } else {
                return $this->error('Code is not valid!', 404);
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }



    public function login(UserLoginRequest $request)
    {
        try {
            $payload = $request->all();

            $user = User::getUserDecripted($payload['email']);

            if ($user) {
                if (!Hash::check($payload['password'], $user->password)) {
                    return $this->error('Credenciais incorretas', 403);
                }

                $this->logout($user);
                Auth::login($user);

                return $this->success('Wellcome ' . $user->name, [
                    'user' => $user->build($user),
                    'token' => $user->createToken('API Token')->plainTextToken,
                ]);
            }

            return $this->error('User não cadastrado', 404);
        } catch (Throwable $e) {
            return $request;
        }
    }


    public function updatePassword(User $user, $password)
    {

        if ($user) {
            $user->password = bcrypt($password);
            $user->update();
        }

        Auth::login($user);

        return $this->success('Wellcome ' . $user->name, [
            'user' => $user->build($user),
            'token' => $user->createToken('API Token')->plainTextToken,
        ]);
    }



    public function logout(User $user)
    {
        if ($user) {
            $user->tokens()->delete();
        }
    }
}


//CommitTestDaniel
