<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Traits\ApiResponser;
use App\Models\Question;
use Throwable;

class QuestionController extends Controller
{

    use ApiResponser;


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\QuestionRequest  $questionRequest
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $questionRequest)
    {
        try {
            Question::create([
                "description" => $questionRequest["description"],
                "answare" => $questionRequest["answare"],
                "topic_id" => $questionRequest["topic_id"]
            ]);
            return $this->success('Registro criado com sucesso.');
        } catch (Throwable $e) {
            return $this->error('Erro: ' + $e, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\QuestionRequest  $questionRequest
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionUpdateRequest $questionRequest)
    {
        try {
            Question::find($questionRequest["id"])->fill($questionRequest);
            return $this->success('Registro alterado com sucesso.');
        } catch (Throwable $e) {
            return $this->error('Erro: ' + $e, 404);
        }
    }
}


//CommitTestDaniel
