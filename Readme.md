# SCRIPT SAUVEGARDE MINECRAFT

Regarde combien de joueurs sont connectés au serveur minecraft via `RCON`.

Si il y a des joueurs, sauvegarde toutes les **30 minutes**, sinon toutes les **3 heures**

Upload les backups sur un stockage remote via `Rclone`, toutes les archives qui ont subies des erreurs sont stockées dans le dossier `failed` en local