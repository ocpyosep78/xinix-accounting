<?php $last_typeno = 0 ?>
<style type="text/css">@import url("../themes/xinix/mobile_style.php");</style>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="80%" colspan="2"><h2>List of Journal Entries</h2></td>
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
                    <td width="20%">Type :</td><td><?php echo $arg->types; ?></td>
                    <td width="20%">&nbsp</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td class="head" width="10%">Type/Account</td>
                    <td class="head" width="50%">Reference/Account Name</td>
                    <td class="head" width="10%">Date/Dim</td>
                    <td class="head" width="10%">Person/Item/Memo</td>
                    <td class="head" width="10%">Debit</td>
                    <td class="head" width="10%">Credit</td>
                </tr>

                <?php foreach ($arg->journal as $journal): ?>

                <?php if ($last_typeno != $journal['typeno']): ?>
                <?php $last_typeno = $journal['typeno'] ?>
                        <tr>
                            <td width="15%"><?php echo $journal['trans_name'] . " # " . $journal['typeno'] ?></td>
                            <td width="45%"><?php echo $journal['reference'] ?></td>
                            <td width="10%"><?php echo $journal['tran_date'] ?></td>
                            <td width="10%"><?php echo $journal['coms'] ?></td>
                            <td width="10%"><?php echo "" ?></td>
                            <td width="10%"><?php echo "" ?></td>
                        </tr>
                <?php endif ?>

                        <tr>
                            <td width="15%"><?php echo $journal['account'] ?></td>
                            <td width="45%"><?php echo $journal['account_name'] ?></td>
                            <td width="10%"><?php echo "" ?></td>
                            <td width="10%"><?php echo $journal['memo'] ?></td>
                            <td width="10%" class="balance"><?php echo $journal['debit'] ?></td>
                            <td width="10%" class="balance"><?php echo $journal['credit'] ?></td>
                        </tr>

                <?php endforeach ?>

            </table>
        </td>
    </tr>
</table>