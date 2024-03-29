<style type="text/css">@import url("../themes/xinix/mobile_style.php");</style>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="80%" colspan="2"><h2>Balance Sheet</h2></td>
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
                    <td class="head" width="60%">Account Name</td>
                    <td class="head" width="10%">Open Balance</td>
                    <td class="head" width="10%">Period</td>
                    <td class="head" width="10%">Close Balance</td>
                </tr>
                <?php foreach ($arg->classes as $class): ?>
                    <tr>
                        <td class="header" colspan="5"><strong><?php echo $class['class_name'] ?></strong></td>
                    </tr>

                    <?php foreach ($class['subclasses'] as $subclass): ?>
                        <?php $convert = get_class_type_convert($class['ctype']) ?>
                        <?php if($subclass['total_open'] != 0): ?>
                        <tr>
                            <td class="acc_header" colspan="5"><?php echo $subclass['name'] ?></td>
                        </tr>

                        <?php foreach ($subclass['accounts'] as $accounts): ?>
                            <?php if($accounts['open_balance'] != 0): ?>
                            <tr>
                                <td width="10%"><?php echo $accounts['account_code'] ?></td>
                                <td width="60%"><?php echo $accounts['account_name'] ?></td>
                                <td width="10%" class="balance"><?php echo number_format($accounts['open_balance']) ?></td>
                                <td width="10%" class="balance"><?php echo number_format($accounts['period']) ?></td>
                                <td width="10%" class="balance"><?php echo number_format($accounts['close_balance']) ?></td>
                            </tr>
                            <?php endif ?>
                        <?php endforeach ?>

                        <tr>
                            <td class="acc_footer" colspan="2">Total <?php echo $subclass['name'] ?></td>
                            <td width="10%" class="acc_footer balance"><?php echo number_format($subclass['total_open']) ?></td>
                            <td width="10%" class="acc_footer balance"><?php echo number_format($subclass['total_period']) ?></td>
                            <td width="10%" class="acc_footer balance"><?php echo number_format($subclass['total_close']) ?></td>
                        </tr>
                        <?php endif ?>
                    <?php endforeach ?>

                    <tr>
                        <td class="acc_footer" colspan="2"><strong>Total <?php echo $class['class_name'] ?></strong></td>
                        <td width="10%" class="acc_footer balance"><strong><?php echo number_format($class['total_open'] * $convert) ?></strong></td>
                        <td width="10%" class="acc_footer balance"><strong><?php echo number_format($class['total_period'] * $convert) ?></strong></td>
                        <td width="10%" class="acc_footer balance"><strong><?php echo number_format($class['total_close'] * $convert) ?></strong></td>
                    </tr>

                <?php endforeach ?>

                    <tr>
                        <td colspan="2">Calculated Return</td>
                        <td width="10%" class="balance"><?php echo number_format($arg->calculated_open) ?></td>
                        <td width="10%" class="balance"><?php echo number_format($arg->calculated_period) ?></td>
                        <td width="10%" class="balance"><?php echo number_format($arg->calculated_close) ?></td>
                    </tr>

                    <tr>
                        <td colspan="2"><strong>Total Liabilities and Equities</strong></td>
                        <td width="10%" class="balance"><strong><?php echo number_format($arg->topen) ?></strong></td>
                        <td width="10%" class="balance"><strong><?php echo number_format($arg->tperiod) ?></strong></td>
                        <td width="10%" class="balance"><strong><?php echo number_format($arg->tclose) ?></strong></td>
                    </tr>

            </table>
        </td>
    </tr>
</table>