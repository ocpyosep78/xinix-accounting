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

    function get_close_balance($open_balance, $period_balance, $convert) {
        
        $close_balance = ($period_balance + $open_balance);

        return $close_balance;
    }

    function get_period_balance($account, $convert, $from='', $to='') {
        
        $period_balance = get_gl_trans_from_to($from, $to, $account['account_code']);
        $period = $period_balance * $convert;

        return $period;
    }

    function get_open_balance($account, $convert, $from='') {
        
        $open_balance = get_gl_balance_from_to("", $from, $account['account_code'], '', '');
        $open = $open_balance * $convert;

        return $open;
    }

    function get_accumulated($begin, $end, $account, $compare, $convert) {

        if ($compare == 2)
            $acc_balance = get_budget_trans_from_to($begin, $end, $account["account_code"]);
        else
            $acc_balance = get_gl_trans_from_to($begin, $end, $account["account_code"]);

        $acc_balance = $acc_balance * $convert;

        return $acc_balance;
        
    }

    function get_accounts($subclass, $ctype='', $from='', $to='', $compare='', $begin='', $end='') {
        
        $accounts = array();

        $convert = get_class_type_convert($ctype);

        $result = get_gl_accounts(null, null, $subclass['id']);
        while ($account = db_fetch($result)) {

            $account['open_balance'] = $this->get_open_balance($account, $convert, $from);
            $account['period'] = $this->get_period_balance($account, $convert, $from, $to);
            $account['close_balance'] = $this->get_close_balance($account['open_balance'], $account['period'], $convert);
            $account['acc'] = $this->get_accumulated($begin, $end, $account, $compare, $convert);
            $account['achieved'] = $this->get_achieve($account['period'], $account['acc']);

            $total_open_balance = ($account['open_balance'] + $total_open_balance) * $convert;
            $total_period_balance = ($account['period'] + $total_period_balance) * $convert;
            $total_close_balance = ($account['close_balance'] + $total_close_balance) * $convert;
            $total_acc = ($account['acc'] + $total_acc) * $convert;
            $total_achieved = $this->get_achieve($total_period_balance, $total_acc);

            $accounts[] = $account;
            
        }

        return $accounts;
        
    }

    function get_subclasses($class, $from='', $to='', $compare='', $begin='', $end='') {
        
        $subclasses = array();

        $result = get_account_types(false, $class['cid'], -1);        
        while ($subclass = db_fetch($result)) {

            $convert = get_class_type_convert($class['ctype']);
            
            $subclass['accounts'] = $this->get_accounts($subclass, $class['ctype'], $from, $to, $compare, $begin, $end);

            $total_open   = 0;
            $total_period = 0;
            $total_close  = 0;
            $total_acc    = 0;

            foreach ($subclass['accounts'] as $account) {
                
                $total_open   += $account['open_balance'];
                $total_period += $account['period'];
                $total_close  += $account['close_balance'];
                $total_acc    += $account['acc'];
                $total_achieved = $this->get_achieve($total_period, $total_acc);
                
            }
            
            $subclass['total_open'] = $total_open;
            $subclass['total_period'] = $total_period;
            $subclass['total_close'] = $total_close;
            $subclass['total_acc'] = $total_acc;
            $subclass['total_achieved'] = $total_achieved;

            $subclasses[] = $subclass;
            
        }

        return $subclasses;
        
    }

    function get_classes($from='', $to='', $begin='', $end='', $balance='', $compare='') {
        
        $classresult = get_account_classes(false, $balance);

        while ($row = db_fetch($classresult)) {

            $class = $row;

            $convert = get_class_type_convert($class['ctype']);

            $class['subclasses'] = $this->get_subclasses($class, $from, $to, $compare, $begin, $end);

            $total_open   = 0;
            $total_period = 0;
            $total_close  = 0;
            $total_acc    = 0;

            foreach ($class['subclasses'] as $subclass) {

                $total_open   += $subclass['total_open'] * $convert;
                $total_period += $subclass['total_period'] * $convert;
                $total_close  += $subclass['total_close'] * $convert;
                $total_acc    += $subclass['total_acc'] * $convert;
                $total_achieved = $this->get_achieve($total_period, $total_acc);

            }

            $class['total_open']    = $total_open;
            $class['total_period']  = $total_period;
            $class['total_close']   = $total_close;
            $class['total_acc']     = $total_acc;
            $class['total_achieved']= $total_achieved;

            if ($class['ctype'] == CL_EQUITY)
            {
                $equity_open += $total_open;
                $equity_period += $total_period;
                $econvert = $convert;

                $class['equity_open']   = $equity_open;
                $class['equity_period'] = $equity_period;
                $class['econvert']      = $econvert;
            }
            elseif ($class['ctype'] == CL_LIABILITIES)
            {
                $liability_open += $total_open;
                $liability_period += $total_period;
                $lconvert = $convert;

                $class['liability_open']    = $liability_open;
                $class['liability_period']  = $liability_period;
                $class['lconvert']          = $lconvert;
            }

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
            $active = "Close";

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

    function get_compare_to($from, $to, $compare) {

        $compare_to = array();

        if ($compare == 0 || $compare == 2)
	{
		$end = $to;
		if ($compare == 2)
		{
                    $begin = $from;
                    $header = _('Budget');
		}
		else
                {
                    $begin = begin_fiscalyear();
                    $header = _('Accumulated');
                }
	}
	elseif ($compare == 1)
	{
		$begin = add_months($from, -12);
		$end = add_months($to, -12);
		$header = _('Period Y-1');
	}

        if (isset($header)) {
            $compare_to['header'] = $header;
            $compare_to['begin']  = $begin;
            $compare_to['end']    = $end;
        }
        else
            $compare_to = "";

        return $compare_to;

    }

    function get_achieve($period, $accumulated) {

        if ($period == 0 && $accumulated == 0)
		return 0;
	elseif ($accumulated == 0)
		return 999;
	$ret = ($period / $accumulated * 100.0);
	if ($ret > 999)
		$ret = 999;
	return $ret;

    }

    function get_type($type, $types) {

        if ($type == -1)
            return $result = "All";
        else
            return $result = $types[$type];

    }

    function get_journal($from, $to, $filtertype) {

        global $systypes_array;

        $journals = array();

        $typeno = $type = 0;

        $trans = get_gl_transactions($from, $to, -1, null, 0, 0, $filtertype);
        while($row = db_fetch($trans)) {
            if($type != $row['type'] || $typeno != $row['type_no'])
            {

                $typeno     = $row['type_no'];
                $type       = $row['type'];
                $trans_name = $systypes_array[$row['type']];
                $reference  = get_reference($row['type'], $row['type_no']);
                $tran_date  = sql2date($row['tran_date']);

                $journal['typeno']      = $typeno;
                $journal['type']        = $type;
                $journal['trans_name']  = $trans_name;
                $journal['reference']   = $reference;
                $journal['tran_date']   = $tran_date;

                $coms = payment_person_name($row["person_type_id"],$row["person_id"]);
                $memo = get_comments_string($row['type'], $row['type_no']);
                
                if ($memo != '')
                {
                    if ($coms == "")
                        $coms = $memo;
                    else
                        $coms .= " / ".$memo;
                }

                $journal['coms'] = $coms;

            }
            
            $journal['account']      = $row['account'];
            $journal['account_name'] = $row['account_name'];
            $journal['memo']         = $row['memo_'];

            if($row['amount'] > 0.0) {

                $journal['debit']  = abs($row['amount']);
                $journal['credit'] = '';

            }else{

                $journal['debit']  = '';
                $journal['credit'] = abs($row['amount']);

            }

            $journals[] = $journal;

        }

        return $journals;

    }

    function get_chart_account() {

        $accounts = array();

        $sql = "SELECT chart.account_code, chart.account_name, type.name, chart.inactive, type.id
                FROM ".TB_PREF."chart_master chart,".TB_PREF."chart_types type
                WHERE chart.account_type=type.id";
        $result = db_query($sql);
        while($row = db_fetch($result)) {

            $account['code'] = $row['account_code'];
            $account['name'] = $row['account_name'];
            $account['type'] = $row['name'];

            $accounts[] = $account;

        }

        return $accounts;

    }

    function balance_sheet() {
        global $comp_path, $path_to_root;

        if ($_POST) {

            $this->company = get_company_pref('use_dimension');

            $calculated_open = $calculated_period = 0.0;
            $equity_open = $equity_period = 0.0;
            $liability_open = $liability_period = 0.0;
            $econvert = $lconvert = 0;

            $from = $this->get_date($_POST['stgl'], $_POST['sbln'], $_POST['sthn']);
            $to = $this->get_date($_POST['etgl'], $_POST['ebln'], $_POST['ethn']);
            $fiscal = $this->get_current_fiscal();
            $comment = $_POST['comment'];

            $this->from = $from;
            $this->to   = $to;
            $this->fiscal = $fiscal;

            $this->classes = $this->get_classes($from, $to, "", "", "1");

            $topen   = 0;
            $tperiod = 0;
            $tclose  = 0;
            $tacc    = 0;
            
            foreach($this->classes as $class) {

                if ($class['lconvert'] == 1)
                {
                    $class['total_open'] *= -1;
                    $class['total_period'] *= -1;
                }

                $calculated_open += $class['total_open'];
                $calculated_period += $class['total_period'];
                $calculated_close = $calculated_open + $calculated_period;
                
                $this->calculated_open = $calculated_open;
                $this->calculated_period = $calculated_period;
                $this->calculated_close = $calculated_close;

                $topen = $class['equity_open'] * $class['econvert'] + $class['liability_open'] * $class['lconvert'] + $calculated_open;
                $tperiod = $class['equity_period'] * $class['econvert'] + $class['liability_period'] * $class['lconvert'] + $calculated_period;
                $tclose = $topen + $tperiod;

                $this->topen = $topen;
                $this->tperiod = $tperiod;
                $this->tclose = $tclose;

            }

            $this->view = 'mobile_reporting/general_ledger_report/balance_sheet_report';
        }
    }

    function gl_account_transactions() {

        global $comp_path, $path_to_root;

        $this->accounts = $this->get_chart_account();

        if($_POST) {

            $from       = $this->get_date($_POST['stgl'], $_POST['sbln'], $_POST['sthn']);
            $to         = $this->get_date($_POST['etgl'], $_POST['ebln'], $_POST['ethn']);
            $fiscal     = $this->get_current_fiscal();
            $facc       = $_POST['facc'];
            $tacc       = $_POST['tacc'];
            $account    = $facc." - ".$tacc;

            $this->from     = $from;
            $this->to       = $to;
            $this->fiscal   = $fiscal;
            $this->account  = $account;

            $this->gl = $this->get_gl_trans($from, $to, $facc, $tacc);

            $this->view = 'mobile_reporting/general_ledger_report/gl_account_trans_report';

        }

    }

    function get_gl_trans($from, $to, $facc, $tacc) {

        $accounts = array();

        $result = get_gl_accounts($facc, $tacc);
        while ($row = db_fetch($result)) {

            if (is_account_balancesheet($row["account_code"]))
                $begin = "";
            else
            {
                $begin = begin_fiscalyear();
                if (date1_greater_date2($begin, $from))
                    $begin = $from;
                $begin = add_days($begin, -1);
            }

            $prev_balance = get_gl_balance_from_to($begin, $from, $row["account_code"]);
            $trans = get_gl_transactions($from, $to, -1, $row['account_code']);
            $rows = db_num_rows($trans);
            if ($prev_balance == 0.0 && $rows == 0)
                continue;

            $account['type'] = $row['account_code'] . " " . $row['account_name'];

            $account['debit'] = $account['credit'] = "";

            if ($prev_balance > 0.0)
                $account['debit'] = abs($prev_balance);
            else
                $account['credit'] = abs($prev_balance);

            $accounts[] = $account;

        }

        return $accounts;

    }

    function profit_loss_statement() {
        global $comp_path, $path_to_root;

        if ($_POST){

            $this->company = get_company_pref('use_dimension');

            $from       = $this->get_date($_POST['stgl'], $_POST['sbln'], $_POST['sthn']);
            $to         = $this->get_date($_POST['etgl'], $_POST['ebln'], $_POST['ethn']);
            $fiscal     = $this->get_current_fiscal();
            $compare    = $_POST['compare'];
            $compare_to = $this->get_compare_to($from, $to, $compare);

            $this->from         = $from;
            $this->to           = $to;
            $this->fiscal       = $fiscal;
            $this->compare_to   = $compare_to;

            $this->classes = $this->get_classes($from, $to, $compare_to['begin'], $compare_to['end'], "0", $compare);

            foreach($this->classes as $class) {

                $calculated_period += $class['total_period'];
                $calculated_acc += $class['total_acc'];
                $calculated_achieved = $this->get_achieve($calculated_period, $calculated_acc);

                $this->calculated_period    = $calculated_period;
                $this->calculated_acc       = $calculated_acc;
                $this->calculated_achieved  = $calculated_achieved;

            }
            
            $this->view = 'mobile_reporting/general_ledger_report/profit_loss_report';

        }
    }
    
    function list_of_journal_entries() {
        
        global $comp_path, $path_to_root, $systypes_array;

	$types = $systypes_array;

	foreach(array(ST_LOCTRANSFER, ST_PURCHORDER, ST_SUPPRECEIVE, ST_MANUISSUE, ST_MANURECEIVE, ST_SALESORDER, ST_SALESQUOTE, ST_DIMENSION) as $type)
            unset($types[$type]);

        $this->types = $types;

        if($_POST) {

            $this->company = get_company_pref('use_dimension');

            $filtertype = $_POST['type'];
            $from       = $this->get_date($_POST['stgl'], $_POST['sbln'], $_POST['sthn']);
            $to         = $this->get_date($_POST['etgl'], $_POST['ebln'], $_POST['ethn']);
            $fiscal     = $this->get_current_fiscal();
            $typename   = $this->get_type($filtertype, $types);

            $this->from     = $from;
            $this->to       = $to;
            $this->fiscal   = $fiscal;
            $this->types    = $typename;

            if($filtertype == -1)
                $filtertype = null;

            $this->journal = $this->get_journal($from, $to, $filtertype);

            $this->view = 'mobile_reporting/general_ledger_report/journal_entries_report';

        }

    }

}

?>
