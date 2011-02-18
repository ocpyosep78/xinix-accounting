<?php
$theme_url = "$path_to_root/themes/$def_theme";
include_once($theme_url.'/mobile_helper.php');
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="<?php echo $rtl ?>">
    <head>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <meta http-equiv="cache-control" content="max-age=200" />
        <link href="<?php echo $theme_url ?>/mobile_style.css" media="handheld, screen" rel="stylesheet" type="text/css" />
        <title>High technologies</title>
    </head>
    <body>
        <div class="mainwrapper">
            <?php echo mobile_header() ?>
            <div id="content">
                <div class="min-width">
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
                </div>
            </div>
            <?php echo mobile_footer() ?>
        </div>
    </body>
</html>