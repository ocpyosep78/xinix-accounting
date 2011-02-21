<?php
/**
 * Description of general_ledger_report
 *
 * @author jafar
 */


load('xinix/controller/mobile_report');
class General_Ledger_Report extends Mobile_Report {
    function list_of_journal_entries() {
        
    }

    function balance_sheet() {
        $this->data['test'] = 'ini test';

        if ($_POST) {
            $this->view = 'mobile_reporting/general_ledger_report/coba';
        }
        
    }

    function gl_account_transactions() {

    }

    function profit_loss_statement() {

    }
}
?>
