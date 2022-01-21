<?php
// global $log;
// $docker_network_info = json_decode(shell_exec($_ENV['CMD_DOCKER_NETWORK_INFO']), true)[0];
// if (!$docker_network_info) {
//     $log->error("Erreur pendant la récupération de l'IP du container");
//     throw new Exception("Erreur pendant la récupération de l'IP du container", 1);
// }
// $container = $docker_network_info['Containers'][array_key_first($docker_network_info['Containers'])];
// $ip = explode('/', $container['IPv4Address'])[0];
// define('CONTAINER_IP', $ip);