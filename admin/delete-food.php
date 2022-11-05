<?php 
    //Include COnstants Page
    include('../config/constants.php');

    //echo "Delete Food Page";

    if(isset($_GET['id']) && isset($_GET['image_name'])) //Either use '&&' or 'AND'
    {
        //Process to Delete
        //echo "Process to Delete";

        //1.  Get ID and Image NAme
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove the Image if Available
        //CHeck whether the image is available or not and Delete only if available
        if($image_name != "")
        {
            // IT has image and need to remove from folder
            //Get the Image Path
            $path = "../images/items/".$image_name;

            //REmove Image File from Folder
            $remove = unlink($path);

            //Check whether the image is removed or not
            if($remove==false)
            {
                //Failed to Remove image
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
                //REdirect to Manage Food
                header('location:'.SITEURL.'admin/manage-food.php');
                //Stop the Process of Deleting Food
                die();
            }

        }

        //3. Delete Food from Database
        $sql = "DELETE FROM tbl_sales WHERE id=$id";
        $sql2 = "DELETE FROM tbl_items WHERE id=$id";
        //Execute the Query
        $res1 = mysqli_query($conn, $sql);
        $res2 = mysqli_query($conn, $sql2);



        //CHeck whether the query executed or not and set the session message respectively
        //4. Redirect to Manage Food with Session Message
        if($res1 && $res2==true)
        {
            //Food Deleted
            $_SESSION['delete'] = "<div class='success'>Item Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Failed to Delete Food
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Item.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        

    }
    else
    {
        //Redirect to Manage Food Page
        //echo "REdirect";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>