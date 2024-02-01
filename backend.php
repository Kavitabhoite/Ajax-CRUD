<?php
    $conn = mysqli_connect('localhost', 'root', 'root', 'ajaxcurd', 3308);

    extract($_POST);

    //Read
    if(isset($_POST['readrecord'])){
        $data = '<table class="table table-bordered table-striped">
                   <tr>
                     <th>No.</th>
                     <th>First Name</th>
                     <th>Last Name</th>
                     <th>Email Address</th>
                     <th>Mobile Number</th>
                     <th>Edit Action</th>
                     <th>Delete Action</th>
                    </tr>';

        $displayquery = 'SELECT * FROM `crudtable`';
        $result = mysqli_query($conn, $displayquery);

        if(mysqli_num_rows($result) > 0){
            $number = 1;
            while($row = mysqli_fetch_array($result)){

                $data .= '<tr>
                        <td>'.$number.'</td>
                        <td>'.$row['firstname'].'</td>
                        <td>'.$row['lastname'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['mobile'].'</td>
                        <td>
                            <button onClick="GetUserDetails('.$row['Id'].')" class="btn sbtn-warning">Edit</button>
                        </td>
                        <td>
                            <button onClick="DeleteUser('.$row['Id'].')" class="btn sbtn-danger">Delete</button>
                        </td>
                    </tr>';
                    $number++;
            }
        }
        $data .= '</table>';
        echo $data;
    }

    //insert or create
    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['mobile'])){
        $query = "INSERT INTO `crudtable`(`firstname`, `lastname`, `email`, `mobile`) 
                    VALUES ('$firstname', '$lastname', '$email', '$mobile')";
        mysqli_query($conn, $query);
    }

    //Delete records
    if(isset($_POST['deleteid'])){
        $userid = $_POST['deleteid'];
        $deletequery = "delete from crudtable where id='$userid'";
        mysqli_query($conn, $deletequery);
    }

    //update
    if(isset($_POST['id']) && isset($_POST['id']) != ""){
        $user_id = $_POST['id'];
        $query = "SELECT * FROM crudtable WHERE id='$user_id'";
        if(!$result = mysqli_query($conn,$query)){
            exit(mysqli_error());
        }

        $response = array();
        
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $response = $row;
            }
        }
        else{
            $response['status'] = 200;
            $response['message'] = "Data not found!";
        }

        echo json_encode($response);
    }
    else{
        $response['status'] = 200;
        $response['message'] = "Invalid Request!";
    }
 
    if(isset($_POST['hidden_user_idupd'])){
        $hidden_user_idupd = $_POST['hidden_user_idupd'];
        $firstnameupd = $_POST['firstnameupd'];
        $lastnameupd = $_POST['lastnameupd'];
        $emailupd = $_POST['emailupd'];
        $mobileupd = $_POST['mobileupd'];

        $query = "UPDATE `crudtable` SET `firstname`='$firstnameupd',`lastname`='$lastnameupd',`email`='$emailupd',`mobile`='$mobileupd' WHERE id='$hidden_user_idupd'";
        mysqli_query($conn,$query);
    }
?>