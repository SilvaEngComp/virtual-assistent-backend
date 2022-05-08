<?php

namespace Tests\Unit;

use App\Http\Controllers\QuestionController;
use PHPUnit\Framework\TestCase;

class QuestionModelTest extends TestCase
{
    /**
     * A basic unit test example.
     * @dataProvider provider
     * @param $questionList, $questionListWrong, $questionListRight
     * @return void
     */


    public function test_question_list()
    {

        $questionListRight = [

            [
                "id" => 1,
                "description" => "Criação do Instituto de Computação",
                "answer" => "O Instituto de Computação (IC) da UFBA foi criado em 18 de Junho de 2021",
                "parents" => [
                    "Institucional",
                    "Sobre o IC"
                ]
            ],
            [
                "id" => 2,
                "description" => "Resolução que criou o instituto de computação",
                "answer" => "Resolucao 05.2021 do Conselho Universitario da UFBA",
                "parents" => [
                    "Institucional",
                    "Sobre o IC"
                ]
            ],
            ];

            $questionList = [

                [
                    "id" => 1,
                    "description" => "chip",
                    "answer" => "Sobre o chip",
                    "parents" => [
                        "Institucional",
                        "Sobre o IC"
                    ]
                ],
                [
                    "id" => 2,
                    "description" => "Resolução que criou o instituto de computação",
                    "answer" => "Resolucao 05.2021 do Conselho Universitario da UFBA",
                    "parents" => [
                        "Institucional",
                        "Sobre o IC"
                    ]
                ]];

        $questionController = $this->createMock(QuestionController::class);

        $questionController->method('index')
            ->willReturn($questionListRight);

        $this->assertNotEquals($questionList, $questionListRight);

    }



    public function provider()
    {
        return [
            "getAllQuestions" => [
                "questionList" => [

                    [
                        "id" => 1,
                        "description" => "Criação do Instituto de Computação",
                        "answer" => "O Instituto de Computação (IC) da UFBA foi criado em 18 de Junho de 2021",
                        "parents" => [
                            "Institucional",
                            "Sobre o IC"
                        ]
                    ],
                    [
                        "id" => 2,
                        "description" => "Resolução que criou o instituto de computação",
                        "answer" => "Resolucao 05.2021 do Conselho Universitario da UFBA",
                        "parents" => [
                            "Institucional",
                            "Sobre o IC"
                        ]
                    ],
                    [
                        "id" => 3,
                        "description" => "Departamentos que fazem parte do Instituto de Computação",
                        "answer" => "Departamento de Ciência da Computação (DCC) e Departamento de Computacao Interdisciplinar (DCI)",
                        "parents" => [
                            "Institucional",
                            "Sobre o IC"
                        ]
                    ],

                ]
            ],
            "questionListRight" => [

                [
                    "id" => 1,
                    "description" => "Criação do Instituto de Computação",
                    "answer" => "O Instituto de Computação (IC) da UFBA foi criado em 18 de Junho de 2021",
                    "parents" => [
                        "Institucional",
                        "Sobre o IC"
                    ]
                ],
                [
                    "id" => 2,
                    "description" => "Resolução que criou o instituto de computação",
                    "answer" => "Resolucao 05.2021 do Conselho Universitario da UFBA",
                    "parents" => [
                        "Institucional",
                        "Sobre o IC"
                    ]
                ],
                [
                    "id" => 3,
                    "description" => "Departamentos que fazem parte do Instituto de Computação",
                    "answer" => "Departamento de Ciência da Computação (DCC) e Departamento de Computacao Interdisciplinar (DCI)",
                    "parents" => [
                        "Institucional",
                        "Sobre o IC"
                    ]
                ],

            ], "questionListWrong" => [

                [
                    "id" => 1,
                    "description" => "chip",
                    "answer" => "O Instituto de Computação (IC) da UFBA foi criado em 18 de Junho de 2021",
                    "parents" => [
                        "Institucional",
                        "Sobre o IC"
                    ]
                ],
                [
                    "id" => 2,
                    "description" => "Resolução que criou o instituto de computação",
                    "answer" => "Resolucao 05.2021 do Conselho Universitario da UFBA",
                    "parents" => [
                        "Institucional",
                        "Sobre o IC"
                    ]
                ],
                [
                    "id" => 3,
                    "description" => "Departamentos que fazem parte do Instituto de Computação",
                    "answer" => "Departamento de Ciência da Computação (DCC) e Departamento de Computacao Interdisciplinar (DCI)",
                    "parents" => [
                        "Institucional",
                        "Sobre o IC"
                    ]
                ],

            ]
        ];
    }
}
