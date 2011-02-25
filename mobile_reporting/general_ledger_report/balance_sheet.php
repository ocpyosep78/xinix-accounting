<form method="POST" action="<?php $arg->view; ?>">
    <button type="submit" name="repGL" id="repJournal" value="Display: Balance Sheet">
        <img src="<?php echo theme_url('/images/ok.gif') ?>" height="12" />
        <span>Display: Balance Sheet</span>
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
    <!--Dimension:
    <br/>
    <span id="type_dim">
        <select name="dimension">
            <option value="">No Dimension Filter</option>
            <?php
            //foreach($arg->data['dimensions']['id'] as $id) {
            ?>
            <option value="<?php echo $id; ?>"><?php echo $arg->data['dimensions']['name']; ?></option>
            <?php
            //}
            ?>
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
            <option value="no" selected="selected">No Graphics</option>
            <option value="vertical">Vertical Bars</option>
            <option value="horizontal">Horizontal Bars</option>
            <option value="dot">Dots</option>
            <option value="line">Lines</option>
            <option value="pie">Pie</option>
            <option value="donut">Donut</option>
        </select>
    </span>
    <br/><br/>-->
    Comments:
    <br/>
    <textarea name="comment" rows="4" cols="30"></textarea>
</form>