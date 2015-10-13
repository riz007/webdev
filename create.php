<?php

require 'database.php';

if ( !empty($_POST)) {
    // keep track validation errors
    $firstError = null;
    $lastError = null;
    $emailError = null;
    $mobileError = null;

    // keep track post values
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    // validate input
    $valid = true;
    if (empty($first)) {
        $firstError = 'Please enter first Name';
        $valid = false;
    }
    if (empty($last)) {
        $lastError = 'Please enter last Name';
        $valid = false;
    }

    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }

    if (empty($mobile)) {
        $mobileError = 'Please enter Mobile Number';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO contact (first,last,email,mobile) values(?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($first,$last,$email,$mobile));
        Database::disconnect();
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">

    <div class="span10 offset1">
        <div class="row">
            <h3>Create a Contact</h3>
        </div>

        <form class="form-horizontal" action="create.php" method="post">
            <div class="control-group <?php echo !empty($firstError)?'error':'';?>">
                <label class="control-label">First Name</label>
                <div class="controls">
                    <input name="first" type="text"  placeholder="First Name" value="<?php echo !empty($first)?$first:'';?>">
                    <?php if (!empty($firstError)): ?>
                        <span class="help-inline"><?php echo $firstError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($lastError)?'error':'';?>">
                <label class="control-label">Last Name</label>
                <div class="controls">
                    <input name="last" type="text"  placeholder="Last Name" value="<?php echo !empty($last)?$last:'';?>">
                    <?php if (!empty($lastError)): ?>
                        <span class="help-inline"><?php echo $lastError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                <label class="control-label">Email Address</label>
                <div class="controls">
                    <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                    <?php if (!empty($emailError)): ?>
                        <span class="help-inline"><?php echo $emailError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                <label class="control-label">Mobile Number</label>
                <div class="controls">
                    <input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
                    <?php if (!empty($mobileError)): ?>
                        <span class="help-inline"><?php echo $mobileError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn" href="index.php">Back</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>
</html>
