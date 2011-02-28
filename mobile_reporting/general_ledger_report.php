<?php

/**
 * Description of general_ledger_report
 *
 * @author jafar
 */
load('xinix/controller/mobile_report');
include_once('includes/session.inc');
include_once('includes/date_functions.inc');
include_once('includes/data_checks.inc');
include_once('gl/includes/gl_db.inc');
include_once('xinix/helpers.php');

class General_Ledger_Report extends Mobile_Report {

    function list_of_journal_entries() {
        
    }

    function get_close_balance($open_balance, $period_balance, $convert) {
        $close_balance = ($period_balance + $open_balance) * $convert;

        return $close_balance;
    }

    function get_period_balance($account, $convert, $from='', $to='') {
        $period_balance = get_gl_trans_from_to($from, $to, $account['account_code'], '', '');
        $period = $period_balance * $convert;

        return $period;
    }

    function get_open_balance($account, $convert, $from='') {
        $open_balance = get_gl_balance_from_to("", $from, $account['account_code'], '', '');
        $open = $open_balance * $convert;

        return $open;
    }

    function get_accounts($subclass, $ctype='', $from='', $to='') {
        $accounts = array();

        $convert = get_class_type_convert($ctype);

        $result = get_gl_accounts(null, null, $subclass['id']);
        while ($account = db_fetch($result)) {

            $account['open_balance'] = $this->get_open_balance($account, $convert, $from);
            $account['period'] = $this->get_period_balance($account, $convert, $from, $to);
            $account['close_balance'] = $this->get_close_balance($account['open_balance'], $account['period'], $convert);

            $account['total_open_balance'] = ($account['open_balance'] + $account['total_open_balance']) * $convert;
            $account['total_period_balance'] = ($account['period_balance'] + $account['total_open_balance']) * $convert;
            $account['total_close_balance'] = ($account['close_balance'] + $account['total_close_balance']) * $convert;

            $account['grand_total_open'] = ($account['total_open_balance'] + $account['grand_total_open']) * $convert;
            $account['grand_total_period'] = ($account['total_period_balance'] + $account['grand_total_period']) * $convert;
            $account['grand_total_close'] = ($account['total_close_balance'] + $account['grand_total_close']) * $convert;

            if ($ctype == CL_EQUITY)
            {
                    $equity_open += $account['total_open_balance'];
                    $equity_period += $account['total_period_balance'];
                    $econvert = $convert;
            }
            elseif ($ctype == CL_LIABILITIES)
            {
                    $liability_open += $account['total_open_balance'];
                    $liability_period += $account['total_period_balance'];
                    $lconvert = $convert;
            }

            if ($lconvert == 1)
            {
                $grand_total_open = $account['grand_total_open'] * -1;
                $grand_total_period = $account['grand_total_period'] * -1;
            }

            $account['calculated_open'] = $grand_total_open;
            $account['calculated_period'] = $grand_total_period;
            $account['calculated_close'] = $grand_total_open + $grand_total_period;

            $account['topen'] = $equity_open * $econvert + $liability_open * $lconvert + $grand_total_open;
            $account['tperiod'] = $equity_period * $econvert + $liability_period * $lconvert + $grand_total_period;
            $account['tclose'] = $topen + $tperiod;
            
            $accounts[] = $account;
        }

        return $accounts;
    }

    function get_subclasses($class, $from='', $to='') {
        $subclasses = array();

        $result = get_account_types(false, $class['cid'], -1);
        while ($subclass = db_fetch($result)) {

            $subclass['accounts'] = $this->get_accounts($subclass, $class['ctype'], $from, $to);
            $subclasses[] = $subclass;
        }

        return $subclasses;
    }

    function get_classes($from='', $to='') {
        $classresult = get_account_classes(false, 1);

        while ($row = db_fetch($classresult)) {

            $class = $row;

            $class['subclasses'] = $this->get_subclasses($class, $from, $to);

            $classes[] = $class;
            
        }

        return $classes;
    }

    function get_current_fiscal() {

        global $path_to_root;
	include_once($path_to_root . "/admin/db/company_db.inc");

	$myrow = get_current_fiscalyear();
	$begin = sql2date($myrow['begin']);
        $end   = sql2date($myrow['end']);

        if ($myrow['closed'] == 0)
            $active = "Active";
        else
            $active = "Not Active";

        $fiscal = $begin." - ".$end." (".$active.")";

        return $fiscal;

    }

    function get_date($tgl, $bln, $thn) {

        if (strlen($tgl) == 1)
            $tgl = "0".$tgl;

        if (strlen($bln) == 1)
            $bln = "0".$bln;

        $date = $tgl."/".$bln."/".$thn;

        return $date;

    }

    function balance_sheet() {
        global $comp_path, $path_to_root;

        if ($_POST) {

            $this->company = get_company_pref('use_dimension');

            $from = $this->get_date($_POST['stgl'], $_POST['sbln'], $_POST['sthn']);
            $to = $this->get_date($_POST['etgl'], $_POST['ebln'], $_POST['ethn']);
            $fiscal = $this->get_current_fiscal();
            $comment = $_POST['comment'];

            $calc_open = $this->calc_period = 0.0;
            $equity_open = $this->equity_period = 0.0;
            $liability_open = $this->liability_period = 0.0;
            $econvert = $this->lconvert = 0;

            $this->from = $from;
            $this->to   = $to;
            $this->fiscal = $fiscal;
            
            $this->classes = $this->get_classes($from, $to);

            $this->view = 'mobile_reporting/general_ledger_report/balance_sheet_report';
        }
    }

    function gl_account_transactions() {

    }

    function profit_loss_statement() {
        
    }

}

?>
