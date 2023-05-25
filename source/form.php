<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Matches.php');
include('classes/Team.php');
include('classes/Template.php');

$matches = new Matches($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$matches->open();

$team = new Team($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$team->open();

$team_home_options = null;
$team_away_options = null;

$view = new Template('templates/skinform.html');

if (!isset($_GET['edit'])) {
    if (isset($_POST['submit'])) {
        if ($matches->addMatches($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'form.php';
            </script>";
        }
    }

    $btn_title = "Tambah";

    $team->getTeam();
    while ($row = $team->getResult()) {
        $team_home_options .= "<option value=" . $row['team_id'] . ">" . $row['team_name'] . "</option>";
    }

    $team->getTeam();
    while ($row = $team->getResult()) {
        $team_away_options .= "<option value=" . $row['team_id'] . ">" . $row['team_name'] . "</option>";
    }
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $btn_title = "Ubah";

    if (isset($_POST['submit'])) {
        if ($matches->updateMatches($id, $_POST) > 0) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
        }
    }

    $matches->getMatchesById($id);
    $row = $matches->getResult();

    $home_team_id = $row['home_team_id'];
    $away_team_id = $row['away_team_id'];
    $match_date = $row['match_date'];
    $match_location = $row['match_location'];
    $home_team_score = $row['home_team_score'];
    $away_team_score = $row['away_team_score'];

    $view->replace('DATA_VAL_MATCH_DATE_UPDATE', $match_date);
    $view->replace('DATA_VAL_MATCH_LOCATION_UPDATE', $match_location);
    $view->replace('DATA_VAL_HOME_SCORE_UPDATE', $home_team_score);
    $view->replace('DATA_VAL_AWAY_SCORE_UPDATE', $away_team_score);

    $team->getTeam();
    while ($row = $team->getResult()) {
        $select = ($row['team_id'] == $home_team_id) ? 'selected' : "";
        $team_home_options .= "<option value=" . $row['team_id'] . " . $select . >" . $row['team_name'] . "</option>";
    }

    $team->getTeam();
    while ($row = $team->getResult()) {
        $select = ($row['team_id'] == $away_team_id) ? 'selected' : "";
        $team_away_options .= "<option value=" . $row['team_id'] . " . $select . >" . $row['team_name'] . "</option>";
    }
}

$matches->close();
$team->close();

$view->replace('HOME_TEAM_OPTIONS', $team_home_options);
$view->replace('AWAY_TEAM_OPTIONS', $team_away_options);
$view->replace('DATA_BUTTON', $btn_title);
$view->write();