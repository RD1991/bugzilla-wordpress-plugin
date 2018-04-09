<?php
/*
 * function description - show user a HTML page with mandatory fields to the API
 * */
function createABug()
{
    ?>
    <h1 style="text-align: center">Create Bug</h1>
    <form method="POST">
        <div class="form-group">
            <style>
                <?php require_once(ABSPATH.'wp-content/plugins/wp-bugzilla/assets/css/third-party-group-form.css'); ?>
            </style>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="product" placeholder="Product *" name="product" required value="TestProduct" readonly>
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="component" placeholder="Component *" name="component" required>
                </div>
            </div>

            <div class="form-group col-md-12">
                <textarea class="form-control" rows="2" id="summary" placeholder="Summary *" name="summary" required></textarea>
            </div>

            <div class="form-group col-md-12">
                <textarea class="form-control" rows="4" id="desc" placeholder="Description *" name="desc" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="version" value="unspecified" placeholder="Version *" name="version" required readonly>
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="alias" placeholder="Alias *(Must be Unique)" name="alias" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="priority" placeholder="Priority *" name="priority" required>
                </div>

                <div class="form-group col-md-6">
                    <select class="form-control" id="op_sys" placeholder="Operation System" name="op_sys" required>
                        <option> Operating System *</option>
                        <option>Windows</option>
                        <option>Linux</option>
                        <option>MacOS</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="platform" placeholder="Platform *" value="All" name="platform" required readonly>
                </div>


                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="rep_platform" placeholder="Rep platform *" value="All" name="rep_platform"required readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <select class="form-control" id="assign_to" placeholder="AssignTo" name="assign_to" required>
                        <option> Assign To *</option>
                        <?php
                        $users = get_users(array(
                            'fields' => 'all',
                        ));
                        foreach ($users as $user) {
                            // if the current user role is administrator
                            // don't show that in AssignTo drop down
                            if ($user->roles[0] == "administrator") {
                                continue;
                            }
                            ?>
                            <option> <?php echo $user->get('user_login') ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row" style="float: right">
                <div class="form-group col-md-6">
                    <input type="reset" name="reset" value="Cancel" style="background:#38c2a7;color:#fff;">
                </div>
                <div class="form-group col-md-6">
                    <input type="submit" name="createbug" value="Create" style="background:#38c2a7;color:#fff;">
                </div>

            </div>
        </div>
    </form>
    <?
}
