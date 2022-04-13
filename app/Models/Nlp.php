<?php

namespace App\Models;

use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Model;
use JoggApp\NaturalLanguage\NaturalLanguage;
use JoggApp\NaturalLanguage\NaturalLanguageClient;

class Nlp extends Model
{
    use ApiResponser;


    public static function NaturalLanguageFactory(): NaturalLanguage
    {
        return new NaturalLanguage(new NaturalLanguageClient(config('naturallanguage')));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function costumizeEntities($entities): array
    {
        $entitiesName = array();
        foreach ($entities['entities'] as $entity) {
            array_push($entitiesName, $entity['name']);
        }
        return array_unique($entitiesName);
    }

    public static function getByAnswers($entitiesName, $type = 'answer'): array|null
    {
        $query  = null;
        $queryentitiesNameAux = $entitiesName;
        while (True) {
            if (count($entitiesName) > 0) {
                foreach ($entitiesName as $value) {
                    if (!isset($query)) {
                        $query = Question::where($type, 'LIKE', "%$value%");
                    }
                    $query =  $query->where($type, 'LIKE', "%$value%");
                }

                $response = $query->get();
                if (count($response->toArray()) > 0) {
                    return $response->toArray();
                }
                $query  = null;
                array_pop($entitiesName);
            } else {
                break;
            }
        }

        if (count($queryentitiesNameAux) > 0) {
            foreach ($entitiesName as $value) {
                $query =  Question::where($type, 'LIKE', "%$value%");
                if (count($query->toArray()) > 0) {
                    return $query->toArray();
                }
            }
        }

        return null;
    }

    public static function getByTopics($entitiesName): array|null
    {
        $query  = null;
        $queryentitiesNameAux = $entitiesName;
        while (True) {
            if (count($entitiesName) > 0) {
                foreach ($entitiesName as $value) {
                    if (!isset($query)) {
                        $query = Topic::where('name', 'LIKE', "%$value%");
                    }
                    $query =  $query->where('name', 'LIKE', "%$value%");
                }

                $response = $query->get();
                if (count($response->toArray()) > 0) {
                    return $response->toArray();
                }
                $query  = null;
                array_pop($entitiesName);
            } else {
                break;
            }
        }

        if (count($queryentitiesNameAux) > 0) {
            foreach ($entitiesName as $value) {
                $query =  Question::where('name', 'LIKE', "%$value%");
                if (count($query->toArray()) > 0) {
                    return $query->toArray();
                }
            }
        }

        return null;
    }
}
