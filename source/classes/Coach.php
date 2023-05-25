<?php

class Coach extends DB
{
    function getCoachJoin()
    {
        $query = "SELECT coaches.*, teams.team_name FROM coaches JOIN teams ON coaches.team_id = teams.team_id ORDER BY coaches.coach_id";
        return $this->execute($query);
    }

    function getCoach()
    {
        $query = "SELECT * FROM coaches";
        return $this->execute($query);
    }

    function getCoachById($id)
    {
        $query = "SELECT coaches.*, teams.team_name FROM coaches JOIN teams ON coaches.team_id = teams.team_id WHERE coach_id = $id";
        return $this->execute($query);
    }

    function searchCoach($keyword)
    {
        $query = "SELECT coaches.*, teams.team_name FROM coaches JOIN teams ON coaches.team_id = teams.team_id WHERE coach_name LIKE '%$keyword%' OR coach_nationality LIKE '%$keyword%' OR teams.team_name LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addCoach($data)
    {
        $coach_name = $data['coach_name'];
        $coach_nationality = $data['coach_nationality'];
        $team_id = $data['team_id'];
        $query = "INSERT INTO coaches VALUES('', '$coach_name', '$coach_nationality', '$team_id')";
        return $this->executeAffected($query);
    }

    function updateCoach($id, $data)
    {
        $coach_name = $data['coach_name'];
        $coach_nationality = $data['coach_nationality'];
        $team_id = $data['team_id'];
        $query = "UPDATE coaches SET
            coach_name = '$coach_name',
            coach_nationality = '$coach_nationality',
            team_id = '$team_id'
            WHERE coach_id = $id";
        return $this->executeAffected($query);
    }

    function deleteCoach($id)
    {
        $query = "DELETE FROM coaches WHERE coach_id = $id";
        return $this->executeAffected($query);
    }
}
