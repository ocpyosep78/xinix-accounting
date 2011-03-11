<?php $last_typeno = 0 ?>
<style type="text/css">@import url("../themes/xinix/mobile_style.php");</style>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="80%" colspan="2"><h2>GL Account Transactions</h2></td>
                    <td width="20%"><?php echo $_SESSION["wa_current_user"]->company; ?></td>
                </tr>
                <tr>
                    <td width="20%">Print Out Date :</td><td><?php echo date("d/m/Y h:i"); ?></td>
                    <td width="20%"><?php echo $_SERVER['SERVER_ADDR']; ?></td>
                </tr>
                <tr>
                    <td width="20%">Fiscal Year :</td><td><?php echo $arg->fiscal; ?></td>
                    <td width="20%"><?php echo $_SESSION["wa_current_user"]->loginname; ?></td>
                </tr>
                <tr>
                    <td width="20%">Period :</td><td><?php echo $arg->from . " - " . $arg->to; ?></td>
                    <td width="20%">&nbsp</td>
                </tr>
                <tr>
                    <td width="20%">Account :</td><td><?php echo $arg->account; ?></td>
                    <td width="20%">&nbsp</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td class="head">Type</td>
                    <td class="head">Ref</td>
                    <td class="head">#</td>
                    <td class="head">Date</td>
                    <td class="head">Dimension</td>
                    <td class="head">Person/Item</td>
                    <td class="head">Debit</td>
                    <td class="head">Credit</td>
                    <td class="head">Balance</td>
                </tr>

                <?php foreach ($arg->gl as $gl): ?>

                        <tr>
                            <td><?php echo $gl['type'] ?></td>
                            <td><?php echo "" ?></td>
                            <td><?php echo "" ?></td>
                            <td><?php echo "" ?></td>
                            <td><?php echo "Opening Balance" ?></td>
                            <td><?php echo "" ?></td>
                            <td class="balance"><?php echo $gl['debit'] ?></td>
                            <td class="balance"><?php echo $gl['credit'] ?></td>
                            <td class="balance"><?php echo "" ?></td>
                        </tr>

                        <tr>
                            <td class="acc_header"><?php echo "" ?></td>
                            <td class="acc_header"><?php echo "" ?></td>
                            <td class="acc_header"><?php echo "" ?></td>
                            <td class="acc_header"><?php echo "" ?></td>
                            <td class="acc_header"><?php echo "Ending Balance" ?></td>
                            <td class="acc_header"><?php echo "" ?></td>
                            <td class="balance acc_header"><?php echo $gl['debit'] ?></td>
                            <td class="balance acc_header"><?php echo $gl['credit'] ?></td>
                            <td class="balance acc_header"><?php echo "" ?></td>
                        </tr>

                <?php endforeach ?>

            </table>
        </td>
    </tr>
</table>