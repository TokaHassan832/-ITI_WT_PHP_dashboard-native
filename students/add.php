<?php
require_once '../connection.php';
include_once '../functions.php';
include_once '../aside.php';
$dept_result=$connection->query("select * from departments");
$dept_data=$dept_result->fetchAll(PDO::FETCH_ASSOC);
$errors = [];


if (isset($_POST['submit'])) {
    $fname = validate($_POST['fname']);
    $lname = validate($_POST['lname']);
    $address = validate($_POST['address']);
    $email = validate($_POST['email']);
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $code = validate($_POST['code']);
    $department = $_POST['dept_num'];
    $image = $_FILES['image']['name'];

    $tmp_name = $_FILES['image']['tmp_name'];
    $path = "../uploads/images/$code.$image";

    $allowed_ext = ['png', 'jpg', 'jpeg'];
    $str_arr = explode('.', $image);
    $ext = end($str_arr);
    if (in_array($ext, $allowed_ext)) {
        move_uploaded_file($tmp_name, $path);
    }else{
        $errors['image']="not allowed ext...";
    }

    check_int($code, 'code_int', 'the code must be only numbers...');
    check_int($department, 'dept_int', 'the department must be only numbers...');

    check_unique('students', 'code', $code, 'code_unique', 'this code is exist...');
    check_unique('students', 'email', $email, 'email_unique', 'this email is exist...');

    if_empty($fname, 'fname_required', 'please enter your first name...');
    if_empty($lname, 'lname_required', 'please enter your last name...');
    if_empty($code, 'code_required', 'please enter your code...');
    if_empty($email, 'email_required', 'please enter your email...');
    if_empty($password, 'password_required', 'please enter your password...');
    if_empty($department, 'dept_required', 'please enter department...');

    if (!strlen($password)>8){
        $errors['password_len']="password must be more than 8 characters...";
    }

    if (!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname)) {
        $errors['letters'] = "only letters...";
    }

    $fname = strtolower($fname);
    $fname = ucwords($fname);

    $lname = strtolower($lname);
    $lname = ucwords($lname);

    $password = sha1($password);

    if (empty($errors)) {
        $result = $connection->query("insert into students values ('$fname','$lname','$address','$gender','$email','$password',$code,$department,'$image')");
    }
}
?>

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Add Student</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="index.php">Students</a></li>
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
                            <strong>Add Student</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="fname" class=" form-control-label">First Name</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="fname" name="fname" placeholder="first name" class="form-control">
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
                                        <input type="text" id="lname" name="lname" placeholder="last name" class="form-control">
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
                                        <input type="number" id="code" name="code" placeholder="Enter Code" class="form-control" min="0" step="1">
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
                                    <div class="col-12 col-md-9"><textarea name="address" id="address" rows="9" placeholder="Your Address" class="form-control"></textarea></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="email" class=" form-control-label">Email</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control">
                                        <?php if (isset($errors['email_required'])) { ?>
                                        <small class="help-block form-text" style="color: red !important;"><?php echo $errors['email_required']?></small>
                                    <?php }?>
                                    <?php if (isset($errors['email_unigue'])) { ?>
                                    <small class="help-block form-text" style="color: red !important;"><?php echo $errors['email_unigue']?> </small>
                                <?php }?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="password" class=" form-control-label">Password</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                                        <?php if (isset($errors['password_required'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['password_required']?></small>
                                        <?php }?>
                                        <?php if (isset($errors['password_len'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['password_len']?></small>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="image" class=" form-control-label">Image</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" id="image" name="image" class="form-control">
                                        <?php if (isset($errors['image'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['image']?></small>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Gender</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check">
                                            <div class="radio">
                                                <label for="male" class="form-check-label ">
                                                    <input type="radio" id="male" name="gender" value="m" class="form-check-input">m
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="female" class="form-check-label ">
                                                    <input type="radio" id="female" name="gender" value="f" class="form-check-input">f
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
                                            <option value="<?= $dept['number']?>"><?= $dept['name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php if (isset($errors['dept_required'])) { ?>
                                            <small class="help-block form-text" style="color: red !important;"><?php echo $errors['dept_required']?></small>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> Submit
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
        <?php include_once '../footer.php'?>


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
