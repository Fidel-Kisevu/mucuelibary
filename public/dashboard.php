<?php
include('../includes/db_connection.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <style>
/*dashboard-header*/

.dashboard-header .left p span{
    text-transform: capitalize;
    margin-right: 10px;
    font-weight: bold;

}
.dashboard-header .right{
    margin-right: 20px;
}
.dashboard-header .right a{
    text-transform: capitalize;
    text-decoration: none;
    color: #222;
    margin-right: 15px;
    font-weight: bold;

}
.dashboard-header .right a i{
    margin-right: 5px;
}
.dashboard-header .right span{
    text-transform: capitalize;
}
.counterup .box{
    width: 100%;
    height: 100px;
    background: #00C0EF;
    padding: 10px 10px;
    margin-bottom: 30px;
    color: #fff;
    border-radius: 10px;

}
.counterup .box2{
    background: #00A65A;
}
.counterup .box3{
    background: #DD4B39;
}
.counterup .box4{
    background: #F39C12;
}
.counterup .box:hover{
    transform: scale(1.1);
     -webkit-transition: ease .5s all;
    -moz-transition: ease .5s all;
    -ms-transition: ease .5s all;
    -o-transition: ease .5s all;
    transition: ease .5s all;
}
.counterup .box .icon{
    width: 15%;
    float: right;
}
.counterup .box .text{
    width: 85%;
    float: left;
}
.counterup .box i{
    font-size: 30px;
    color: #ddd;
    margin-top: 20px;
}
.counterup .box span{
    margin-right: 5px;
}
.counterup .box h2{
    font-weight: bold;
    margin-top: 10px;
    color: #fff;
}
.counterup .box h4 a{
    text-decoration: none;
    text-transform: capitalize;
    
    margin-top: 0;
    color: #fff;
}


    </style>
</head>
<body>
    <!-- dashboard area -->
    <div class="dashboard-content">
        <div class="dashboard-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="left">
                            <h2><span>Library System</span> Control Panel</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="right text-right">
                            <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
                            <span class="disabled"> Dashboard</span>
                        </div>
                    </div>
                </div>
                <div class="row counterup">
                    <div class="col-md-3 col-sm-6 col-xs-12 control">
                        <div class="box">
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="text">
                                <h3><span class="counter">
                                    <?php
                                        $res = mysqli_query($conn, "SELECT * FROM students");
                                        $res2 = mysqli_query($conn, "SELECT * FROM students");
                                        $count2 = mysqli_num_rows($res2);
                                        $count = mysqli_num_rows($res);
                                        $result = $count + $count2;
                                        echo $result;
                                    ?>
                                </span></h3>
                                <h4><a href="view-users.php">Members</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 control">
                        <div class="box box2">
                            <div class="icon">
                                <i class="fa fa-rocket"></i>
                            </div>
                            <div class="text">
                                <h3><span class="counter">
                                    <?php
                                        $res = mysqli_query($conn, "SELECT * FROM issue_book");
                                        $res2 = mysqli_query($conn, "SELECT * FROM issue_book");
                                        $count2 = mysqli_num_rows($res2);
                                        $count = mysqli_num_rows($res);
                                        $result = $count + $count2;
                                        echo $result;
                                    ?>
                                </span></h3>
                                <h4><a href="issued-books.php">Issued Books</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 control">
                        <div class="box box3">
                            <div class="icon">
                                <i class="fa fa-book"></i>
                            </div>
                            <div class="text">
                                <h3><span class="counter">
                                    <?php
                                        $res = mysqli_query($conn, "SELECT * FROM add_book");
                                        $count = mysqli_num_rows($res);
                                        echo $count;
                                    ?>
                                </span></h3>
                                <h4><a href="display-books.php">Books</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 control">
                        <div class="box box3">
                            <div class="icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="text">
                                <h4 class="mt-20"><a href="display-books.php">Manage Books</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 control">
                        <div class="box box4">
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="text">
                                <h4 class="mt-20"><a href="manage-users.php">Manage Users</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 control">
                        <div class="box">
                            <div class="icon">
                                <i class="fab fa-staylinked"></i>
                            </div>
                            <div class="text">
                                <h4 class="mt-20"><a href="status.php">Book Request Approvals</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 control">
                        <div class="box box2">
                            <div class="icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="text">
                                <h4 class="mt-10"><a href="requested-books.php">Requested Books</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>					
        </div>
    </div>
</body>
</html>
