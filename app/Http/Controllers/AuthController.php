<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Mail\RecoverCode2;
use App\Mail\SendInvitation;
use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthController extends Controller
{

    use ApiResponser;


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function sendInvitation($email)
    {
        if ($email) {
            $user = User::getUserDecripted($email);
            if ($user) {
                return $this->error('Email já está cadastrado', 400);
            }
            try {
                return   DB::transaction(function () use ($email) {
                    $password = bcrypt($email);

                    $user = User::create([
                        "email" => encrypt($email),
                        "password" => $password
                    ]);
                    $user->assignRole('basic_user');

                    Mail::send(new SendInvitation($user));
                    $email = explode('@', $email);
                    return $this->success(null, 'Email enviado para:  ' . substr($email[0], 0, 3) . '*****@' . substr($email[1], 0, 3) . '*****');
                });
            } catch (\Exception $e) {
                return $this->error($e->getMessage(), 400);
            }
        }

        return $this->error('Email inválido', 400);
    }

    public function checkEmailExistente($email)
    {

        $user = User::getUserDecripted($email);

        if ($user) {
            return response(new RecoverCode2($user));
            Mail::send(new RecoverCode2($user));
            return $email = explode('@', $user['email']);
            return $this->success(null, 'Email enviado para:  ' . substr($email[0], 0, 3) . '*****@' . substr($email[1], 0, 3) . '*****');
        }

        return $this->error('Email não encontrado', 404);
    }





    public function codeValidation($cod, $is_invitation)
    {
        try {
            $user = User::where('token', 'like', substr($cod, 0, 3) . '%' . substr($cod, -3))->first();
            if ($user) {
                if ($is_invitation) {
                    return $this->success(User::buildSimple($user), 'Usuário');
                }
                $date1 = Carbon::create($user->token_time);
                $date2 = Carbon::create(now());
                if ($date1->diffInHours($date2) <= 24) {
                    $user->token = null;
                    $user->update();
                    return $this->success('Usuário', User::build($user));
                }
            } else {
                return $this->error('codigo inválido ou expirado', 404);
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

                // $this->logout($user);
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
