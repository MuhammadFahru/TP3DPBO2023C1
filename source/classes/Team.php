<?php

class Team extends DB
{
    function getTeam()
    {
        $query = "SELECT * FROM teams";
        return $this->execute($query);
    }

    function getTeamById($id)
    {
        $query = "SELECT * FROM teams WHERE team_id=$id";
        return $this->execute($query);
    }

    function searchTeam($keyword)
    {
        $query = "SELECT * FROM teams WHERE team_name LIKE '%$keyword%' OR team_home_stadium LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addTeam($data, $file)
    {
        $tmp_file = $file['team_logo']['tmp_name'];
        $team_logo = $file['team_logo']['name'];
        $dir = "assets/uploaded/$team_logo";
        move_uploaded_file($tmp_file, $dir);

        $team_name = $data['team_name'];
        $team_founded_date = $data['team_founded_date'];
        $team_home_stadium = $data['team_home_stadium'];
        $query = "INSERT INTO teams VALUES('', '$team_name', '$team_logo', '$team_founded_date', '$team_home_stadium')";
        return $this->executeAffected($query);
    }

    function updateTeam($id, $data, $file, $oldfile)
    {
        $tmp_file = $file['team_logo']['tmp_name'];
        $team_logo = $file['team_logo']['name'];

        if ($team_logo == "") {
            $team_logo = $oldfile;
        }

        $dir = "assets/uploaded/$team_logo";
        move_uploaded_file($tmp_file, $dir);

        $team_name = $data['team_name'];
        $team_founded_date = $data['team_founded_date'];
        $team_home_stadium = $data['team_home_stadium'];
        $query = "UPDATE teams SET
            team_name = '$team_name',
            team_logo = '$team_logo',
            team_founded_date = '$team_founded_date',
            team_home_stadium = '$team_home_stadium'
            WHERE team_id = $id";
        return $this->executeAffected($query);
    }

    function deleteTeam($id)
    {
        $query = "DELETE FROM teams WHERE team_id = $id";
        return $this->executeAffected($query);
    }
}
