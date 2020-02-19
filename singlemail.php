<?php
/**
 * Created by PhpStorm.
 * User: brandonfranke
 * Date: 2020-02-19
 * Time: 09:40
 */


?>

<?php

$title = "Mail Message";
include_once "db/functions.php";
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
        <div class="sidebar-heading">Mail <a href="sendmail.php" class="btn btn-info float-right" role="button">New Message</a></div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="list-group-item list-group-item-action bg-light">Inbox</a>
            <a href="sent.php" class="list-group-item list-group-item-action bg-light">Sent</a>
            <a href="index.php?archive=true" class="list-group-item list-group-item-action bg-light">Archive</a>

            <form method="GET" action= "index.php" class="form-inline my-2 my-lg-0">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="searchEmail">
                <button class="btn btn-outline-success" type="submit" name="submitSearchEmail">Search</button>
            </form>

        </div>


    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <div class="container-fluid">

            <?php

            if (!isset($_GET['id'])){
                echo "You've taken a wrong turn! Please wait and you will automatically be redirected.";
                echo '<meta http-equiv = "refresh" content = "2; url = index.php" />';
            } else {
                $conn = OpenCon();
                $singleEmail = getSingleMail($_GET['id'], $conn);

                $row = mysqli_fetch_array($singleEmail);



            ?>


            <table class="table" id="emails">
                <thead>
                <tr>
                    <th scope="col">From</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Time</th>
                </tr>
                </thead>



                <tbody>
                    <tr>
                        <th scope="row"><?php echo $row['emailFrom'] ?></th>
                        <td><?php echo $row['emailSubject'] ?></td>
                        <td><?php echo $row['emailTime'] ?></td>
                    </tr>
                </tbody>
            </table>

            Message:
            <br>

            <?php
            echo $row['emailContent'];

            }
            ?>



        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap core JavaScript -->
<script src="jquery/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>

<script>

</script>



</body>
</html>
