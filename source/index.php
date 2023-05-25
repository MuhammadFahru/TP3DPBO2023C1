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
    $listMatches->getMatches();
}

$data = null;

// ambil data matches
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listMatches->getResult()) {
    $data .= '<div class="col-lg-4">' .
        '<div class="card px-2 matches-thumbnail">
            <a href="detail.php?id=' . $row['match_id'] . '">
                <div class="card-body">
                    <p class="card-text my-0">' . $row['match_date'] . '</p>
                    <p class="card-text">' . $row['match_location'] . '</p>
                    <p class="card-text my-0">' . $row['home_team_score'] . '</p>
                    <p class="card-text my-0">' . $row['away_team_score'] . '</p>
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
