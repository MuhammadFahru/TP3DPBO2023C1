<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Coach.php');
include('classes/Team.php');
include('classes/Template.php');

$coach = new Coach($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$coach->open();

$team = new Team($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$team->open();

$team_options = null;

$view = new Template('templates/skintabelcoach.html');

if (isset($_POST['btn-cari'])) {
    $coach->searchCoach($_POST['cari']);
} else {
    $coach->getCoachJoin();
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($coach->addCoach($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'coach.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'coach.php';
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

$mainTitle = 'Coach';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama</th>
<th scope="row">Negara</th>
<th scope="row">Team</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;

while ($div = $coach->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
        <td class="text-start ps-3">' . htmlspecialchars($div['coach_name']) . '</td>
        <td>' . htmlspecialchars($div['coach_nationality']) . '</td>
        <td>' . htmlspecialchars($div['team_name']) . '</td>
        <td style="font-size: 22px;">
            <a style = "text-decoration:none;" href="coach.php?id=' . $div['coach_id'] . '" title="Edit Data">
                <i class="bi bi-pencil-square text-warning"></i>
            </a>&nbsp;
            <a href="coach.php?hapus=' . $div['coach_id'] . '" title="Delete Data" class="confirmation"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($coach->updateCoach($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'coach.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'coach.php';
            </script>";
            }
        }

        $coach->getCoachById($id);
        $row = $coach->getResult();

        $coach_name = $row['coach_name'];
        $coach_nationality = $row['coach_nationality'];
        $team_id = $row['team_id'];
        
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_NAME_UPDATE', $coach_name);
        $view->replace('DATA_VAL_NATIONALITY_UPDATE', $coach_nationality);

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
        if ($coach->deleteCoach($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'coach.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'coach.php';
            </script>";
        }
    }
}

$coach->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_TABEL', $data);
$view->replace('TEAM_OPTIONS', $team_options);
$view->write();