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
    $data .= '<div class="col-lg-3 mb-5">' .
        '<div class="card px-2 matches-thumbnail">
            <a href="detail.php?id=' . $row['match_id'] . '">
                <div class="card-body">
                    <div class="d-flex justify-content-start">
                        <p class="card-text my-0">' . $row['home_team_score'] .'</p>
                        <p class="card-text my-0 mx-2">|</p>
                        <p class="card-text my-0">' . $row['home_team_name'] .'</p>
                    </div>
                    <div class="d-flex justify-content-start">
                        <p class="card-text my-0">' . $row['away_team_score'] .'</p>
                        <p class="card-text my-0 mx-2">|</p>
                        <p class="card-text my-0">' . $row['away_team_name'] .'</p>
                    </div>
                    <p class="card-text mt-3 mb-0">' . $row['match_date'] . '</p>
                    <p class="card-text">' . $row['match_location'] . '</p>
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
$home->write();
