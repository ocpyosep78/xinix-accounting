<form method="POST" action="mobile_show_list_journal.php">
    <button type="submit" name="repJournal" id="repJournal" value="Display: List of Journal Entries">
        <img src="<?php echo theme_url('images/ok.gif') ?>" height="12" />
        <span>Display: List of Journal Entries</span>
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