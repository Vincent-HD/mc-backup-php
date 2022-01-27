<?php
function get_last_backup_date() {
    if (!file_exists(ABSPATH . '/lastbackup')) {
        return false;
    }
    $date_string = file_get_contents(ABSPATH . '/lastbackup');
    $backup_date = DateTime::createFromFormat('d-m-Y--H-i-s', $date_string, new DateTimeZone('Europe/Paris'));

    return $backup_date;
}

function is_backup_needed($is_3hr_backup = false) {
    global $log;
    $current_date = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $last_backup_date = get_last_backup_date();
    if ($last_backup_date === false) return true;
    $date_diff = date_diff($current_date, $last_backup_date);
    $diff_minutes = $date_diff->h * 60 + $date_diff->i;
    if ($is_3hr_backup && $diff_minutes > 175 || !$is_3hr_backup) { // 175 -> 2h55min
        $msg = 'Backup de ' . ($is_3hr_backup) ? '3h':'30min' . ' nécéssaire';
        $log->info($msg);
        return true;
    }
    $log->info('Backup non nécéssaire', ['heures' => $date_diff->h, 'minutes' => $date_diff->i]);
    return false;
}

function do_backup($is_3hr_backup = false) {
    global $log;
    if (!is_backup_needed($is_3hr_backup)) return;

    $cmd_code = null;
    $log->info("Démarrage du zip ...");
    $cmd = $_ENV['TAR_CMD'];
    $save_path = $_ENV['SAVE_PATH'];
    $current_date = (new DateTime())->format('d-m-Y--H-i-s');
    $filename = $current_date . '---backup-world.tar.gz';
    $full_filepath = $save_path . '/' . $filename;

    $log->info("Archive: $full_filepath ");
    $cmd = sprintf($cmd, $full_filepath);
    exec($cmd, $cmd_otp, $cmd_code);
    if ($cmd_code > 0) {
        $log->error("Une erreur est survenue pendant la création de l'archive", [
            'code'    => $cmd_code,
            'message' => $cmd_otp
        ]);
        rename($full_filepath, $save_path . '/failed/' . $filename);
        exit(1);
    }
    $log->info('Archive créée');
    file_put_contents(ABSPATH . '/lastbackup', $current_date);
    upload_backup($full_filepath);
}

function upload_backup($filename) {
    global $log;
    $upload_cmd = sprintf($_ENV['UPLOAD_CMD'], $filename);
    $log->info("Envoie en cours ...");
    exec($upload_cmd, $cmd_otp, $cmd_code);
    if ($cmd_code > 0) {
        $log->error("Une erreur est survenue pendant l'envoi de l'archive", [
            'code'    => $cmd_code,
            'message' => $cmd_otp
        ]);
        exit(1);
    }
    $log->info('Envoie effectué !');
    $log->info('Fin du script');
    exit(0);
}