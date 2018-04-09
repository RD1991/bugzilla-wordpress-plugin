<?php

if(isset($_POST['create'])){
    // if 'create' button is pressed then show HTML page
    require_once(ABSPATH.'wp-content/plugins/wp-bugzilla/bugzilla-create-bug.php');
    createABug();
} else if(isset($_POST['createbug'])){
    // if 'create' button is pressed (of HTML page) then make a call to rest API
    // get the result, unset the earlier _POST params and land to the base page
    require_once(ABSPATH.'wp-content/plugins/wp-bugzilla/endpoints/bugzilla-create-bug-endpoint.php');
    $response= createBugEndpoint();
    if ($response[0] == 'Success') {
        if(isset($_POST['createbug'])) {
            unset($_POST['createbug']);
        }
        if(isset($_POST['create'])) {
            unset($_POST['create']);
        }
        ?>
        <script type="text/javascript">
            window.location.href = "?page_id=120";
        </script>
        <script src="<?php echo WPDM_BASE_URL.'assets/js/jquery.min.js' ?>"></script>
        <?
    }
} else {
/*
 * function description - call rest API to fetch list of all bugs
 *
 * */
function listAllBug() {
require_once(ABSPATH.'wp-content/plugins/wp-bugzilla/endpoints/bugzilla-list-bugs-endpoint.php');
$response = getAllBugs();
$result = $response[0];
$message = $response[1];

if ($result == 'Success') {
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

    <style>
    #example_length{
        display: none;
    }
    </style>
<div class="container">
    <h1 style="text-align: center">Bug List</h1>
       <form method="post">
           </br><input type="submit" name="create" value="Create Bug" style="background:#38c2a7;float: right;margin-top: 1.1%;color:#fff;"></br>
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                      <tr>
                          <th>Id</th>
                          <th>Product</th>
                          <th>Component</th>
                          <th>Version</th>
                          <th>Summary</th>
                          <th>Assigned To</th>
                          <th>Created By</th>
                          <th>Status</th>
                      </tr>
                    </thead>

                    <tbody>
                    <?php
                    $response = json_decode($message, true);
                    foreach ($response['bugs'] as $row) { ?>
                        <tr>
                            <td align="center">
                                <?php echo $row['id'] ?>
                            </td>
                            <td align="center">
                                <?php echo $row['product'] ?>
                            </td>
                            <td align="center">
                                <?php echo $row['component'] ?>
                            </td>
                            <td align="center">
                                <?php echo $row['version'] ?>
                            </td>
                            <td align="center">
                                <?php echo $row['summary'] ?>
                            </td>
                            <td align="center">
                                <?php echo $row['assigned_to_detail']['real_name'] ?>
                            </td>
                            <td align="center">
                                <?php echo $row['creator_detail']['real_name'] ?>
                            </td>
                            <td align="center">
                                <?php echo $row['status'] ?>
                            </td>
                        </tr>
                        <?
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?>
                    </tbody>
                </table>
           <input type="submit" name="create" value="Create Bug" style="background:#38c2a7;float: right;color:#fff;">
       </form>
</div>
<?} else {
    if ($result == 'Error') {
        echo $message;
    }
}
}
}
?>
<script src="<?php echo WPDM_BASE_URL.'assets/bootstrap/bootstrap.min.js'?>"></script>
<script src="<?php echo WPDM_BASE_URL.'assets/js/js/jquery.dataTables.min.js' ?>"></script>
<script src="<?php echo WPDM_BASE_URL.'assets/js/dataTables.bootstrap.min.js' ?>"></script>
<script>
    jQuery(document).ready(function(){
    jQuery('#example').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );
</script>

