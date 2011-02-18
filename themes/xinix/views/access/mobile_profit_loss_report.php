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
                    <form method="POST" action="mobile_show_profit_loss.php">
                        <button type="submit" name="repGL" id="repJournal" value="Display: GL Account Transactions">
                            <img src="<?php echo $theme_url; ?>default/images/ok.gif" height="12" />
                            <span>Display: GL Account Transactions</span>
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
                        Compare to:
                        <br/>
                        <span id="type_com">
                            <select name="compare">
                                <option value="">Accumulated</option>
                            </select>
                        </span>
                        <br/><br/>
                        Dimension:
                        <br/>
                        <span id="type_dim">
                            <select name="dimension">
                                <option value="">No Dimension Filter</option>
                            </select>
                        </span>
                        <br/><br/>
                        Decimal values:
                        <br/>
                        <span id="type_dec">
                            <select name="decimal">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </span>
                        <br/><br/>
                        Graphics:
                        <br/>
                        <span id="type_graph">
                            <select name="graphic">
                                <option value="">No Graphics</option>
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