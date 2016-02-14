<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameCreator
 *
 * @author user
 */
include_once 'JSONDatabase.php';
class GameCreator {

    public function create($data) {
        $db = new JSONDatabase();
        if (($db->readJSON($data["gameid"]) == NULL)) {
            $player = array();
            $goal = array();
            for ($i = 0; $i < $data["player"]; $i++) {
                $player[$i] = array(
                    "name" => ($i == 0) ? $data["name"] : NULL,
                    "seat" => NULL,
                );
                $goal[] = $data["goal" . ($i + 1)];
            }
            shuffle($goal);
            $game = array(
                "creator" => $data["name"],
                "player" => $player,
                "goal" => $goal,
                "line" => array(),
            );
            if ($db->createJSON($data["gameid"], $game)) {
                return array(
                    "success" => true,
                    "url" => "http://" . $_SERVER['SERVER_NAME'] . "/SPD4517IA1PHP/share.php?ID=" . $data["gameid"],
                );
            } else {echo 1;
                return array(
                    "success" => false,
                    "message" => "Error create JSON!",
                );
            }
        } else {
            return array(
                "success" => false,
                "message" => "Same ID. Please select Another",
            );
        }
    }

}
