<?php

namespace App\Http\Controllers;

use App\Http\Requests\NlpRequest;
use App\Models\Nlp;
use App\Traits\ApiResponser;
use JoggApp\NaturalLanguage\NaturalLanguage;
use JoggApp\NaturalLanguage\NaturalLanguageClient;

class NlpController extends Controller
{

    use ApiResponser;


    private function NaturalLanguageFactory(): NaturalLanguage
    {
        return new NaturalLanguage(new NaturalLanguageClient(config('naturallanguage')));
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\NlpRequest
     * @return \Illuminate\Http\Response
     */
    public function index(NlpRequest $request)
    {
        $naturalLanguage = Nlp::NaturalLanguageFactory();
        $entities = $naturalLanguage->entities($request->input('text'));
        $entitiesName = Nlp::costumizeEntities($entities);
        $answers = Nlp::getByAnswers($entitiesName);
        if (isset($answers)) {
            return $answers;
        }
        $questions = Nlp::getByAnswers($entitiesName, 'description');
        if (isset($answers)) {
            return $questions;
        }

        $topics = Nlp::getByTopics($entitiesName);
        if (isset($topics)) {
            return $topics;
        }

        Nlp::error('Not found', 404);
    }
}
