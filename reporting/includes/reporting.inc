<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
// Link to printing single document with bulk report template file.
// Ex. label_cell(print_document_link($myrow['order_no'], _("Print")), $type);
// or display_note(print_document_link($order_no, _("Print this order")));
// You only need full parameter list for invoices/credit notes

function print_document_link($doc_no, $link_text, $link=true, $type_no, 
	$icon=false, $class='printlink', $id='', $email=0, $extra=0)
{
	global $path_to_root;
	include_once($path_to_root . "/includes/types.inc");

	$url = $path_to_root.'/reporting/prn_redirect.php?';

	switch ($type_no)
	{
		case ST_SALESQUOTE :
			$rep = 111;
			// from, to, currency, bank acc, email, quote, comments
			$ar = array(
				'PARAM_0' => $doc_no, 
				'PARAM_1' => $doc_no, 
				'PARAM_2' => '', 
				'PARAM_3' => $email, 
				'PARAM_4' => '');
			break;
		case ST_SALESORDER :
			$rep = 109;
			// from, to, currency, bank acc, email, quote, comments
			$ar = array(
				'PARAM_0' => $doc_no, 
				'PARAM_1' => $doc_no, 
				'PARAM_2' => '', 
				'PARAM_3' => $email, 
				'PARAM_4' => 0, 
				'PARAM_5' => '');
			break;
		case ST_CUSTDELIVERY :
			$rep = 110;
			// from, to, email, comments
			$ar = array(
				'PARAM_0' => $doc_no, 
				'PARAM_1' => $doc_no, 
				'PARAM_2' => $email,
				'PARAM_3' => $extra);
			break;
		case ST_SALESINVOICE : // Sales Invoice
		case ST_CUSTCREDIT : // Customer Credit Note
			$rep = 107;
			// from, to, currency, bank acc, email, paylink, comments, type
			$ar = array(
				'PARAM_0' => $doc_no, 
				'PARAM_1' => $doc_no, 
				'PARAM_2' => '', 
				'PARAM_3' => $email, 
				'PARAM_4' => '',
				'PARAM_5' => '', 
				'PARAM_6' => $type_no);
			break;
		case ST_PURCHORDER :
			$rep = 209;
			// from, to, currency, bank acc, email, comments
			$ar = array(
				'PARAM_0' => $doc_no, 
				'PARAM_1' => $doc_no, 
				'PARAM_2' => '', 
				'PARAM_3' => $email, 
				'PARAM_4' => '');
			break;
		case ST_CUSTPAYMENT :
			$rep = 112;
			// from, to, currency, bank acc, email, comments
			$ar = array(
				'PARAM_0' => $doc_no, 
				'PARAM_1' => $doc_no, 
				'PARAM_2' => '', 
				'PARAM_4' => '');
			break;
		case ST_SUPPAYMENT :
			$rep = 210;
			// from, to, currency, bank acc, email, comments
			$ar = array(
				'PARAM_0' => $doc_no, 
				'PARAM_1' => $doc_no, 
				'PARAM_2' => '', 
				'PARAM_3' => $email, 
				'PARAM_4' => '');
			break;
//		default: $ar = array();
	}
	
	return print_link($link_text, $rep, $ar, "", $icon, $class, $id);
}
//
//	Universal link to any kind of report.
//
function print_link($link_text, $rep, $pars = array(), $dir = '', 
	$icon=false, $class='printlink', $id='')
{
	global $path_to_root, $pdf_debug;

	$url = $dir == '' ?  $path_to_root.'/reporting/prn_redirect.php?' : $dir;

	$id = default_focus($id);
	foreach($pars as $par => $val) {
		$pars[$par] = "$par=".urlencode($val);
	}
	$pars[] = 'REP_ID='.urlencode($rep);
	$url .= implode ('&', $pars);

	if ($class != '')
		$class = $pdf_debug ? '' : " class='$class'";
	if ($id != '')
		$id = " id='$id'";
	$pars = access_string($link_text);
	if (user_graphic_links() && $icon)
		$pars[0] = set_icon($icon, $pars[0]);
	return "<a target='_blank' href='$url'$id$class $pars[1]>$pars[0]</a>";
}

?>