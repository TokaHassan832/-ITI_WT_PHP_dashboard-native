
<?php
require_once '../connection.php';
include_once '../aside.php';

if (isset($_GET['code'])){
    $code=$_GET['code'];
}else{
    echo "<h1 align='center'>Wrong Page!!!!</h1>";
    exit();
}
$result= $connection->query("select code,fname,lname,address,gender,email,password,name from students left join departments on students.dept_num=departments.number where code=$code");
$student=$result->fetch(PDO::FETCH_ASSOC);

?>


    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Selected Student</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="show.php">Student</a></li>
                                <li><a href="add.php">Add Student</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Students</strong>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">code</th>
                                    <th scope="col">fname</th>
                                    <th scope="col">lname</th>
                                    <th scope="col">address</th>
                                    <th scope="col">gender</th>
                                    <th scope="col">email</th>
                                    <th scope="col">password</th>
                                    <th scope="col">department</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $student['code'] ?></td>
                                    <td><?= $student['fname'] ?></td>
                                    <td><?= $student['lname'] ?></td>
                                    <td><?= $student['address'] ?></td>
                                    <td><?= $student['gender'] ?></td>
                                    <td><?= $student['email'] ?></td>
                                    <td><?= $student['password'] ?></td>
                                    <td><?= $student['name'] ?></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

   <?php include_once '../footer.php'?>

</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>


</html>

