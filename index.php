<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use Vonage\Voice\NCCO\NCCO;

require 'vendor/autoload.php';

$client = new \Vonage\Client(
    new \Vonage\Client\Credentials\Keypair(
        file_get_contents('./private.key'),
        'VONAGE_APPLICATION_ID'
    )
);

$app = AppFactory::create();

function getCurrentUrl($request) {
    $uri = $request->getUri();

    $url = $uri->getScheme() . '://' . $uri->getHost();
    if ($port = $uri->getPort()) {
        $url .= ':' . $port;
    }

    return $url;
}

$app->get('/webhooks/answer', function (Request $request, Response $response) {
    $params = $request->getQueryParams();
    $ncco = new NCCO();
    $ncco->addAction(
        new \Vonage\Voice\NCCO\Action\Stream(
            getCurrentUrl($request) . '/welcome.mp3'
        )
    );

    $conversationAction = new \Vonage\Voice\NCCO\Action\Conversation($params['from']);
    $conversationAction->setStartOnEnter(false);

    $ncco->addAction($conversationAction);

    error_log('Inbound call from ' . $params['from'] . ' - ID: ' . $params['uuid']);

    $response->getBody()->write(
        json_encode($ncco->toArray())
    );

    return $response
        ->withHeader('Content-Type', 'application/json');
});

// Here for debugging
$app->get('/webhooks/event', function (Request $request, Response $response, $args) {
    var_dump($request->getQueryParams());

    return $response->withStatus(200);
});

// Here for debugging
$app->post('/webhooks/event', function (Request $request, Response $response, $args) {
    var_dump($request->getParsedBody());

    return $response->withStatus(200);
});

$app->get('/trigger/{id}/{position}', function (Request $request, Response $response, $args) use ($client) {
    $position = $args['position'];

    // Only positions 1, 2 and 3 are allowed
    if (!in_array($position, [1, 2, 3])) {
        return $response->withStatus(400);
    }

    // Stream the audio
    $stream = $client->voice()->streamAudio(
        $args['id'],
        getCurrentUrl($request) . '/position_' . $position . '.mp3'
    );

    return $response->withStatus(204);
});

$app->run();
