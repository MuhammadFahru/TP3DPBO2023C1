<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Matches.php');
include('classes/Player.php');
include('classes/Template.php');

$matches = new Matches($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$matches->open();

$player_home = new Player($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$player_home->open();

$player_away = new Player($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$player_away->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $matches->getMatchesById($id);
        $row = $matches->getResult();

        $list_players_home = '';
        $player_home->getPlayerByIdTeam($row['home_team_id']);
        while ($data_players_home = $player_home->getResult()) {
            $list_players_home .= '<tr class="text-start"><td>' . htmlspecialchars($data_players_home['player_position']) . ' | ' . htmlspecialchars($data_players_home['player_name']) . '</td></tr>';
        }

        $list_players_away = '';
        $player_away->getPlayerByIdTeam($row['away_team_id']);
        while ($data_players_away = $player_away->getResult()) {
            $list_players_away .= '<tr class="text-start"><td>' . htmlspecialchars($data_players_away['player_position']) . ' | ' . htmlspecialchars($data_players_away['player_name']) . '</td></tr>';
        }

        $result_home = '';
        if ($row['home_team_score'] > $row['away_team_score']) {
            $result_home = 'bg-success';
        } else if ($row['away_team_score'] > $row['home_team_score']) {
            $result_home = 'bg-danger';
        } else {
            $result_home = 'bg-secondary';
        }

        $result_away = '';
        if ($row['away_team_score'] > $row['home_team_score']) {
            $result_away = 'bg-success';
        } else if ($row['home_team_score'] > $row['away_team_score']) {
            $result_away = 'bg-danger';
        } else {
            $result_away = 'bg-secondary';
        }

        $data .= '<div class="card-header text-start p-3">
            <div class="d-flex justify-content-between">
                <h4 class="my-0 mt-1">Detail Matches</h4>
                <div class="">
                    <a href="form.php?edit=' . $row['match_id'] . '"><button type="button" class="btn btn-warning"><i class="bi bi-pencil-square text-white"></i></button></a>
                    <a href="detail.php?hapus=' . $row['match_id'] . '" onclick="confirm(`Apakah Anda yakin untuk menghapus data ini?`)"><button type="button" class="btn btn-danger"><i class="bi bi-trash-fill text-white"></i></button></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-5">
                <div class="text-center col-4">
                    <img src="assets/uploaded/' . $row['home_team_logo'] . '" alt="' . $row['home_team_name'] . '" style="width:100px;">
                    <h3 class="card-text mt-4 my-0">' . htmlspecialchars($row['home_team_name']) . '</h3>
                    <p class="card-text"><span class="badge bg-navy p-2 mt-3">Home Team</span></p>
                </div>
                <div class="col-1 text-center">
                    <h1 class="mt-5"><span class="badge ' . $result_home  . '">' . htmlspecialchars($row['home_team_score']) . '</span></h1>
                </div>
                <div class="col-2 text-center">
                    <h1 class="mt-5"><strong>-</strong></h1>
                </div>
                <div class="col-1 text-center">
                    <h1 class="mt-5"><span class="badge ' . $result_away  . '">' . htmlspecialchars($row['away_team_score']) . '</span></h1>
                </div>
                <div class="text-center col-4">
                    <img src="assets/uploaded/' . $row['away_team_logo'] . '" alt="' . $row['away_team_name'] . '" style="width:100px;">
                    <h3 class="card-text mt-4 my-0">' . htmlspecialchars($row['away_team_name']) . '</h3>
                    <p class="card-text"><span class="badge bg-navy p-2 mt-3">Away Team</span></p>
                </div>
            </div>
            <div class="text-center mt-5 mb-2">
                <p class="card-text text-navy mt-3 mb-0">Tanggal Pertandingan</p>
                <p class="card-text text-navy mt-1 mb-0">' . htmlspecialchars($row['match_date']) . '</p>
                <p class="card-text text-navy mt-3 mb-0">Lokasi Pertandingan</p>
                <p class="card-text"><span class="badge bg-navy p-2 mt-2">' . htmlspecialchars($row['match_location']) . '</span></p>
            </div>
            <div class="row">
                <div class="col-6">
                    <table class="table table-bordered mt-5">
                        <thead class="bg-navy text-white">
                            <tr class="text-center">
                                <th scope="col">Player Home Team</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . $list_players_home . '
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table table-bordered mt-5">
                        <thead class="bg-navy text-white">
                            <tr class="text-center">
                                <th scope="col">Player Away Team</th>
                            </tr>
                        </thead>
                        <tbody>
                        ' . $list_players_away . '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>';
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($matches->deleteMatches($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

$matches->close();

$detail = new Template('templates/skindetail.html');
$detail->replace('TITLE_PAGE', 'Matches');
$detail->replace('DATA_DETAIL_MATCHES', $data);
$detail->write();
