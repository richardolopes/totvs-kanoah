<?php

use \Kanoah\Page;

// release e rpo definidos
$app->get("/jira", function () {
    $page = new Page();
});

/*

// This code sample uses the 'Unirest' library:
// http://unirest.io/php.html
Unirest\Request::auth('email@example.com', '<api_token>');

$headers = array(
'Accept' => 'application/json'
);

$response = Unirest\Request::get(
'/rest/api/3/application-properties',
$headers
);

var_dump($response)
