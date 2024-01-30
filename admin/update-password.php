<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

    </div>
</div>

<?php 

    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //get all the data from form
        $id = $_POST['id'];
        $current_password = $_POST['current_password']; // No need for md5 here
        $new_password = $_POST['new_password']; // No need for md5 here
        $confirm_password = $_POST['confirm_password']; // No need for md5 here

        //check whether the user with current ID and password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            //check whether data is available or not
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //user exists
                $row = mysqli_fetch_assoc($res);
                
                //verify the current password
                if ($row && md5($current_password) == $row['password'])
                {
                    //check whether the new password matches with the confirm password
                    if($new_password == $confirm_password)
                    {
                        //update the password
                        $sql2 = "UPDATE tbl_admin SET
                        password = '".md5($new_password)."'
                        WHERE id='$id'";

                        //execute the query
                        $res2 = mysqli_query($conn, $sql2);

                        //check whether query executed or not
                        if($res2==true)
                        {
                            //display success message
                            $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                            //redirect the user
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                        else
                        {
                            //display error message
                            $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                            //redirect the user
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        //redirect to manage admin page with error message
                        $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match.</div>";
                        //redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //redirect to manage admin page with error message
                    $_SESSION['user-not-found'] = "<div class='error'>Invalid Current Password.</div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //user does not exist, set message and redirect
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
                //redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

        //check whether the current or new password and confirm password match or not

        //change password if all above is true
    }

?>

<?php include('partials/footer.php'); ?>
