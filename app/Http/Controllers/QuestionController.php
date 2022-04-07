<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionRequest;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{

    use ApiResponser;
    public function createQuestion(CreateQuestionRequest questionRequest)
    {
        try {
            return 
        } catch (Throwable $e) {
            return $this->error('Erro: ' + $e, 404);
        }
    }
}


//CommitTestDaniel