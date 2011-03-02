<form method="POST" action="<?php $arg->view; ?>">
    <button type="submit" name="repProfit" id="repJournal" value="Display: Profit and Loss Statement">
        <img src="<?php echo theme_url('/images/ok.gif') ?>" height="12" />
        <span>Display: Profit and Loss Statement</span>
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
    Compare to:
    <br/>
    <span id="type_com">
        <select name="compare">
            <option value="0">Accumulated</option>
            <option value="1">Period Y-1</option>
            <option value="2">Budget</option>
        </select>
    </span>
    <br/><br/>
    Comments:
    <br/>
    <textarea name="comment" rows="4" cols="30"></textarea>
</form>