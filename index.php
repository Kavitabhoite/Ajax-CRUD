<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax CRUD Operations</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-primary text-uppercase text-centre">AJAX CRUD OPERATION</h1>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">
                New Record
            </button>
        </div>
            <h2 class="text-danger">All Records</h2>
            <div id="records_contant"></div> 
    </div>

        <!-- The Modal -->
    <div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">AJAX CURD OPERATION</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

        <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="" id="firstname" class="form-control" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="" id="lastname" class="form-control" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label>Email ID:</label>
                    <input type="email" name="" id="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label>Mobile:</label>
                    <input type="text" name="" id="mobile" class="form-control" placeholder="Mobile Number">
                </div>
            </div>

        <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="addRecord()" id="newRecordBtn">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>

    <!--update modal-->
    <!-- The Modal -->
    <div class="modal" id="update_user_modal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">AJAX CURD OPERATION</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

        <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="update_firstname">update_FirstName:</label>
                    <input type="text" name="" id="update_firstname" class="form-control" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label for="update_lastname">update_LastName:</label>
                    <input type="text" name="" id="update_lastname" class="form-control" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label for="update_email">update_EmailID:</label>
                    <input type="email" name="" id="update_email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="update_mobile">update_Mobile:</label>
                    <input type="text" name="" id="update_mobile" class="form-control" placeholder="Mobile Number">
                </div>
            </div>

        <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="updateuserdetail()">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="hidden" name="" id="hidden_user_id">
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function(){
            readRecords();
        });

        //Read
        function readRecords() {
            var readrecord = "readrecord";
            $.ajax({
                url:"backend.php",
                type:"post",
                data: { readrecord: readrecord },
                success: function (data, status){
                    $('#records_contant').html(data);
                }
            });   
        }

        //insert or create
        function addRecord(){
            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val(); 
            var email = $('#email').val();
            var mobile = $('#mobile').val();

            // Perform null validation
            if (!firstname || !lastname || !email || !mobile) {
                alert("All fields must be filled out.");
                // Do not close the modal if validation fails
            }
            else{
                $.ajax({
                    url:"backend.php",
                    type:'post',
                    data: { firstname :firstname, lastname :lastname, email: email, mobile: mobile },
                    success: function(data,status){
                        $('#firstname').val('');
                        $('#lastname').val('');
                        $('#email').val('');
                        $('#mobile').val('');
                        readRecords();
                        $('#myModal').modal('hide');
                    }
                });
            }
        }

        //delete 
        function DeleteUser(deleteid){
            var conf = confirm("Are You Sure!");
            if(conf==true){
                $.ajax({
                    url:"backend.php",
                    type: "post",
                    data: { deleteid: deleteid },
                    success: function(data, status){
                        readRecords();
                    }
                });
            }
        }

        // Set up event listener for modal before close
        $('#myModal').on('hide.bs.modal', function (event) {
            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();

            // Check if any of the fields are not filled
            if (!firstname || !lastname || !email || !mobile) {
                // Prevent the modal from being closed
                event.preventDefault();
            }
        });

        //update
        function GetUserDetails(id) {
            $('#hidden_user_id').val(id);

            $.post("backend.php", {
                id: id
            }, function (data, status) {
                var user = JSON.parse(data);
                $('#update_firstname').val(user.firstname);
                $('#update_lastname').val(user.lastname);
                $('#update_email').val(user.email);
                $('#update_mobile').val(user.mobile);
            });

            $('#update_user_modal').modal("show");
        }

        function updateuserdetail() {
            var hidden_user_idupd = $('#hidden_user_id').val();
            var firstnameupd = $('#update_firstname').val();
            var lastnameupd = $('#update_lastname').val();
            var emailupd = $('#update_email').val();
            var mobileupd = $('#update_mobile').val();

            // Perform null validation
            if (!firstnameupd || !lastnameupd || !emailupd || !mobileupd) {
                alert("All fields must be filled out.");
                // Do not proceed with the update if validation fails
            } else {
                $.post("backend.php", {
                    hidden_user_idupd: hidden_user_idupd,
                    firstnameupd: firstnameupd,
                    lastnameupd: lastnameupd,
                    emailupd: emailupd,
                    mobileupd: mobileupd
                }, function (data, status) {
                    $('#update_user_modal').modal("hide");
                    readRecords();
                });
            }
        }

        // Set up event listener for update modal before close
        $('#update_user_modal').on('hide.bs.modal', function (event) {
            var firstnameupd = $('#update_firstname').val();
            var lastnameupd = $('#update_lastname').val();
            var emailupd = $('#update_email').val();
            var mobileupd = $('#update_mobile').val();

            // Check if any of the fields are not filled
            if (!firstnameupd || !lastnameupd || !emailupd || !mobileupd) {
                // Prevent the update modal from being closed
                event.preventDefault();
            }
        });
        
    </script>

</body>
</html>