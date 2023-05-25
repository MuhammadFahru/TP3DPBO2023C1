# Tugas Praktikum 3 DPBO

## Janji

Bismillah Saya Muhammad Fahru Rozi [2108927] mengerjakan soal Tugas Praktikum 3 dalam mata kuliah Desain Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

## Data Diri

- 2108927
- Muhammad Fahru Rozi
- Ilmu Komputer C1'21
- Universitas Pendidikan Indonesia

## Desain Program

Program yang saya buat yaitu Sistem EPL (English Premier League), berikut adalah desain yang saya rancang:

Tabel teams:
- team_id (PK)
- team_name
- team_logo
- team_founded_date
- team_home_stadium

Tabel players:
- player_id (PK)
- player_name
- player_position
- player_birthdate
- team_id (FK(teams))

Tabel coaches:
- coach_id (PK)
- coach_name
- coach_nationality
- team_id (FK(teams))

Tabel matches:
- match_id (PK)
- home_team_id (FK(teams))
- away_team_id (FK(teams))
- match_date
- match_location
- home_team_score
- away_team_score

Dalam desain ini, tabel teams digunakan untuk menyimpan informasi tentang tim-tim yang berpartisipasi dalam liga EPL. Setiap tim memiliki identifikasi unik (team_id), nama ti (team_name), logo tim (team_logo), tanggal didirikan (team_founded_date), dan stadion kandang (team_home_stadium).

Tabel players digunakan untuk menyimpan informasi tentang pemain-pemain dalam liga. Setiap pemain memiliki identifikasi unik (player_id), nama pemain (player_name), posis pemain (player_position), tanggal lahir pemain (player_birthdate), dan referensi ke tim yang dia mainkan (team_id).

Tabel coaches digunakan untuk menyimpan informasi tentang pelatih-pelatih dalam liga. Setiap pelatih memiliki identifikasi unik (coach_id), nama pelatih (coach_name) kewarganegaraan pelatih (coach_nationality), dan referensi ke tim yang dia latih (team_id).

Tabel matches digunakan untuk menyimpan informasi tentang pertandingan-pertandingan dalam liga. Setiap pertandingan memiliki identifikasi unik (match_id), tim tuan rumah(home_team_id), tim tamu (away_team_id), tanggal pertandingan (match_date), lokasi pertandingan (match_location), skor tim tuan rumah (home_team_score), dan skor tim tamu (away_team_score).

## Alur Program

...