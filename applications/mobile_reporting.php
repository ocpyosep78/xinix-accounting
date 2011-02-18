<?php
class mobile_reporting_app extends mobile_application {
    function  __construct() {
        global $installed_extensions;
        $this->application("mobile_reporting", _($this->help_context = "Mobile &Reporting"));

        $this->add_module(_("General Ledger"));
        $this->add_rapp_function(0, _("List of &Journal Entries"),
                "xinix/index.php?c=mobile_reporting/general_ledger_report/list_of_journal_entries", 'SA_GLREP');
        $this->add_rapp_function(0, _("&Balance Sheet"),
                "xinix/index.php?c=mobile_reporting/general_ledger_report/balance_sheet", 'SA_GLREP');
        $this->add_rapp_function(0, _("GL Account &Transactions"),
                "xinix/index.php?c=mobile_reporting/general_ledger_report/gl_account_transactions", 'SA_GLREP');
        $this->add_rapp_function(0, _("&Profit and Loss Statement"),
                "xinix/index.php?c=mobile_reporting/general_ledger_report/profit_loss_statement", 'SA_GLREP');
        
//        $this->add_lapp_function(0, _("&Deposits"),
//                "gl/gl_bank.php?NewDeposit=Yes", 'SA_DEPOSIT');
//        $this->add_lapp_function(0, _("Bank Account &Transfers"),
//                "gl/bank_transfer.php?", 'SA_BANKTRANSFER');
//        $this->add_rapp_function(0, _("&Journal Entry"),
//                "gl/gl_journal.php?NewJournal=Yes", 'SA_JOURNALENTRY');
//        $this->add_rapp_function(0, _("&Budget Entry"),
//                "gl/gl_budget.php?", 'SA_BUDGETENTRY');
//        $this->add_rapp_function(0, _("&Reconcile Bank Account"),
//                "gl/bank_account_reconcile.php?", 'SA_RECONCILE');
//                
//        if (count($installed_extensions) > 0) {
//            foreach ($installed_extensions as $mod) {
//                if (@$mod['active'] && $mod['type'] == 'plugin' && $mod["tab"] == "GL")
//                    $this->add_rapp_function(2, $mod["title"],
//                            "modules/".$mod["path"]."/".$mod["filename"]."?",
//                            isset($mod["access"]) ? $mod["access"] : 'SA_OPEN' );
//            }
//        }
    }
}


?>