<?php
$theme_url = $path_to_root . "/themes/".user_theme();
include_once($theme_url.'/mobile_helper.php');
?>
<?php echo mobile_header() ?>
<form action="" method='post' name='loginform'>
    <input type='hidden' id=ui_mode name='ui_mode' value='0' />
    <input type="hidden" name="_focus" value="user_name_entry_field">

    <p>
        <label>User name</label>
        <input  type="text" name="user_name_entry_field" size="20" maxlength="30" value="" />
    </p>
    <p>
        <label>Password</label>
        <input type='password' name='password' size=20 maxlength=20 value='' />
    </p>
    <p>
        <label>Company</label>
        <select name='company_login_name'>
            <option value=0 selected>Xinix Technology</option>
        </select>
    </p>

    <div>Please login here</div>

    <input type='submit' value='Login' name='SubmitUser' />
</form>
<?php echo mobile_footer() ?>