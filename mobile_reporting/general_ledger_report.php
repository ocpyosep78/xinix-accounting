<?php
/**
 * Description of general_ledger_report
 *
 * @author jafar
 */


load('xinix/controller/mobile_report');
class General_Ledger_Report extends Mobile_Report {
    function list_of_journal_entries() {
        load('mobile_reporting/general_ledger_report/list_of_journal_entries', $this);
    }
}
?>
