<?php
/**
 * Created by PhpStorm.
 * User: brandonfranke
 * Date: 2020-02-19
 * Time: 10:30
 */


function OpenCon() {
    $dbhost = "";
    $dbuser = "";
    $dbpass = "";
    if ($_SERVER['SERVER_NAME'] == "localhost") {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "root";
    } else {
        $dbhost = "db.cs.dal.ca";
        $dbuser = "";
        $dbpass = "";
    }
    $db = "Dev_Emails";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);
    return $conn;
}

function CloseCon($conn) {
    mysqli_close($conn);
}

function sanitize($conn, $str){
    mysqli_real_escape_string($conn, trim($str));
    return $str;
}

function check_input($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES);
    $data = sanitize($conn, $data);
    return $data;
}

function getEmails($conn){
    $stmt = $conn->prepare("SELECT * FROM emails WHERE isArchived='NO' ORDER BY emailTime DESC");
    $stmt->execute();
    $allEmails = $stmt->get_result();
    $stmt->close();

    return $allEmails;
}


function getSentEmails($myEmail, $conn){
    $stmt = $conn->prepare("SELECT * FROM emails WHERE emailFrom='$myEmail' ORDER BY emailTime DESC");
    $stmt->execute();
    $allEmails = $stmt->get_result();
    $stmt->close();

    return $allEmails;
}

function getSingleMail($emailID, $conn){
    $stmt = $conn->prepare("SELECT * FROM emails WHERE emailID='$emailID' ORDER BY emailTime DESC");
    $stmt->execute();
    $singleMail = $stmt->get_result();
    $stmt->close();

    return $singleMail;
}

function getArchivedEmails($conn){
    $stmt = $conn->prepare("SELECT * FROM emails WHERE isArchived='YES' ORDER BY emailTime DESC");
    $stmt->execute();
    $allEmails = $stmt->get_result();
    $stmt->close();

    return $allEmails;
}

function searchEmails($conn, $searchString){
    $searchString = check_input($conn, $searchString);
    $searchString = "%{$searchString}%";

    $stmt = $conn->prepare("SELECT * FROM emails
        WHERE emailTime LIKE ?
        OR emailContent LIKE ?
        OR emailFrom LIKE ?
        OR emailSubject LIKE ?
        ORDER BY emailTime DESC");

    $stmt->bind_param("ssss", $searchString, $searchString, $searchString, $searchString);

    $stmt->execute();

    $searchEmails = $stmt->get_result();

    $stmt->close();

    return $searchEmails;
}

function sendEmail($conn, $emailSubject, $emailAddress, $emailContent, $emailDate, $emailArchive){

    $stmt = $conn->prepare("INSERT INTO emails (emailFrom, emailSubject, emailTime, emailContent, isArchived) 
        VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("sssss", $emailAddress, $emailSubject, $emailDate, $emailContent, $emailArchive);

    $insertEmail = $stmt->execute();

    // Close Prepared Statement
    $stmt->close();

    return $insertEmail;
}

function sendToArchive ($conn, $emailID){
    $stmt = $conn->prepare("UPDATE emails SET isArchived='YES' WHERE emailID='$emailID'");

    $stmt->execute();
    $stmt->close();
}

function sendToInbox ($conn, $emailID){
    $stmt = $conn->prepare("UPDATE emails SET isArchived='NO' WHERE emailID='$emailID'");

    $stmt->execute();
    $stmt->close();
}

function deleteEmail ($conn, $emailID){
    $stmt = $conn->prepare("DELETE FROM emails WHERE emailID='$emailID'");

    $stmt->execute();
    $stmt->close();
}