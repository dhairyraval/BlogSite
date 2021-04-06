<!--
	-- contributed by:
	-- Name: Arjun Banga
	-- Banner Number: B00852696
	--  Implemented the administrative interface which lets an admin create a new account with either microblog author or admin role. The admin interface can only be accessed once a user is logged in AND is an admin
	-- User Story: 6
-->

<?php
//if($_POST['verified'] != 1) {
//    if (!isset($_SESSION['handle'])) {
//        header("Location: ../index.php?noaccess=1");
//        die();
//    }
//    else if($_SESSION['admin'] == 0) {
//        header("Location: ../mainFeed.php?noaccess=1");
//    }
//}

require_once "header.php";
require_once "db.php";
?>

<!-- Create account form created with some modification from my Assignment 1
	Arjun Banga, Assignment 1: CSCI 2170 (Winter 2021), Faculty of Computer Science,
	Dalhousie University, Available online on GitLab at: https://git.cs.dal.ca/courses/2021-winter/csci-2170/a1/banga
	Date Accessed: March 27, 2021.
-->

<main id="pg-main-content">
    <br>
    <div class="container w-50 py-3">
        <div class="text-center">
            <h2 class="fw-light">Your profile</h2>
        </div>
        <!-- BootStrap Form Control
        https://getbootstrap.com/docs/5.0/forms/form-control/
        Accessed: January 27 2021
        Author: The Bootstrap Team -->
        <?php
            if (isset($_GET['passwordreset'])){
                if ($_GET['passwordreset']==1){
                    echo "<script>alert('Password Reseted');</script>";
                }
            }
        ?>
        <?php
        $uID = -1;
        if (isset($_SESSION['userid'])) {
            $uID = $_SESSION['userid'];
        }
        $query = "SELECT * FROM `Users` WHERE `id` = $uID";
        $result = $dbconnection->query($query);
        $row = $result->fetch_assoc();
        $userName = $row['handle'];
        $firstName = $row['firstname'];
        $lastName = $row['lastname'];
        $adminCode = $row['isAdmin'];
        if ($adminCode == 1) {
            $userType = "Administrator";
        } else {
            $userType = 'Author';
        }
        ?>
        <table width=100%, height="100px">
            <tr>
                <td>Username</td>
                <td> <?php echo "$userName"; ?></td>

            </tr>
            <tr>
                <td>First Name</td>
                <td><?php echo "$firstName"; ?></td>
            </tr>

            <tr>
                <td>Last Name</td>
                <td><?php echo "$lastName"; ?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>******</td>
            </tr>
            <tr>
                <td>Usertype</td>
                <td><?php echo "$userType"; ?></td>
            </tr>
        </table>
        <?php
        if ($adminCode == 1) {
            echo
            <<<EOF
                <a href="" class="font-weight-bold text-decoration-none text-center">
            Edit profile
        </a>
EOF;
        }
        ?>

        <form class="form-horizontal py-2" action="Edit_Profile.php" method="post">

            <div class="form-row py-2">
                <div class="form-group">
                    <label for="password" class="form-label">Reset Password</label>
                    <input id="password" name="password" type="password" class="form-control"
                           placeholder="Enter password..">
                </div>
                <!-- Bootstrap Form Check
                Link:  https://mdbootstrap.com/docs/standard/forms/checkbox/
                Accessed: March 27 2021
                Author: The Bootstrap Team-->
                <br>
                <div class="btn-group d-flex justify-content-right w-25">
                    <button name="send" type="submit" class="btn btn-dark">Reset Password</button>
                </div>
        </form>
        <br>
        <div  class = "text-center">
            <h2 class="fw-light">Your micro-blogs</h2>
        </div>
        <?php
        $blogsQuery = "SELECT * FROM `Tweets` WHERE `author_id` = $uID ";
        $result = $dbconnection->query($blogsQuery);
        if (mysqli_num_rows($result) == 0) {
            echo "<h2> Your have not posted any mirco-blogs yet </h2>";
        } else {
            while ($row = $result->fetch_assoc()) {
                $date = $row['dateCreated'];
                $content = $row['text'];
                echo"<br> $date";
                $heredoc = <<<END
							<hr>
							<div class = "tweepText" style = "height:3em; overflow: hidden">
							<p class="text-muted">
									{$content}
							</p>					
							</div>
							<hr>
END;
                echo "$heredoc";
            }
        }
        ?>
    </div>



</main>
<?php require_once "footer.php";