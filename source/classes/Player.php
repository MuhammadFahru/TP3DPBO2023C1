<?php

class Player extends DB
{
    function getPlayerJoin()
    {
        $query = "SELECT * FROM players JOIN teams ON players.team_id = teams.team_id ORDER BY players.player_id";
        return $this->execute($query);
    }

    function getPlayer()
    {
        $query = "SELECT * FROM players";
        return $this->execute($query);
    }

    function getPlayerById($id)
    {
        $query = "SELECT * FROM players JOIN teams ON players.team_id = teams.team_id WHERE player_id = $id";
        return $this->execute($query);
    }

    function searchPlayer($keyword)
    {
        $query = "SELECT * FROM players JOIN teams ON players.team_id = teams.team_id WHERE players.player_name LIKE '%$keyword%' OR players.player_position LIKE '%$keyword%' OR teams.team_name LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addPlayer($data)
    {
        $player_name = $data['player_name'];
        $player_position = $data['player_position'];
        $player_birthdate = $data['player_birthdate'];
        $team_id = $data['team_id'];
        $query = "INSERT INTO players VALUES('', '$player_name', '$player_position', '$player_birthdate', '$team_id')";
        return $this->executeAffected($query);
    }

    function updatePlayer($id, $data)
    {
        $player_name = $data['player_name'];
        $player_position = $data['player_position'];
        $player_birthdate = $data['player_birthdate'];
        $team_id = $data['team_id'];
        $query = "UPDATE players SET
            player_name = '$player_name',
            player_position = '$player_position',
            player_birthdate = '$player_birthdate',
            team_id = '$team_id'
            WHERE player_id = $id";
        return $this->executeAffected($query);
    }

    function deletePlayer($id)
    {
        $query = "DELETE FROM players WHERE player_id = $id";
        return $this->executeAffected($query);
    }
}
