<?php
    $path_to_root="/xinix-accounting";
    $theme_url = "$path_to_root/themes/$def_theme";
    include_once($theme_url.'/mobile_helper.php');
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="<?php echo $rtl ?>">
    <head>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <meta http-equiv="cache-control" content="max-age=200" />
        <link href="<?php echo $theme_url ?>/mobile_style.css media="handheld, screen" rel="stylesheet" type="text/css" />
        <title>High technologies</title>
    </head>
    <body>
        <div class="mainwrapper">
            <div id="content">
                <div class="min-width">
                    <form method="POST" action="mobile_show_list_journal.php">
                        <button type="submit" name="repJournal" id="repJournal" value="Display: List of Journal Entries">
                            <img src="<?php echo $theme_url; ?>default/images/ok.gif" height="12" />
                            <span>Display: List of Journal Entries</span>
                        </button>
                        <br/><br/>
                        Start Date:
                        <br/>
                        <input type="text" name="start_date" value="<?php echo date("m/d/Y"); ?>"/>
                        <a href="javascript:date_picker(document.forms[0].start_date);">
                            <img src="<?php echo $theme_url; ?>default/images/cal.gif" width="16" height="16" border="0" alt="Click here to pick up the date"/>
                        </a>
                        <br/><br/>
                        End Date:
                        <br/>
                        <input type="text" name="end_date" value="<?php echo date("m/d/Y"); ?>"/>
                        <a href="javascript:date_picker(document.forms[0].end_date);">
                            <img src="<?php echo $theme_url; ?>default/images/cal.gif" width="16" height="16" border="0" alt="Click here to pick up the date"/>
                        </a>
                        <br/><br/>
                        Type:
                        <br/>
                        <span id="type_sel">
                            <select name="type">
                                <option value="">No Type Filter</option>
                            </select>
                        </span>
                        <br/><br/>
                        Comments:
                        <br/>
                        <textarea name="comment" rows="4" cols="30"></textarea>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>