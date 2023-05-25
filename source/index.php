<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Matches.php');
include('classes/Template.php');

// buat instance matches
$listMatches = new Matches($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listMatches->open();

// tampilkan data matches
$listMatches->getMatchesJoin();

// cari matches
if (isset($_POST['btn-cari'])) {
    // methode mencari data matches
    $listMatches->searchMatches($_POST['cari']);
} else {
    // method menampilkan data matches
    $listMatches->getMatchesJoin();
}

$data = null;

// ambil data matches
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listMatches->getResult()) {
    $data .= '<div class="col-4 mb-3">' .
        '<div class="card px-2 w-100">
            <a href="detail.php?id=' . $row['match_id'] . '">
                <div class="card-body">
                    <div class="d-flex justify-content-start">
                        <img src="assets/uploaded/' . $row['home_team_logo'] . '" alt="' . $row['home_team_name'] . '" style="width:50px; height:50px;" class="me-3 my-2">
                        <p class="card-text mt-4 my-0">' . htmlspecialchars($row['home_team_score']) .'</p>
                        <p class="card-text mt-4 my-0 mx-2">|</p>
                        <p class="card-text mt-4 my-0">' . htmlspecialchars($row['home_team_name']) .'</p>
                    </div>
                    <div class="d-flex justify-content-start">
                    <img src="assets/uploaded/' . $row['away_team_logo'] . '" alt="' . $row['away_team_name'] . '" style="width:50px; height:50px;" class="me-3 my-2">
                        <p class="card-text mt-4 my-0">' . htmlspecialchars($row['away_team_score']) .'</p>
                        <p class="card-text mt-4 my-0 mx-2">|</p>
                        <p class="card-text mt-4 my-0">' . htmlspecialchars($row['away_team_name']) .'</p>
                    </div>
                    <p class="card-text text-navy mt-3 mb-0">' . htmlspecialchars($row['match_date']) . '</p>
                </div>
            </a>
        </div>    
    </div>';
}

// tutup koneksi
$listMatches->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_MATCHES', $data);
$home->replace('LINK', 'index.php');
$home->write();
