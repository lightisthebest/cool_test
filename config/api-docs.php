<?php

/**
 * @return array
 */
function getApiErrorResponse()
{
    return [
        "description" => "Internal server error",
        "content" => [
            "application/json" => [
                'schema' => [
                    "type" => 'object',
                    'required' => [
                        "status", "message"
                    ],
                    "properties" => [
                        "status" => [
                            "example" => 500,
                            "type" => "integer"
                        ],
                        "message" => [
                            "example" => "Something went wrong.",
                            "type" => "string"
                        ],
                        "file" => [
                            "example" => "/Users/devsdevseonet6eonet6/Oleh/Projects/karabas-laravel/app/Http/Controllers/Api/FileName.php",
                            "type" => "string"
                        ],
                        "line" => [
                            "example" => 53,
                            "type" => "integer"
                        ],
                    ]
                ]
            ]
        ]
    ];
}

/**
 * @return array
 */
function getValidationResponse()
{
    return [
        "description" => "The given data was invalid.",
        "content" => [
            "application/json" => [
                'schema' => [
                    "type" => 'object',
                    'required' => [
                        "status", "message"
                    ],
                    "properties" => [
                        "status" => [
                            "example" => 422,
                            "type" => "integer"
                        ],
                        "message" => [
                            "example" => "The given data was invalid.",
                            "type" => "string"
                        ],
                        "errors" => [
                            "type" => "object",
                            "properties" => [
                                "property_name" => [
                                    "type" => "array",
                                    "items" => [
                                        "type" => "string",
                                    ],
                                    "example" => [
                                        "This field is required.",
                                        "This field must be string."
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
}

/**
 * @return string
 */
function getSuccessResponse()
{
    return "Operation finished without errors.";
}

function sendResponse()
{
    return [
        "description" => getSuccessResponse(),
        "content" => [
            "application/json" => [
                "schema" => [
                    "type" => "object",
                    "required" => [
                        "status",
                        "message"
                    ],
                    "properties" => [
                        "status" => [
                            "type" => "integer",
                            "example" => 200,
                            "description" => "Status is always 200 when the operation has finished successfully."
                        ],
                        "message" => [
                            "type" => "string",
                            "example" => "Letter was sent successfully.",
                            "description" => "Success message."
                        ]
                    ]
                ]
            ]
        ]
    ];
}

function getTooManyAttemptsResponse() {
    return [
        "description" => "Too many attempts response",
        "content" => [
            "application/json" => [
                "schema" => [
                    "type" => "object",
                    "required" => [
                        "message"
                    ],
                    "properties" => [
                        "message" => [
                            "type" => "string",
                            "example" => "Too many attempts."
                        ]
                    ]
                ]
            ]
        ]
    ];
}

return [
    'main' => [
        "openapi" => "3.0.0",
        "info" => [
            "title" => "Cool Test API documentation",
            "contact" => [
                "phone" => "380638508007"
            ],
            "license" => [
                "name" => "Cool"
            ],
            "version" => "1.0.0"
        ],
        "servers" => [
            [
                "url" => env("APP_URL") . "/api",
                "description" => "Local (for development mode)"
            ]
        ],
        "components" => [
            "securitySchemes" => [
                "" => [
                    "type" => "openIdConnect"
                ]
            ]
        ],
        "tags" => [
            [
                "name" => "Main list",
            ]
        ],
    ],

    "paths" => [
        //Commodities
        "/send-message" => [
            "post" => [
                "summary" => "Send new message to fixed email",
                "operationId" => "createNewMessage",
                "tags" => ['Main list'],
                "parameters" => [
                    [
                        'name' => 'lang',
                        'in' => 'query',
                        'required' => false,
                        'example' => 'uk',
                        "default" => "uk",
                        'description' => 'Application language.',
                        'schema' => [
                            'type' => 'string',
                            "enum" => ['uk', 'en', 'ru']
                        ]
                    ],
                ],
                "requestBody" => [
                    "required" => true,
                    "description" => "Message body.",
                    "content" => [
                        "application/json" => [
                            "schema" => [
                                "type" => "object",
                                "required" => [
                                    'message'
                                ],
                                "properties" => [
                                    "message" => [
                                        "type" => "string",
                                        "description" => "New message",
                                        "example" => "This message should be sent on email."
                                    ],
                                ]
                            ]
                        ]
                    ]
                ],
                "responses" => [
                    "200" => sendResponse(),
                    "422" => getValidationResponse(),
                    "429" => getTooManyAttemptsResponse(),
                    "500" => getApiErrorResponse()
                ]
            ]
        ],
    ]
];
