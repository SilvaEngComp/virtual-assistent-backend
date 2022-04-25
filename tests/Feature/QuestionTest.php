<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionTest extends TestCase
{

    private $user;
    private $token;
    private $headers;
    public function init()
    {
        $this->user = [
            'email' => 'admin@ufba.br',
            'password' => 'admin1',
        ];

        $response = $this->post('/api/v2/auth/login', $this->user);
        $responseJson = $response->json();
        $this->token = $responseJson['data']['token'];
        $this->headers = [
            'accept' => 'application/json',
            'authentication' => 'Bearer ' . $this->token,
        ];
    }

    // use RefreshDatabase, WithFaker;
    private $json_structure_return = [
        [
            "id",
            "description",
            "answer",
            "parents" => [
                '*' => []
            ]
        ]
    ];
    private $questionRequested = [
        "id" => 1,
        "description" => "Criação do Instituto de Computação",
        "answer" => "O Instituto de Computação (IC) da UFBA foi criado em 18 de Junho de 2021",
    ];

    private $questionReturned = [
        "id" => 1,
        "description" => "Criação do Instituto de Computação",
        "answer" => "O Instituto de Computação (IC) da UFBA foi criado em 18 de Junho de 2021",
        "parents" => [
            [
                "id" => 1,
                "name" => "Institucional"
            ], [
                "id" => 2,
                "name" => "Sobre o IC"
            ],

        ]
    ];
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_questions()
    {
        //arg
        //act
        $response = $this->get('/api/v1/questions');
        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);
    }

    public function test_return_right_structure()
    {
        //arg
        //act
        $response = $this->get('/api/v1/questions');
        //assert
        $response->assertOk();
        // $this->assertCount(38, $response->json());
        $response->assertJsonStructure($this->json_structure_return);
    }

    public function test_get_an_especific_question()
    {
        //arg
        //act
        $response = $this->get('/api/v1/questions/' . $this->questionRequested['id']);
        $responseJson = $response->json();
        //assert
        $response->assertOk();
        // $this->assertCount(38, $response->json());
        $this->assertEquals($responseJson, $this->questionReturned);
    }

    public function test_get_an_especific_question_error()
    {
        //arg
        //act
        $response = $this->get('/api/v1/questions/' . $this->questionRequested['id']);
        $responseJson = $response->json();
        //assert
        $response->assertOk();

        $this->assertNotEquals($responseJson['description'], "null");
    }

    public function test_insert_a_new_question()
    {
        //arg
        $this->init();
        $newQuestion = [
            "description" => "description test",
            "answer" => "answer",
            "topic_id" => 9
        ];
        //act
        $response = $this->withHeaders($this->headers)->post('/api/v3/questions', $newQuestion);
        $responseJson = $response->json();
        //assert
        $response->assertStatus(201);
        $this->assertEquals($responseJson['data']['description'], $newQuestion['description']);
    }
}
