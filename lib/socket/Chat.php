<?php
namespace libs\socket;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        //inicia um novo "objeto de objetos"
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen( ConnectionInterface $conn ) {
        //adiciona a nova conexao aos clients da aplicacao
        $this->clients->attach($conn);
    }

    public function onMessage( ConnectionInterface $from, $msg ) {
        //emit um socket para todos os clients
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function onClose( ConnectionInterface $conn ) {
        //desassocia o client q fechou conexao
        $this->clients->detach($conn);
    }

    public function onError( ConnectionInterface $conn, \Exception $e ) {
        echo $e->getMessage();
        $conn->onClose();
    }
}