<?php

class Matches extends DB
{
    function getMatchesJoin()
    {
        $query = "SELECT matches.*, home.team_name AS home_team_name, away.team_name AS away_team_name, home.team_logo AS home_team_logo, away.team_logo AS away_team_logo FROM matches
            JOIN teams home ON matches.home_team_id = home.team_id
            JOIN teams away ON matches.away_team_id = away.team_id
            ORDER BY matches.match_id";
        return $this->execute($query);
    }

    function getMatches()
    {
        $query = "SELECT * FROM matches";
        return $this->execute($query);
    }

    function getMatchesById($id)
    {
        $query = "SELECT matches.*, home.team_id AS home_team_id, away.team_id AS away_team_id, home.team_name AS home_team_name, away.team_name AS away_team_name, home.team_logo AS home_team_logo, away.team_logo AS away_team_logo FROM matches
            JOIN teams home ON matches.home_team_id = home.team_id
            JOIN teams away ON matches.away_team_id = away.team_id
            WHERE match_id = $id";
        return $this->execute($query);
    }

    function searchMatches($keyword)
    {
        $query = "SELECT matches.*, home.team_name AS home_team_name, away.team_name AS away_team_name, home.team_logo AS home_team_logo, away.team_logo AS away_team_logo FROM matches
            JOIN teams home ON matches.home_team_id = home.team_id
            JOIN teams away ON matches.away_team_id = away.team_id
            WHERE home.team_name LIKE '%$keyword%' OR away.team_name LIKE '%$keyword%' OR matches.match_location LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addMatches($data)
    {
        $home_team_id = $data['home_team_id'];
        $away_team_id = $data['away_team_id'];
        $match_date = $data['match_date'];
        $match_location = $data['match_location'];
        $home_team_score = $data['home_team_score'];
        $away_team_score = $data['away_team_score'];
        $query = "INSERT INTO matches VALUES('', '$home_team_id', '$away_team_id', '$match_date', '$match_location', '$home_team_score', '$away_team_score')";
        return $this->executeAffected($query);
    }

    function updateMatches($id, $data)
    {
        $home_team_id = $data['home_team_id'];
        $away_team_id = $data['away_team_id'];
        $match_date = $data['match_date'];
        $match_location = $data['match_location'];
        $home_team_score = $data['home_team_score'];
        $away_team_score = $data['away_team_score'];
        $query = "UPDATE matches SET
            home_team_id = '$home_team_id',
            away_team_id = '$away_team_id',
            match_date = '$match_date',
            match_location = '$match_location',
            home_team_score = '$home_team_score',
            away_team_score = '$away_team_score'
            WHERE match_id = $id";
        return $this->executeAffected($query);
    }

    function deleteMatches($id)
    {
        $query = "DELETE FROM matches WHERE match_id = $id";
        return $this->executeAffected($query);
    }
}
