<style type="text/css">@import url("../themes/xinix/mobile_style.php");</style>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="80%" colspan="2"><h2>Profit and Loss Statement</h2></td>
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
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td class="head" width="10%">Account</td>
                    <td class="head" width="50%">Account Name</td>
                    <td class="head" width="10%">Period</td>
                    <td class="head" width="10%"><?php echo $arg->compare_to['header']; ?></td>
                    <td class="head" width="10%">Achieved %</td>
                </tr>
                <?php foreach ($arg->classes as $class): ?>
                    <tr>
                        <td class="header" colspan="5"><strong><?php echo $class['class_name'] ?></strong></td>
                    </tr>

                    <?php foreach ($class['subclasses'] as $subclass): ?>
                        <?php $convert = get_class_type_convert($class['ctype']) ?>
                        <?php if($subclass['total_period'] != 0): ?>
                        <tr>
                            <td class="acc_header" colspan="5"><?php echo $subclass['name'] ?></td>
                        </tr>

                        <?php foreach ($subclass['accounts'] as $accounts): ?>
                            <?php if($accounts['period'] != 0): ?>
                            <tr>
                                <td width="10%"><?php echo $accounts['account_code'] ?></td>
                                <td width="50%"><?php echo $accounts['account_name'] ?></td>
                                <td class="balance" width="10%"><?php echo number_format($accounts['period']) ?></td>
                                <td class="balance" width="10%"><?php echo number_format($accounts['acc']) ?></td>
                                <td class="balance" width="10%"><?php echo $accounts['achieved'] ?></td>
                            </tr>
                            <?php endif ?>
                        <?php endforeach ?>

                        <tr>
                            <td class="acc_footer" colspan="2">Total <?php echo $subclass['name'] ?></td>
                            <td class="acc_footer balance" width="10%"><?php echo number_format($subclass['total_period']) ?></td>
                            <td class="acc_footer balance" width="10%"><?php echo number_format($subclass['total_acc']) ?></td>
                            <td class="acc_footer balance" width="10%"><?php echo $subclass['total_achieved'] ?></td>
                        </tr>
                        <?php endif ?>
                    <?php endforeach ?>

                    <tr>
                        <td class="acc_footer" colspan="2"><strong>Total <?php echo $class['class_name']; ?></strong></td>
                        <td class="acc_footer balance" width="10%"><strong><?php echo number_format($class['total_period'] * $convert) ?></strong></td>
                        <td class="acc_footer balance" width="10%"><strong><?php echo number_format($class['total_acc'] * $convert) ?></strong></td>
                        <td class="acc_footer balance" width="10%"><strong><?php echo $class['total_achieved'] ?></strong></td>
                    </tr>

                <?php endforeach ?>

                    <tr>
                        <td colspan="2">Calculated Return</td>
                        <td class="balance"><?php echo number_format($arg->calculated_period * -1) ?></td>
                        <td class="balance"><?php echo number_format($arg->calculated_acc * -1) ?></td>
                        <td class="balance"><?php echo $arg->calculated_achieved ?></td>
                    </tr>
                    
            </table>
        </td>
    </tr>
</table>