<?php

define('ROOT_PATH', '../');
include ROOT_PATH . 'define.php';
defined( '_PHP_CONGES' ) or die( 'Restricted access' );

/*******************************************************************/
// SCRIPT DE MIGRATION DE LA VERSION 1.10 vers 1.11
/*******************************************************************/
include ROOT_PATH .'fonctions_conges.php' ;
include INCLUDE_PATH .'fonction.php';

$PHP_SELF = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);

$version = (isset($_GET['version']) ? $_GET['version'] : (isset($_POST['version']) ? $_POST['version'] : "")) ;
$version = htmlentities($version, ENT_QUOTES | ENT_HTML401);

$sql = \includes\SQL::singleton();
$sql->getPdoObj()->begin_transaction();

$alter_user_id = "ALTER TABLE conges_users ADD user_id INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD INDEX(user_id);";
$res_alter_user_id = \includes\SQL::query($alter_user_id);

$alter_user_login = "alter table conges_users drop primary key, ADD PRIMARY KEY(user_id), ADD UNIQUE(u_login);";
$res_alter_user_login = \includes\SQL::query($alter_user_login);

$drop_index_inutile = "drop index user_id on conges_users;";
$res_drop_index_inutile = \includes\SQL::query($drop_index_inutile);

$alter_echange = "ALTER TABLE conges_echange_rtt ADD user_id INT(11) NULL";
$res_alter_echange = \includes\SQL::query($alter_echange);

$update_user_echange = "UPDATE conges_echange_rtt JOIN conges_users 
                        ON conges_echange_rtt.e_login = conges_users.u_login
                        SET conges_echange_rtt.user_id = conges_users.user_id";
$res_update_user_echange =\includes\SQL::query($update_user_echange);

$alter_user_echange = "ALTER TABLE conges_echange_rtt CHANGE user_id user_id INT(11) NOT NULL";
$res_alter_user_echange = \includes\SQL::query($alter_user_echange);

$alter_pk_echange = "alter table conges_echange_rtt drop primary key, ADD PRIMARY KEY(user_id,e_date_jour);";
$res_alter_pk_echange = \includes\SQL::query($alter_pk_echange);

$alter_e_login = "ALTER TABLE conges_echange_rtt DROP e_login;";
$res_alter_e_login = \includes\SQL::query($alter_e_login);

$alter_edition = "ALTER TABLE conges_edition_papier ADD user_id INT(11) NULL";
$res_alter_edition = \includes\SQL::query($alter_edition);

$update_echange = "UPDATE conges_edition_papier JOIN conges_users 
                        ON conges_edition_papier.ep_login = conges_users.u_login
                        SET conges_edition_papier.user_id = conges_users.user_id";
$res_update_echange =\includes\SQL::query($update_echange);

$alter_ep_login = "ALTER TABLE conges_edition_papier DROP ep_login;";
$res_alter_ep_login = \includes\SQL::query($alter_ep_login);

$alter_groupe_grd_resp = "ALTER TABLE conges_groupe_grd_resp ADD user_id INT(11) NULL";
$res_alter_groupe_grd_resp = \includes\SQL::query($alter_groupe_grd_resp);

$update_groupe_grd_resp = "UPDATE conges_groupe_grd_resp JOIN conges_users 
                        ON conges_groupe_grd_resp.ggr_login = conges_users.u_login
                        SET conges_groupe_grd_resp.user_id = conges_users.user_id";
$res_update_groupe_grd_resp =\includes\SQL::query($update_groupe_grd_resp);

$alter_ggr_login = "ALTER TABLE conges_groupe_grd_resp DROP ggr_login;";
$res_alter_ggr_login = \includes\SQL::query($alter_ggr_login);

$alter_groupe_resp = "ALTER TABLE conges_groupe_resp ADD user_id INT(11) NULL";
$res_alter_groupe_resp = \includes\SQL::query($alter_groupe_resp);

$update_groupe_resp = "UPDATE conges_groupe_resp JOIN conges_users 
                        ON conges_groupe_resp.gr_login = conges_users.u_login
                        SET conges_groupe_resp.user_id = conges_users.user_id";
$res_update_groupe_resp =\includes\SQL::query($update_groupe_resp);

$alter_gr_login = "ALTER TABLE conges_groupe_resp DROP gr_login;";
$res_alter_gr_login = \includes\SQL::query($alter_gr_login);

$alter_groupe_users = "ALTER TABLE conges_groupe_users ADD user_id INT(11) NULL";
$res_alter_groupe_users = \includes\SQL::query($alter_groupe_users);

