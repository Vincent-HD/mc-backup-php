<?php

$minecraft_rcon = new BkRcon();
$player_count = $minecraft_rcon->getConnectedPlayerCount();
$minecraft_rcon->close();

if ($player_count > 0 ) {
    do_backup();
} else {
    do_backup(true);
}