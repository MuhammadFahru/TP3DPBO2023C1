<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Team.php');
include('classes/Template.php');

$team = new Team($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$team->open();

$tmp_img = new Team($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$tmp_img->open();

$view = new Template('templates/skintabelteam.html');

if (isset($_POST['btn-cari'])) {
    $team->searchTeam($_POST['cari']);
} else {
    $team->getTeam();
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($team->addTeam($_POST, $_FILES) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'team.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'team.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
    $view->replace('LINK_LOGO', '');
}

$mainTitle = 'Team';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row" width="80">Logo</th>
<th scope="row">Nama</th>
<th scope="row">Tanggal Berdiri</th>
<th scope="row">Stadion</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;

while ($div = $team->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
        <td><img src="assets/uploaded/' . $div['team_logo'] . '" alt="' . $div['team_logo'] . '" width="80%"></td>
        <td class="text-start ps-3">' . htmlspecialchars($div['team_name']) . '</td>
        <td>' . htmlspecialchars($div['team_founded_date']) . '</td>
        <td>' . htmlspecialchars($div['team_home_stadium']) . '</td>
        <td style="font-size: 22px;">
            <a style = "text-decoration:none;" href="team.php?id=' . $div['team_id'] . '" title="Edit Data">
                <i class="bi bi-pencil-square text-warning"></i>
            </a>&nbsp;
            <a href="team.php?hapus=' . $div['team_id'] . '" title="Delete Data" class="confirmation"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tmp_img->getTeam();
    $tmp_img->getTeamById($id);
    $team_tmp = $tmp_img->getResult();
    $img_tmp = $team_tmp['team_logo'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($team->updateTeam($id, $_POST, $_FILES, $img_tmp) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'team.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'team.php';
            </script>";
            }
        }

        $team->getTeamById($id);
        $row = $team->getResult();

        $team_logo = '<a href="assets/uploaded/' . $row['team_logo'] . '" class="btn btn-info" target="_blank">Lihat</a>';
        $team_name = $row['team_name'];
        $team_founded_date = $row['team_founded_date'];
        $team_home_stadium = $row['team_home_stadium'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('LINK_LOGO', $team_logo);
        $view->replace('DATA_VAL_NAME_UPDATE', $team_name);
        $view->replace('DATA_VAL_FOUNDED_DATE_UPDATE', $team_founded_date);
        $view->replace('DATA_VAL_HOME_STADIUM_UPDATE', $team_home_stadium);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($team->deleteTeam($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'team.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'team.php';
            </script>";
        }
    }
}

$team->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_TABEL', $data);
$view->write();