$update_groupe_users = "UPDATE conges_groupe_users JOIN conges_users 
                        ON conges_groupe_users.gu_login = conges_users.u_login
                        SET conges_groupe_users.user_id = conges_users.user_id";
$res_update_groupe_users =\includes\SQL::query($update_groupe_users);

$alter_gu_login = "ALTER TABLE conges_groupe_users DROP gu_login;";
$res_alter_gu_login = \includes\SQL::query($alter_gu_login);

$alter_logs = "ALTER TABLE conges_logs ADD user_id_par INT NULL, ADD `user_id_pour` INT NULL";
$res_alter_logs = \includes\SQL::query($alter_logs);

$update_logs_par = "UPDATE conges_logs JOIN conges_users 
                        ON conges_logs.log_user_login_par = conges_users.u_login
                        SET conges_logs.user_id_par = conges_users.user_id";
$res_update_logs_par =\includes\SQL::query($update_logs_par);

$update_logs_pour = "UPDATE conges_logs JOIN conges_users 
                        ON conges_logs.log_user_login_pour = conges_users.u_login
                        SET conges_logs.user_id_pour = conges_users.user_id";
$res_update_logs_pour =\includes\SQL::query($update_logs_pour);

$alter_logs_pour = "ALTER TABLE conges_logs DROP log_user_login_pour;";
$res_alter_logs_pour = \includes\SQL::query($alter_logs_pour);

$alter_logs_par = "ALTER TABLE conges_logs DROP log_user_login_par;";
$res_alter_logs_par = \includes\SQL::query($alter_logs_par);

$alter_periode = "ALTER TABLE conges_periode ADD user_id INT(11) NULL";
$res_alter_periode = \includes\SQL::query($alter_periode);

$update_periode = "UPDATE conges_periode JOIN conges_users 
                        ON conges_periode.p_login = conges_users.u_login
                        SET conges_periode.user_id = conges_users.user_id";
$res_update_periode =\includes\SQL::query($update_periode);

$alter_ep_login = "ALTER TABLE conges_periode DROP p_login;";
$res_alter_ep_login = \includes\SQL::query($alter_ep_login);

$alter_solde = "ALTER TABLE conges_solde_user ADD user_id INT(11) NULL FIRST";
$res_alter_solde = \includes\SQL::query($alter_solde);

$update_solde = "UPDATE conges_solde_user JOIN conges_users 
                        ON conges_solde_user.su_login = conges_users.u_login
                        SET conges_solde_user.user_id = conges_users.user_id";
$res_update_solde =\includes\SQL::query($update_solde);

$alter_solde = "ALTER TABLE conges_solde_user CHANGE user_id user_id INT(11) NOT NULL";
$res_alter_solde = \includes\SQL::query($alter_solde);

$alter_pk_solde = "alter table conges_solde_user drop primary key, ADD PRIMARY KEY(user_id,su_abs_id);";
$res_alter_pk_solde = \includes\SQL::query($alter_pk_solde);

$alter_su_login = "ALTER TABLE conges_solde_user DROP su_login;";
$res_alter_su_login = \includes\SQL::query($alter_su_login);

$alter_additionnelle = "ALTER TABLE heure_additionnelle ADD user_id INT(11) NULL";
$res_alter_additionnelle = \includes\SQL::query($alter_additionnelle);

$update_additionnelle = "UPDATE heure_additionnelle JOIN conges_users 
                        ON heure_additionnelle.login = conges_users.u_login
                        SET heure_additionnelle.user_id = conges_users.user_id";
$res_update_additionnelle =\includes\SQL::query($update_additionnelle);

$alter_login_add = "ALTER TABLE heure_additionnelle DROP login;";
$res_alter_login_add = \includes\SQL::query($alter_login_add);

$alter_repos = "ALTER TABLE heure_repos ADD user_id INT(11) NULL";
$res_alter_repos = \includes\SQL::query($alter_repos);

$update_repos = "UPDATE heure_repos JOIN conges_users 
                        ON heure_repos.login = conges_users.u_login
                        SET heure_repos.user_id = conges_users.user_id";
$res_update_repos =\includes\SQL::query($update_repos);

$alter_login_repos = "ALTER TABLE heure_repos DROP login;";
$res_alter_login_repos = \includes\SQL::query($alter_login_repos);



$sql->getPdoObj()->commit();

// on renvoit à la page mise_a_jour.php (là d'ou on vient)
echo "Migration depuis v1.10 effectuée. <a href=\"mise_a_jour.php?etape=2&version=$version\">Continuer.</a><br>\n";
