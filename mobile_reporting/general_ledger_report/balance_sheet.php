<form method="POST" action="mobile_show_balance_sheet.php">
    <button type="submit" name="repGL" id="repJournal" value="Display: Balance Sheet">
        <img src="<?php echo theme_url('/images/ok.gif') ?>" height="12" />
        <span>Display: Balance Sheet</span>
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