<?php

use Porygon\Organization\Models\Department;
use Porygon\Organization\Models\InCharge;

return [
    "database" => [
        'conniction' => config("database.default", env('DB_CONNECTION', 'mysql')),
        "prefix"     => "organization_",
        "tables"     => [
            "departments"   => "departments",
            "posts"         => "posts",
            "in_charge"     => "in_charge",
            "organizations" => "organizations",
        ]
    ],
    "model" => [
        "relation" => [
            "department" => [
                "class"       => Department::class,
                "foreign_key" => "department_id",
                "local_key"   => "id"
            ],
            "inCharge" => [
                "class"       => InCharge::class,
                "foreign_key" => "user_id",
                "local_key"   => "id"
            ]
        ]
    ]
];
