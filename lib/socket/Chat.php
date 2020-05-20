<?php
namespace libs\socket;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    public $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen( ConnectionInterface $conn ) {
        $this->clients->attach($conn);
    }

    public function onMessage( ConnectionInterface $from, $msg ) {
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function onClose( ConnectionInterface $conn ) {
        $this->clients->detach($conn);
    }

    public function onError( ConnectionInterface $conn, \Exception $e ) {
        echo $e->getMessage();
        $conn->onClose();
    }
}