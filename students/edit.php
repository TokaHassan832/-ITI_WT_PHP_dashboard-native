<?php
ob_start();
require_once '../connection.php';
include_once '../functions.php';
include_once '../aside.php';

if (isset($_GET['code'])){
    $code=$_GET['code'];
}else{
    echo "<h1 align='center'>Wrong Page!!!!</h1>";
    exit();
}

$std_result=$connection->query("select * from students where code=$code");
$std_data=$std_result->fetch(PDO::FETCH_ASSOC);
$dept_result=$connection->query("select * from departments");
$dept_data=$dept_result->fetchAll(PDO::FETCH_ASSOC);
$errors = [];


if (isset($_POST['edit'])) {
    $fname = validate($_POST['fname']);
    $lname = validate($_POST['lname']);
    $address = validate($_POST['address']);
    $email = validate($_POST['email']);
    $gender = $_POST['gender'];
    $code = validate($_POST['code']);
    $department = $_POST['dept_num'];


    check_int($code, 'code_int', 'the code must be only numbers...');
    check_int($department, 'dept_int', 'the department must be only numbers...');

    check_unique('students', 'code', $code, 'code_unique', 'this code is exist...');
    check_unique('students', 'email', $email, 'email_unique', 'this email is exist...');

    if_empty($fname, 'fname_required', 'please enter your first name...');
    if_empty($lname, 'lname_required', 'please enter your last name...');
    if_empty($code, 'code_required', 'please enter your code...');
    if_empty($email, 'email_required', 'please enter your email...');
    if_empty($department, 'dept_required', 'please enter department...');


    if (!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname)) {
        $errors['letters'] = "only letters...";
    }

    $fname = strtolower($fname);
    $fname = ucwords($fname);

    $lname = strtolower($lname);
    $lname = ucwords($lname);

    if (empty($errors)) {
        $result = $connection->query("UPDATE `students` SET `fname`='$fname',`lname`='$lname',`address`='$address',`gender`='$gender',`email`='$email',`code`=$code,`dept_num`=$department WHERE `code`=$code");
        if ($result) {
            header("location: index.php");
        }
    }

}
?>

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Update Student</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="index.php">Students</a></li>
                                <li><a href="edit.php">Update Student</a></li>
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
                            <strong>Update Student</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="fname" class=" form-control-label">First Name</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="fname" name="fname" placeholder="first name" value="<?= $std_data['fname']?>" class="form-control">
                                    <?php if (isset($errors['fname_required'])) { ?>
                                        <small class="help-block form-text" style="color: red !important;"><?php echo $errors['fname_required']?></small>
                                    <?php }?>
                                        <?php if (isset($errors['letters'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['letters']?></small>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="lname" class=" form-control-label">Last Name</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="lname" name="lname" placeholder="last name" value="<?= $std_data['lname']?>" class="form-control">
                                        <?php if (isset($errors['lname_required'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['lname_required']?></small>
                                        <?php }?>
                                        <?php if (isset($errors['letters'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['letters']?></small>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="code" class=" form-control-label">Code</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="code" name="code" placeholder="Enter Code" value="<?= $std_data['code']?>" class="form-control" min="0" step="1">
                                        <?php if (isset($errors['code_required'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['code_required']?></small>
                                        <?php }?>
                                        <?php if (isset($errors['code_unique'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['code_unique']?> </small>
                                        <?php }?>
                                        <?php if (isset($errors['code_int'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['code_int']?></small>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="address" class=" form-control-label">Address</label></div>
                                    <div class="col-12 col-md-9"><textarea name="address" id="address" rows="9" placeholder="Your Address" class="form-control"><?= $std_data['address'] ?></textarea></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="email" class=" form-control-label">Email</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="email" id="email" name="email" placeholder="Enter Email" value="<?= $std_data['email']?>" class="form-control">
                                        <?php if (isset($errors['email_required'])) { ?>
                                        <small class="help-block form-text" style="color: red !important;"><?php echo $errors['email_required']?></small>
                                    <?php }?>
                                    <?php if (isset($errors['email_unigue'])) { ?>
                                    <small class="help-block form-text" style="color: red !important;"><?php echo $errors['email_unigue']?> </small>
                                <?php }?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Gender</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check">
                                            <div class="radio">
                                                <label for="male" class="form-check-label ">
                                                    <input type="radio" id="male" name="gender" value="m" <?php if ($std_data['gender']=='m'){?>checked<?php } ?> class="form-check-input">m
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="female" class="form-check-label ">
                                                    <input type="radio" id="female" name="gender" value="f" <?php if ($std_data['gender']=='f'){?>checked<?php } ?> class="form-check-input">f
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="dept_num" class=" form-control-label">Department</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="dept_num" id="dept_num" class="form-control-sm form-control">
                                            <?php foreach ($dept_data as $dept){?>
                                            <option value="<?= $dept['number']?>" <?php if ($dept['number']==$std_data['dept_num']){?>selected<?php } ?>><?= $dept['name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php if (isset($errors['dept_required'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['dept_required']?></small>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="edit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> Edit
                                    </button>
                                    <button type="reset" name="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Reset
                                    </button>
                                </div>
                        </div>
                            </form>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>
        <?php
        include_once '../footer.php';
        ob_end_flush();
        ?>
</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>


</body>
</html>

