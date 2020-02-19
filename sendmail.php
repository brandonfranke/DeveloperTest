<?php
/**
 * Created by PhpStorm.
 * User: brandonfranke
 * Date: 2020-02-19
 * Time: 09:40
 */


?>

<?php

$title = "Send Mail";
include_once "db/functions.php";


if (isset($_POST['submitNewMail'])){


    $conn = OpenCon();
    $emailAddress = $_POST['emailAddress'];
    $emailSubject = sanitize($conn, $_POST['emailSubject']);
    $emailContent = sanitize($conn, $_POST['emailContent']);
    $emailDate = date("Y-m-d H:i:s");
    $emailArchive = "NO";

    if (sendEmail($conn, $emailSubject, $emailAddress, $emailContent, $emailDate, $emailArchive)){
        echo "<p class='text-success text-center justify-content-center'>Email sent successfully!</p>";
    } else {
        echo mysqli_error($conn);
    }
}
?>



<html>

<head>
    <title>
        <?php echo $title ?>
    </title>

    <!-- Latest compiled and minified CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</head>


<body>

<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light blue border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Mail<a href="sendmail.php" class="btn btn-info float-right" role="button">New Message</a></div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="list-group-item list-group-item-action bg-light">Inbox</a>
            <a href="sent.php" class="list-group-item list-group-item-action bg-light">Sent</a>
            <a href="index.php?archive=true" class="list-group-item list-group-item-action bg-light">Archive</a>

            <form method="GET" action= "index.php" class="form-inline my-2 my-lg-0">
                <div class="input-group add-on">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="searchEmail">
                <button class="btn btn-outline-success" type="submit" name="submitSearchEmail">Search</button>
                </div>
            </form>

        </div>


    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <div class="container-fluid">





            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="text-center">
                        <br>
                        <h1 class="h1 mb-0 text-gray-800">Send Email</h1>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                    <!-- Default form login -->

                </div>
            </div>

            <div class="row justify-content-center">
            <div class="col-8 my-auto">
            <form method="POST" action="sendmail.php" class="text-center">


                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" name="emailAddress">
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" id="subject" placeholder="Subject" name="emailSubject">
                </div>

                <div class="form-group">
                    <label for="Message">Message</label>
                    <textarea class="form-control" id="Message" rows="10" name="emailContent"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" name="submitNewMail">Send</button>
            </form>
            </div>


        </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap core JavaScript -->
<script src="jquery/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>



</body>
</html>
