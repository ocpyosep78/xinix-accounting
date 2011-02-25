<?php
function base_url() {
    return $GLOBALS['app_config']['base_url'];
}

function theme_url($uri = '') {
    return base_url(). "/themes/".user_theme().'/'.$uri;
}

function base_path() {
    return $GLOBALS['path_to_root'];
}

function theme_path($path = '') {
    return base_path().'/themes/'.user_theme().'/'.$path;
}

function load($uri, $arg = '') {
//    echo base_path().'/'.$uri.'.php<br/><br/><br/>';
    require(base_path().'/'.$uri.'.php');
}

function display_type ($type, $typename, $from, $to, $convert)
{
	$code_open_balance = 0;
	$code_period_balance = 0;
	$open_balance_total = 0;
	$period_balance_total = 0;
	unset($totals_arr);
	$totals_arr = array();

	$printtitle = 0; //Flag for printing type name

        //Get Accounts directly under this group/type
	$result = get_gl_accounts(null, null, $type);
        
	while ($account=db_fetch($result))
	{
		$prev_balance = get_gl_balance_from_to("", $from, $account["account_code"], '', '');

		$curr_balance = get_gl_trans_from_to($from, $to, $account["account_code"], '', '');

		if (!$prev_balance && !$curr_balance)
			continue;

		$account_code = $account['account_code'];
                
		$account_name = $account['account_name'];

		$prev = $prev_balance * $convert;
		$curr = $curr_balance * $convert;
		$total = ($prev_balance + $curr_balance) * $convert;

		$code_open_balance += $prev_balance;
		$code_period_balance += $curr_balance;
	}

	//Get Account groups/types under this group/type
	$result = get_account_types(false, false, $type);
	while ($accounttype=db_fetch($result))
	{
		//Print Type Title if has sub types and not previously printed
		if (!$printtitle)
		{
			$printtitle = 1;
			$typename;
		}

		$totals_arr = display_type($accounttype["id"], $accounttype["name"], $from, $to, $convert);
		$open_balance_total += $totals_arr[0];
		$period_balance_total += $totals_arr[1];
	}

	//Display Type Summary if total is != 0 OR head is printed (Needed in case of unused hierarchical COA)
	if (($code_open_balance + $open_balance_total + $code_period_balance + $period_balance_total) != 0 || $printtitle)
	{
		$total_type = 'Total' . " " . $typename;
		$totalopen  = ($code_open_balance + $open_balance_total) * $convert;
		$totalper   = ($code_period_balance + $period_balance_total) * $convert;
		$totalbalance = ($code_open_balance + $open_balance_total + $code_period_balance + $period_balance_total) * $convert;
	}

	$totals_arr[0] = $code_open_balance + $open_balance_total;
	$totals_arr[1] = $code_period_balance + $period_balance_total;
	return $totals_arr;
}
?>
