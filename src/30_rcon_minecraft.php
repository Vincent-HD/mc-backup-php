<?php
use D3lph1\MinecraftRconManager\DefaultConnector;
class BkRcon {
    private $rcon;
    private $connector;
    
    function __construct() {
        global $log;
        $this->connector = new DefaultConnector();
        try {
            $log->info('Tentative de connexion au RCON');
            $this->rcon = $this->connector->connect('localhost', $_ENV['RCON_PORT'], $_ENV['RCON_PASSWORD']);
        } catch (\Throwable $th) {
            echo "Erreur RCON\n";
            echo $th->getMessage() . "\n";
            $log->error('Une erreur est survenue pendant la connexion au RCON', [ 'code' => $th->getCode(), 'message', $th->getMessage() ]);
        }
    }
    
    public function getConnectedPlayerCount() {
        global $log;
        $response = $this->rcon->send('list');
        $result = [];
        preg_match('(\d+)', $response, $result);
        if (!$result) {
            return false;                
        }

        $playerCount = (int) $result[0];
        $log->info('Nombre de joueur connecté: ' . $playerCount);
        return $playerCount;
    }

    public function close() {
        global $log;
        $this->rcon->disconnect();
        $log->info('Session RCON fermée');
    }
}