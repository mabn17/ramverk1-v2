<?php
/**
 * Handles kmom01 and kmom02.
 */
return [
    "routes" => [
        [
            "info" => "Väder applikation",
            "mount" => "vader",
            "handler" => "\Anax\Controller\WeatherController",
        ],
    ]
];
