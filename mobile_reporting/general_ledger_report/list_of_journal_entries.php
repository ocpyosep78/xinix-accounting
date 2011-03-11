<form method="POST" action="<?php $arg->view; ?>">
    <button type="submit" name="repJournal" id="repJournal" value="Display: List of Journal Entries">
        <img src="<?php echo theme_url('images/ok.gif') ?>" height="12" />
        <span>Display: List of Journal Entries</span>
    </button>
    <br/><br/>
    Start Date:
    <br/>
   <select name="stgl">
        <?php
            for($tgl=1;$tgl<=31;$tgl++) {
        ?>
                <option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option>
        <?php
            }
        ?>
    </select>
    <select name="sbln">
        <?php
            for($bln=1;$bln<=12;$bln++) {
        ?>
                <option value="<?php echo $bln; ?>"><?php echo $bln; ?></option>
        <?php
            }
        ?>
    </select>
    <select name="sthn">
        <?php
            $now = date("Y");
            for($thn=2000;$now>=$thn;$now--) {
        ?>
                <option value="<?php echo $now; ?>"><?php echo $now; ?></option>
        <?php
            }
        ?>
    </select>
    <br/><br/>
    End Date:
    <br/>
    <select name="etgl">
        <?php
            for($tgl=1;$tgl<=31;$tgl++) {
        ?>
                <option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option>
        <?php
            }
        ?>
    </select>
    <select name="ebln">
        <?php
            for($bln=1;$bln<=12;$bln++) {
        ?>
                <option value="<?php echo $bln; ?>"><?php echo $bln; ?></option>
        <?php
            }
        ?>
    </select>
    <select name="ethn">
        <?php
            $now = date("Y");
            for($thn=2000;$now>=$thn;$now--) {
        ?>
                <option value="<?php echo $now; ?>"><?php echo $now; ?></option>
        <?php
            }
        ?>
    </select>
    <br/><br/>
    Type:
    <br/>
    <span id="type_sel">
        <select name="type">
            <option value="-1">No Type Filter</option>
        <?php foreach($arg->types as $key=>$value): ?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
        <?php endforeach ?>
        </select>
    </span>
    <br/><br/>
    Comments:
    <br/>
    <textarea name="comment" rows="4" cols="30"></textarea>
</form>