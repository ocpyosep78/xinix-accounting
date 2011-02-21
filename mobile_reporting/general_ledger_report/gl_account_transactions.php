<form method="POST" action="mobile_show_gl_account.php">
    <button type="submit" name="repGL" id="repJournal" value="Display: GL Account Transactions">
        <img src="<?php echo theme_url('images/ok.gif') ?>" height="12" />
        <span>Display: GL Account Transactions</span>
    </button>
    <br/><br/>
    Start Date:
    <br/>
    <input type="text" name="start_date" value="<?php echo date("m/d/Y"); ?>"/>
    <a href="javascript:date_picker(document.forms[0].start_date);">
        <img src="<?php echo theme_url('images/cal.gif') ?>" width="16" height="16" border="0" alt="Click here to pick up the date"/>
    </a>
    <br/><br/>
    End Date:
    <br/>
    <input type="text" name="end_date" value="<?php echo date("m/d/Y"); ?>"/>
    <a href="javascript:date_picker(document.forms[0].end_date);">
        <img src="<?php echo theme_url('images/cal.gif') ?>" width="16" height="16" border="0" alt="Click here to pick up the date"/>
    </a>
    <br/><br/>
    From Account:
    <br/>
    <span id="type_acc">
        <select name="facc">
            <option value="">Chart of Account</option>
        </select>
    </span>
    <br/><br/>
    To Account:
    <br/>
    <span id="type_acc">
        <select name="tacc">
            <option value="">Chart of Account</option>
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
    Comments:
    <br/>
    <textarea name="comment" rows="4" cols="30"></textarea>
</form>