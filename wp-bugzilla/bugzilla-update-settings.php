<?php
/*
    This file ask admin to enter base url in the admin panel
    i.e settings of `Bugzilla Integrator` plugin
*/

    // once the settings are updated then we will update admin with the message
    // `Settings updated` and the updated value can be seen in UI / textbox
    if($_POST['bugzilla_import_admin_hidden'] == 'Y') {
        $bugzilla_base_url = $_POST['bugzilla_base_url'];
        update_option('bugzilla_base_url', $bugzilla_base_url);
        ?>
        <div class="updated"><p><strong><?php _e('Settings updated.' ); ?></strong></p></div>
        <?php
    } else {
        $bugzilla_base_url = get_option('bugzilla_base_url');
    }
?>

<div class="container">
    <?php    echo "<h2>" . __( 'Bugzilla Integrator', 'bugzilla_import_admin_trdom' ) . "</h2>"; ?>
    <form name="bugzilla_import_admin_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="bugzilla_import_admin_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Bugzilla Database Settings', 'bugzilla_import_admin_trdom' ) . "</h4>"; ?>
        <p><?php _e("Bugzilla base URL: " ); ?><input type="text" name="bugzilla_base_url" value="<?php echo $bugzilla_base_url; ?>" size="50"><?php _e(" ex: http://localhost/bugzilla" ); ?></p>
        <hr />

        <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Update Settings', 'bugzilla_import_admin_trdom' ) ?>" />
        </p>
    </form>
</div>