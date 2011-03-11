<form method="POST" action="<?php $arg->view ?>">
    <button type="submit" name="repGL" id="repJournal" value="Display: GL Account Transactions">
        <img src="<?php echo theme_url('images/ok.gif') ?>" height="12" />
        <span>Display: GL Account Transactions</span>
    </button>
    <br/><br/>
    Start Date:
    <br/>
    <select name="stgl">
        <?php for($tgl=1;$tgl<=31;$tgl++): ?>
                <option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option>
        <?php endfor ?>
    </select>
    <select name="sbln">
        <?php for($bln=1;$bln<=12;$bln++): ?>
                <option value="<?php echo $bln; ?>"><?php echo $bln; ?></option>
        <?php endfor ?>
    </select>
    <select name="sthn">
        <?php
            $now = date("Y");
            for($thn=2000;$now>=$thn;$now--):
        ?>
                <option value="<?php echo $now; ?>"><?php echo $now; ?></option>
        <?php endfor ?>
    </select>
    <br/><br/>
    End Date:
    <br/>
    <select name="etgl">
        <?php for($tgl=1;$tgl<=31;$tgl++): ?>
                <option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option>
        <?php endfor ?>
    </select>
    <select name="ebln">
        <?php for($bln=1;$bln<=12;$bln++): ?>
                <option value="<?php echo $bln; ?>"><?php echo $bln; ?></option>
        <?php endfor ?>
    </select>
    <select name="ethn">
        <?php
            $now = date("Y");
            for($thn=2000;$now>=$thn;$now--):
        ?>
                <option value="<?php echo $now; ?>"><?php echo $now; ?></option>
        <?php endfor ?>
    </select>
    <br/><br/>
    From Account:
    <br/>
    <span id="type_acc">
        <select name="facc">
            <?php
                $type = "";
                foreach($arg->accounts as $accounts):
                    if($type != $accounts['type']):
                        $type = $accounts['type'];
            ?>
                        <optgroup label="<?php echo $accounts['type'] ?>">
            <?php
                    endif;
            ?>
                            <option value="<?php echo $accounts['code'] ?>"><?php echo $accounts['code']." ".$accounts['name'] ?></option>
            <?php
                    if($type != $accounts['type']):
            ?>
                        </optgroup>
            <?php
                    endif;
                endforeach;
            ?>
        </select>
    </span>
    <br/><br/>
    To Account:
    <br/>
    <span id="type_acc">
        <select name="tacc">
            <?php
                $type = "";
                foreach($arg->accounts as $accounts):
                    if($type != $accounts['type']):
                        $type = $accounts['type'];
            ?>
                        <optgroup label="<?php echo $accounts['type'] ?>">
            <?php
                    endif;
            ?>
                            <option value="<?php echo $accounts['code'] ?>"><?php echo $accounts['code']." ".$accounts['name'] ?></option>
            <?php
                    if($type != $accounts['type']):
            ?>
                        </optgroup>
            <?php
                    endif;
                endforeach;
            ?>
        </select>
    </span>
    <br/><br/>
    Comments:
    <br/>
    <textarea name="comment" rows="4" cols="30"></textarea>
</form>