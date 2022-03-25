<?php


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use app\core\Application;
use app\core\DbModel;
use Ratchet\Http\HttpRequestParser;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


class Chat implements MessageComponentInterface {

    protected $clients;
    public array $dbConfig;
    public Application $app;
    public ?DbModel $user;
    public $data;
    public $toCall;


    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->dbConfig = ['db' => [
            'dsn' => $_ENV['DB_DSN'],
            'user' => $_ENV['DB_USER'],
            'password'=> $_ENV['DB_PASSWORD'],
        ]];
        $this->app = new Application( dirname(__DIR__) ,$this->dbConfig);
    }
    
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString,$query);

        if ($data = $query["token"]){
            $this->clients->attach($conn);
            $this->user = $this->app->userClass->findOne(["SessionID" => $data]);
            $data=$this->user;
            $this->data = $data;       
            $conn->data = $data;
            $this->app->userClass->updateSessionID($this->user->email,$conn->resourceId);
            echo "New connection!({$conn->resourceId}) and username ({$data->name})\n";
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        
        $data = json_decode($msg,true);
        if (!is_array($data["sendTo"])){
            $this->toCall = $this->app->userClass->findOne(["sessionID" => $data["sendTo"]]);
        }
        $send['sendTo'] =$this->toCall->sessionID;
        $send['by'] = $from->data->sessionID;
        $send['profileImage'] = $from->data->avatar;
        $send['username'] = $from->data->name;
        $send['type'] = $data["type"];
        $send['data'] = $data["data"];

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                if($client->resourceId == $this->toCall->connectionID || $from == $client){
                    $client->send(json_encode($send));
                }
                // The sender is not the receiver, send to each client connected
                
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}