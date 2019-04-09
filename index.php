<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$client = new \Nexmo\Client(
    new \Nexmo\Client\Credentials\Keypair(
        file_get_contents('./private.key'),
        'NEXMO_APPLICATION_ID'
    )
);

$app = new \Slim\App;

function getCurrentUrl($request) {
    $uri = $request->getUri();

    $url = $uri->getScheme().'://'.$uri->getHost();
    if ($port = $uri->getPort()) {
        $url .= ':'.$port;
    }

    return $url;
}

$app->get('/webhooks/answer', function (Request $request, Response $response) {
    $params = $request->getQueryParams();
    $ncco = [
        [
            'action' => 'stream',
            'streamUrl' => [getCurrentUrl($request).'/welcome.mp3']
        ],
        [
            'action' => 'conversation',
            'name' => $params['from'],
            'startOnEnter' => false
        ]
    ];
    error_log('Inbound call from '.$params['from'].' - ID: '.$params['uuid']);
    return $response->withJson($ncco);
});

$app->get('/trigger/{id}/{position}', function (Request $request, Response $response, $args) use ($client) {
    $position = $args['position'];

    // Only positions 1, 2 and 3 are allowed
    if (!in_array($position, [1,2,3])) {
        return $response->withStatus(400);
    }

    // Stream the audio
    $stream = $client->calls[$args['id']]->stream();
    $stream->setUrl(getCurrentUrl($request).'/position_'.$position.'.mp3');
    $stream->put();
    return $response->withStatus(204);
});

$app->run();
