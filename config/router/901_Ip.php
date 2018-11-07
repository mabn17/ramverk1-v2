<?php
/**
 * Flat file controller for reading markdown files from content/.
 */
return [
    "routes" => [
        [
            "info" => "Flat file content controller.",
            "mount" => "validate",
            "handler" => "\Anax\Controller\IpController",
        ],
        [
            "info" => "Flat file content controller.",
            "mount" => "ip-json",
            "handler" => "\Anax\Controller\IpJsonController"
        ]
    ]
];
