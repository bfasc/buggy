<?php
function editProject($name, $category, $progress, $priority, $startDate, $endDate, $projectID, $customLink, $icon) {
    try {
        if($startDate) $startDate = date('Y-m-d H:i:s', strtotime($startDate));
        if($endDate) $endDate = date('Y-m-d H:i:s', strtotime($endDate));

        $db = db_connect();
        $values = [$name, $category, $startDate, $endDate, $progress, $priority, $customLink, $icon, $projectID];
        $sql = "UPDATE projectinfo
        SET projectName = ?,
        projectCategory = ?,
        startDate = ?,
        endDate = ?,
        status = ?,
        priority = ?,
        customLink = ?,
        projectIcon = ?
        WHERE id = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        //add to each selected developer's assigned projects
        $developerList = json_decode($_POST['developers']);

        $developerString = "";
        foreach($developerList as $key => $developer) {
            //substr because the list is developer-# since it grabs ids
            $developerString .= substr($developer, 10);
            if($key != count($developerList)-1) $developerString .= ",";
        }

        $developerList = explode(",", $developerString);
        foreach($developerList as $developerID) {
            //grab their assigned projects, check if it's already in there by exploding. If not, implode and append.
            $allProjects = getUserInfo($developerID, "assignedProjects");
            $projectList = explode(",", $allProjects);

            if(array_search($projectID, $projectList) === FALSE) { //not already in array
                $projectString = implode(",", $projectList);
                if($projectString) $projectString .= ",";
                $projectString .= "$projectID";
                $values = [$projectString, $developerID];
                $sql = "UPDATE userinfo SET assignedProjects = ? WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute($values);
            }
        }



        //remove any unselected developers assigned projects
        $unassignedDeveloperList = json_decode($_POST['unassignedDevelopers']);

        $unassignedDeveloperString = "";
        foreach($unassignedDeveloperList as $key => $developer) {
            //substr because the list is developer-# since it grabs ids
            $unassignedDeveloperString .= substr($developer, 10);
            if($key != count($unassignedDeveloperList)-1) $unassignedDeveloperString .= ",";
        }

        $unassignedDeveloperList = explode(",", $unassignedDeveloperString);
        foreach($unassignedDeveloperList as $developerID) {
            //grab their assigned projects, check if it's already in there by exploding. If it is, implode and take out.
            $allProjects = getUserInfo($developerID, "assignedProjects");
            $projectList = explode(",", $allProjects);
            if(array_search($projectID, $projectList) !== FALSE) { //exists in array
                $projectList = array_diff($projectList, ["$projectID"]);
                $projectString = implode(",", $projectList);
                $values = [$projectString, $developerID];
                $sql = "UPDATE userinfo SET assignedProjects = ? WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute($values);
            }
        }

        // Send notification to each assigned dev
        $newDevs = getProjectInfo($projectID, "assignedDevelopers");
        $newDevs = explode(",", $newDevs);
        foreach($newDevs as $dev) {
            newNotification("A project you're working on has been updated.", $dev, "");
        }

        return TRUE;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}

?>
