<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use libs\socket\Chat;

require 'vendor/autoload.php';

//cria um servidor WebSocket passando a classe
//usada para emitir e receber os sockets
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

//inicia o servidor
$server->run();