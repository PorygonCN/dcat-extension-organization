<?php

return [
    "database" => [
        'conniction' => config("database.default", env('DB_CONNECTION', 'mysql')),
        "prefix"     => "organization_",
        "tables"     => [
            "departments" => "departments",
            "posts"       => "posts",
            "in_charge"   => "in_charge",
        ]
    ]
];
