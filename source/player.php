<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Player.php');
include('classes/Team.php');
include('classes/Template.php');

$player = new Player($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$player->open();

$team = new Team($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$team->open();

$team_options = null;

$view = new Template('templates/skintabelplayer.html');

if (isset($_POST['btn-cari'])) {
    $player->searchPlayer($_POST['cari']);
} else {
    $player->getPlayerJoin();
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($player->addPlayer($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'player.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'player.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';

    $team->getTeam();
    while ($row = $team->getResult()) {
        $team_options .= "<option value=" . $row['team_id'] . ">" . $row['team_name'] . "</option>";
    }

}

$mainTitle = 'Player';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama</th>
<th scope="row">Posisi</th>
<th scope="row">Tanggal Lahir</th>
<th scope="row">Team</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;

while ($div = $player->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
        <td class="text-start ps-3">' . htmlspecialchars($div['player_name']) . '</td>
        <td>' . htmlspecialchars($div['player_position']) . '</td>
        <td>' . htmlspecialchars($div['player_birthdate']) . '</td>
        <td>' . htmlspecialchars($div['team_name']) . '</td>
        <td style="font-size: 22px;">
            <a style = "text-decoration:none;" href="player.php?id=' . $div['player_id'] . '" title="Edit Data">
                <i class="bi bi-pencil-square text-warning"></i>
            </a>&nbsp;
            <a href="player.php?hapus=' . $div['player_id'] . '" title="Delete Data" class="confirmation"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($player->updatePlayer($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'player.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'player.php';
            </script>";
            }
        }

        $player->getPlayerById($id);
        $row = $player->getResult();

        $player_name = $row['player_name'];
        $player_position = $row['player_position'];
        $player_birthdate = $row['player_birthdate'];
        $team_id = $row['team_id'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_NAME_UPDATE', $player_name);
        $view->replace('DATA_VAL_POSITION_UPDATE', $player_position);
        $view->replace('DATA_VAL_BIRTHDATE_UPDATE', $player_birthdate);

        $team->getTeam();
        while ($row = $team->getResult()) {
            $select = ($row['team_id'] == $team_id) ? 'selected' : "";
            $team_options .= "<option value=" . $row['team_id'] . " . $select . >" . $row['team_name'] . "</option>";
        }
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($player->deletePlayer($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'player.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'player.php';
            </script>";
        }
    }
}

$player->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_TABEL', $data);
$view->replace('TEAM_OPTIONS', $team_options);
$view->write();