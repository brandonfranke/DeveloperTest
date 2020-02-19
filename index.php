<?php
/**
 * Created by PhpStorm.
 * User: brandonfranke
 * Date: 2020-02-19
 * Time: 09:40
 */


?>

<?php

$title = "Homepage";
include_once "db/functions.php";


if (isset($_GET['sendToArchive'])){

    $conn = OpenCon();
    sendToArchive($conn, $_GET['id']);
    echo '<meta http-equiv = "refresh" content = "2; url = index.php"/>';
}

if (isset($_GET['sendToInbox'])){

    $conn = OpenCon();
    sendToInbox($conn, $_GET['id']);
    echo '<meta http-equiv = "refresh" content = "2; url = index.php?archive=true"/>';
}

if (isset($_GET['deleteEmail'])){
    $conn = OpenCon();
    deleteEmail($conn, $_GET['id']);
    echo '<meta http-equiv = "refresh" content = "2; url = index.php"/>';
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
        <div class="sidebar-heading">Mail <a href="sendmail.php" class="btn btn-info float-right" role="button">New Message</a></div>
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


            <table class="table" id="emails">
                <thead>
                <tr>
                    <th scope="col">From</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Time</th>
                </tr>
                </thead>



                <tbody>


                <?php

                $conn = OpenCon();

                if (isset($_GET['archive']) && $_GET['archive'] == true){
                    $allEmails = getArchivedEmails($conn);
                } else if (isset($_GET['searchEmail'])){
                    $allEmails = searchEmails($conn, $_GET['searchEmail']);
                } else {
                    $allEmails = getEmails($conn);
                }
                    while ($row = mysqli_fetch_array($allEmails)) {
                        ?>

                        <tr>
                            <th scope="row"><?php echo $row['emailFrom'] ?></th>
                            <td><?php echo $row['emailSubject'] ?></td>
                            <td><?php echo $row['emailTime'] ?></td>
                            <td><a href="singlemail.php?id=<?php echo $row['emailID'] ?>"
                                   class="btn btn-primary">View</a></td>

                            <?php
                            if (!isset($_GET['archive'])){
                                ?>
                                <td><a href="index.php?id=<?php echo $row['emailID']?>&sendToArchive=true"
                                   class="btn btn-warning">Archive</a></td>
                            <?php
                            } else {
                                ?>
                                <td><a href="index.php?id=<?php echo $row['emailID']?>&sendToInbox=true&archive=true"
                                       class="btn btn-warning">Inbox</a></td>

                            <?php
                            }
                            ?>
                            <td><a href="index.php?id=<?php echo $row['emailID']?>&deleteEmail=true"
                                   class="btn btn-danger">Delete</a></td>

                        </tr>

                        <?php
                }
                ?>
                </tbody>
            </table>


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
