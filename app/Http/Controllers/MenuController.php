<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Topic;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function build($csvQuestions)
    {

        $path = self::getTags($csvQuestions);


        $root = new Menu();

        foreach ($path as $subTags) {

            $questions = array();
            foreach ($csvQuestions as $csvQuestion) {
                if ($csvQuestion["path"] === $subTags) {
                    array_push(
                        $questions,
                        $csvQuestion
                    );
                }
            }

            $menu = self::menuBuild($root, $subTags, $questions);
            $root->setSubmenu($menu);
        }
        return response(['menu' => $root]);
    }


    public static function getTags($csvQuestions)
    {
        $path = array();
        foreach ($csvQuestions as $csvQuestion) {
            if (!in_array($csvQuestion["path"], $path)) {
                array_push($path, $csvQuestion["path"]);
            }
        }

        return $path;
    }


    public static function menuBuild(Menu | null $root, array $path, array $questions)
    {
        // self::regiterTopic($root);

        if (!is_null($root)) {
            $removedTag = null;
            if (!isset($path) || count($path) > 0) {
                $removedTag = $path[0];

                $result = array_splice($path, 1);

                if ($root->getTag() === '') {
                    $root->setTag($removedTag);
                }
                if (count($result) > 0) {
                    $submenu = new Menu();
                    $root->setSubmenu($submenu);

                    $root  = self::menuBuild($submenu, $result, $questions);
                } else {
                    $root->setSubmenu(null);
                    if (!is_null($root)) {
                        if ($root->getTag() == end($questions[0]["path"])) {
                            $root->setQuestions($questions);
                        }
                    }

                    $root  = self::menuBuild(null, $result, $questions);
                }
            }
        }





        return $root;
    }


    public static function regiterTopic(Menu $menu)
    {
        if ($menu) {
            if (!Topic::where('description', $menu->getTag())->exists()) {
                echo "\n not exists" . $menu->getTag();
            }
        }
        echo "\n alheardy exists" . $menu->getTag();
    }
}
