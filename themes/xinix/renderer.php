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

class renderer {
    function wa_header() {
        page(_($help_context = "Main Menu"), false, true);
    }

    function wa_footer() {
        end_page(false, true);
    }
    function shortcut($url, $label) {
        echo "<li>";
        echo menu_link($url, $label);
        echo "</li>";
    }
    function menu_header($title, $no_menu, $is_index) {
        global $path_to_root, $help_base_url,$db_connections;
        echo "<div class='xinix-logo'></div>";
        $sel_app = $_SESSION['sel_app'];
        echo "<div class='fa-main'>\n";
        if (!$no_menu) {
            $applications = $_SESSION['App']->applications;
            $local_path_to_root = $path_to_root;
            $img = "<img src='$local_path_to_root/themes/xinix/images/login.gif' width='14' height='14' border='0' alt='"._('Logout')."'>&nbsp;&nbsp;";
            $himg = "<img src='$local_path_to_root/themes/xinix/images/help.gif' width='14' height='14' border='0' alt='"._('Help')."'>&nbsp;&nbsp;";
            echo "<div id='header'>\n";
            echo "<ul>\n";
            echo "  <li><a href='$path_to_root/admin/display_prefs.php?'>" . _("Preferences") . "</a></li>\n";
            echo "  <li><a href='$path_to_root/admin/change_current_user_password.php?selected_id=" . $_SESSION["wa_current_user"]->username . "'>" . _("Change password") . "</a></li>\n";
            if ($help_base_url != null)
                echo "  <li><a target = '_blank' onclick=" .'"'."javascript:openWindow(this.href,this.target); return false;".'" '. "href='".
                        help_url()."'>$himg" . _("Help") . "</a></li>";
            echo "  <li><a href='$path_to_root/access/logout.php?'>$img" . _("Logout") . "</a></li>";
            echo "</ul>\n";
            $indicator = "$path_to_root/themes/".user_theme(). "/images/ajax-loader.gif";
            echo "<h1>$power_by $version<span style='padding-left:300px;'><img id='ajaxmark' src='$indicator' align='center' style='visibility:hidden;'></span></h1>\n";
            echo "</div>\n"; // header
            echo "<div class='fa-menu'>";
            echo "<ul>\n";
            foreach($applications as $app) {
                $acc = access_string($app->name);
                echo "<li ".($sel_app == $app->id ? "class='active' " : "") . "><a href='$local_path_to_root/index.php?application=" . $app->id
                        ."'$acc[1]><b>" . $acc[0] . "</b></a></li>\n";
            }
            echo "</ul>\n";
            echo "</div>\n"; // menu
            echo "<div class='clear'></div>\n";
        }
        echo "<div class='fa-body'>\n";
        if (!$no_menu) {
            echo "<div class='fa-side'>\n";
            echo "<div class='fa-submenu'>\n";
            echo "<ul>\n";
            echo "<li><a class='menu_current' href='#'>"._("Shortcuts")."</a></li>\n";
            switch ($sel_app) // Shortcuts
            {
                case "orders":
                    $this->shortcut($local_path_to_root."/sales/sales_order_entry.php?NewOrder=Yes'",_("Sales Order"));
                    $this->shortcut($local_path_to_root."/sales/sales_order_entry.php?NewInvoice=0",_("Direct Invoice"));
                    $this->shortcut($local_path_to_root."/sales/customer_payments.php?", _("Payments"));
                    $this->shortcut($local_path_to_root."/sales/inquiry/sales_orders_view.php?", _("Sales Order Inquiry"));
                    $this->shortcut($local_path_to_root."/sales/inquiry/customer_inquiry.php?", _("Transactions"));
                    $this->shortcut($local_path_to_root."/sales/manage/customers.php?", _("Customers"));
                    $this->shortcut($local_path_to_root."/sales/manage/customer_branches.php?", _("Branch"));
                    $this->shortcut($local_path_to_root."/reporting/reports_main.php?Class=0", _("Reports and Analysis"));
                    break;
                case "AP":
                    $this->shortcut($local_path_to_root."/purchasing/po_entry_items.php?NewOrder=0", _("Purchase Order"));
                    $this->shortcut($local_path_to_root."/purchasing/inquiry/po_search.php?", _("Receive"));
                    $this->shortcut($local_path_to_root."/purchasing/supplier_invoice.php?New=1", _("Supplier Invoice"));
                    $this->shortcut($local_path_to_root."/purchasing/supplier_payment.php?", _("Payments"));
                    $this->shortcut($local_path_to_root."/purchasing/inquiry/supplier_inquiry.php?", _("Transactions"));
                    $this->shortcut($local_path_to_root."/purchasing/manage/suppliers.php?", _("Suppliers"));
                    $this->shortcut($local_path_to_root."/reporting/reports_main.php?Class=1", _("Reports and Analysis"));
                    break;
                case "stock":
                    $this->shortcut($local_path_to_root."/inventory/adjustments.php?NewAdjustment=1", _("Inventory Adjustments"));
                    $this->shortcut($local_path_to_root."/inventory/inquiry/stock_movements.php?", _("Inventory Movements"));
                    $this->shortcut($local_path_to_root."/inventory/manage/items.php?", _("Items"));
                    $this->shortcut($local_path_to_root."/inventory/prices.php?", _("Sales Pricing"));
                    $this->shortcut($local_path_to_root."/reporting/reports_main.php?Class=2", _("Reports and Analysis"));
                    break;
                case "manuf":
                    $this->shortcut($local_path_to_root."/manufacturing/work_order_entry.php?", _("Work Order Entry"));
                    $this->shortcut($local_path_to_root."/manufacturing/search_work_orders.php?outstanding_only=1", _("Ourstanding Work Orders"));
                    $this->shortcut($local_path_to_root."/manufacturing/search_work_orders.php?", _("Work Order Inquiry"));
                    $this->shortcut($local_path_to_root."/manufacturing/manage/bom_edit.php?", _("Bills Of Material"));
                    $this->shortcut($local_path_to_root."/reporting/reports_main.php?Class=3", _("Reports and Analysis"));
                    break;
                case "proj":
                    $this->shortcut($local_path_to_root."/dimensions/dimension_entry.php?", _("Dimension Entry"));
                    $this->shortcut($local_path_to_root."/dimensions/inquiry/search_dimensions.php?", _("Dimension Inquiry"));
                    $this->shortcut($local_path_to_root."/reporting/reports_main.php?Class=4", _("Reports and Analysis"));
                    break;
                case "GL":
                    $this->shortcut($local_path_to_root."/gl/gl_bank.php?NewPayment=Yes",_("Payments"));
                    $this->shortcut($local_path_to_root."/gl/gl_bank.php?NewDeposit=Yes",_("Deposits"));
                    $this->shortcut($local_path_to_root."/gl/gl_journal.php?NewJournal=Yes",_("Journal Entry"));
                    $this->shortcut($local_path_to_root."/gl/inquiry/bank_inquiry.php?",_("Bank Account Inquiry"));
                    $this->shortcut($local_path_to_root."/gl/inquiry/gl_account_inquiry.php?",_("GL Account Inquiry"));
                    $this->shortcut($local_path_to_root."/gl/inquiry/gl_trial_balance.php?",_("Trial Balance"));
                    $this->shortcut($local_path_to_root."/gl/manage/exchange_rates.php?",_("Exchange Rates"));
                    $this->shortcut($local_path_to_root."/gl/manage/gl_accounts.php?",_("GL Accounts"));
                    $this->shortcut($local_path_to_root."/reporting/reports_main.php?Class=6",_("Reports and Analysis"));
                    break;
                case "system":
                    $this->shortcut($local_path_to_root."/admin/company_preferences.php?",_("Company Setup"));
                    $this->shortcut($local_path_to_root."/admin/gl_setup.php?",_("General GL"));
                    $this->shortcut($local_path_to_root."/taxes/tax_types.php?",_("Taxes"));
                    $this->shortcut($local_path_to_root."/taxes/tax_groups.php?",_("Tax Groups"));
                    $this->shortcut($local_path_to_root."/admin/forms_setup.php?",_("Forms Setup"));
                    break;
            }
            echo "</ul>\n";
            echo "</div>\n"; // submenu
            echo "<div class='clear'></div>\n";
            echo "</div>\n"; // fa-side
        }
        echo "<div class='fa-content'>\n";
        if ($no_menu)
            echo "<br>";
        elseif ($title && !$no_menu && !$is_index) {
            echo "<center><table id='title'><tr><td width='100%' class='titletext'>$title</td>"
                    ."<td align=right>"
                    .(user_hints() ? "<span id='hints'></span>" : '')
                    ."</td>"
                    ."</tr></table></center>";
        }
    }

    function menu_footer($no_menu, $is_index) {
        global $path_to_root, $power_url, $power_by, $version, $db_connections;
        include_once($path_to_root . "/includes/date_functions.inc");

        echo "</div>\n"; // fa-content
        echo "</div>\n"; // fa-body
        if ($no_menu == false) {
            echo "<div class='fa-footer'>\n";
            if (isset($_SESSION['wa_current_user'])) {
                echo "<span class='power'><a target='_blank' href='$power_url'>$power_by $version</a></span>\n";
                echo "<span class='date'>".Today() . "&nbsp;" . Now()."</span>\n";
                echo "<span class='date'>" . $db_connections[$_SESSION["wa_current_user"]->company]["name"] . "</span>\n";
                echo "<span class='date'>" . $_SERVER['SERVER_NAME'] . "</span>\n";
                echo "<span class='date'>" . $_SESSION["wa_current_user"]->name . "</span>\n";
                echo "<span class='date'>" . _("Theme:") . " " . user_theme() . "</span>\n";
                echo "<span class='date'>".show_users_online()."</span>\n";
            }
            echo "</div>\n"; // footer
        }
        echo "</div>\n"; // fa-main
    }

    function display_applications(&$waapp) {
        global $path_to_root;
        $sel_app = $waapp->get_selected_application();
        foreach ($sel_app->modules as $module) {
            // image
            echo "<table width='95%' align='center'><tr>";
            echo "<td valign='top' class='menu_group'>";
            echo "<table border=0 width='100%'>";
            echo "<tr><td class='menu_group'>";
            echo $module->name;
            echo "</td></tr><tr>";
            echo "<td width='50%' class='menu_group_items'>";
            $img = "<img src='$path_to_root/themes/xinix/images/folder.gif' width='14' height='14' border='0'>&nbsp;&nbsp;";
            if ($_SESSION["language"]->dir == "rtl")
                $class = "right";
            else
                $class = "left";
            foreach ($module->lappfunctions as $appfunction) {
                if ($appfunction->label == "")
                    echo "<div class='empty'>&nbsp;<br></div>\n";
                elseif ($_SESSION["wa_current_user"]->can_access_page($appfunction->access))
                    echo "<div>".$img.menu_link($appfunction->link, $appfunction->label."</div>");
                else
                    echo "<div>".$img."<span class='inactive'>".access_string($appfunction->label, true)."</span></div>\n";
            }
            echo "</td>\n";
            if (sizeof($module->rappfunctions) > 0) {
                echo "<td width='50%' class='menu_group_items'>";
                foreach ($module->rappfunctions as $appfunction) {
                    if ($appfunction->label == "")
                        echo "<div class='empty'>&nbsp;<br></div>\n";
                    elseif ($_SESSION["wa_current_user"]->can_access_page($appfunction->access))
                        echo "<div>".$img.menu_link($appfunction->link, $appfunction->label."</div>");
                    else
                        echo "<div>".$img."<span class='inactive'>".access_string($appfunction->label, true)."</span></div>\n";
                }
                echo "</td>\n";
            }
            echo "</tr></table></td></tr></table>\n";
        }
    }
}

?>
=======
	class renderer
	{
		function wa_header()
		{
//			add_js_ufile("themes/default/renderer.js");
			page(_($help_context = "Main Menu"), false, true);
		}

		function wa_footer()
		{
			end_page(false, true);
		}

		function menu_header($title, $no_menu, $is_index)
		{
			global $path_to_root, $help_base_url, $db_connections;
			// you can owerride the table styles from config.php here, if you want.
			//global $table_style, $table_style2;
			//$table_style 	= "cellpadding=3 border=1 bordercolor='#8cacbb' style='border-collapse: collapse'";
			//$table_style2 = "cellpadding=3 border=1 bordercolor='#cccccc' style='border-collapse: collapse'";
			echo "<table class='callout_main' border='0' cellpadding='0' cellspacing='0'>\n";
			echo "<tr>\n";
			echo "<td colspan='2' rowspan='2'>\n";

			echo "<table class='main_page' border='0' cellpadding='0' cellspacing='0'>\n";
			echo "<tr>\n";
			echo "<td>\n";
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>\n";
			echo "<tr>\n";
			echo "<td class='quick_menu'>\n";
			if (!$no_menu)
			{
				$applications = $_SESSION['App']->applications;
				$local_path_to_root = $path_to_root;
				$img = "<img src='$local_path_to_root/themes/default/images/login.gif' width='14' height='14' border='0' alt='"._('Logout')."'>&nbsp;&nbsp;";
				$himg = "<img src='$local_path_to_root/themes/default/images/help.gif' width='14' height='14' border='0' alt='"._('Help')."'>&nbsp;&nbsp;";
				$sel_app = $_SESSION['sel_app'];
				echo "<table cellpadding=0 cellspacing=0 width='100%'><tr><td>";
				echo "<div class=tabs>";
				foreach($applications as $app)
				{
					$acc = access_string($app->name);
					echo "<a ".($sel_app == $app->id ? 
						("class='selected'") : "")
						." href='$local_path_to_root/index.php?application=".$app->id
						."'$acc[1]>" .$acc[0] . "</a>";
				}
				echo "</div>";
				echo "</td></tr></table>";

				echo "<table class=logoutBar>";
				echo "<tr><td class=headingtext3>" . $db_connections[$_SESSION["wa_current_user"]->company]["name"] . " | " . $_SERVER['SERVER_NAME'] . " | " . $_SESSION["wa_current_user"]->name . "</td>";
				$indicator = "$path_to_root/themes/".user_theme(). "/images/ajax-loader.gif";
				echo "<td class='logoutBarRight'><img id='ajaxmark' src='$indicator' align='center' style='visibility:hidden;'></td>";
				echo "  <td class='logoutBarRight'><a href='$path_to_root/admin/display_prefs.php?'>" . _("Preferences") . "</a>&nbsp;&nbsp;&nbsp;\n";
				echo "  <a href='$path_to_root/admin/change_current_user_password.php?selected_id=" . $_SESSION["wa_current_user"]->username . "'>" . _("Change password") . "</a>&nbsp;&nbsp;&nbsp;\n";

				if ($help_base_url != null)
				{
					echo "$himg<a target = '_blank' onclick=" .'"'."javascript:openWindow(this.href,this.target); return false;".'" '. "href='". help_url()."'>" . _("Help") . "</a>&nbsp;&nbsp;&nbsp;";
				}
				echo "$img<a href='$local_path_to_root/access/logout.php?'>" . _("Logout") . "</a>&nbsp;&nbsp;&nbsp;";
				echo "</td></tr><tr><td colspan=3>";
				echo "</td></tr></table>";
			}
			echo "</td></tr></table>";

			if ($no_menu)
				echo "<br>";
			elseif ($title && !$is_index)
			{
				echo "<center><table id='title'><tr><td width='100%' class='titletext'>$title</td>"
				."<td align=right>"
				.(user_hints() ? "<span id='hints'></span>" : '')
				."</td>"
				."</tr></table></center>";
			}
		}

		function menu_footer($no_menu, $is_index)
		{
			global $version, $allow_demo_mode, $app_title, $power_url, 
				$power_by, $path_to_root, $Pagehelp, $Ajax;
			include_once($path_to_root . "/includes/date_functions.inc");

			if ($no_menu == false)
			{
				if ($is_index)
					echo "<table class=bottomBar>\n";
				else
					echo "<table class=bottomBar2>\n";
				echo "<tr>";
				if (isset($_SESSION['wa_current_user'])) {
					$phelp = implode('; ', $Pagehelp);
					echo "<td class=bottomBarCell>" . Today() . " | " . Now() . "</td>\n";
					$Ajax->addUpdate(true, 'hotkeyshelp', $phelp);
					echo "<td id='hotkeyshelp'>".$phelp."</td>";
				}
				echo "</tr></table>\n";
			}
			echo "</td></tr></table></td>\n";
			echo "</table>\n";
			if ($no_menu == false)
			{
				echo "<table align='center' id='footer'>\n";
				echo "<tr>\n";
				echo "<td align='center' class='footer'><a target='_blank' href='$power_url' tabindex='-1'><font color='#ffffff'>$app_title $version - " . _("Theme:") . " " . user_theme() . " - ".show_users_online()."</font></a></td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td align='center' class='footer'><a target='_blank' href='$power_url' tabindex='-1'><font color='#ffff00'>$power_by</font></a></td>\n";
				echo "</tr>\n";
				if ($allow_demo_mode==true)
				{
					echo "<tr>\n";
					//echo "<td><br><div align='center'><a href='http://sourceforge.net'><img src='http://sourceforge.net/sflogo.php?group_id=89967&amp;type=5' alt='SourceForge.net Logo' width='210' height='62' border='0' align='middle' /></a></div></td>\n";
					echo "</tr>\n";
				}
				echo "</table><br><br>\n";
			}
		}

		function display_applications(&$waapp)
		{
			global $path_to_root;

			$selected_app = $waapp->get_selected_application();
			$img = "<img src='$path_to_root/themes/default/images/right.gif' style='vertical-align:middle;' width='17' height='17' border='0'>&nbsp;&nbsp;";
			foreach ($selected_app->modules as $module)
			{
				// image
				echo "<tr>";
				// values
				echo "<td valign='top' class='menu_group'>";
				echo "<table border=0 width='100%'>";
				echo "<tr><td class='menu_group'>";
				echo $module->name;
				echo "</td></tr><tr>";
				echo "<td class='menu_group_items'>";

				foreach ($module->lappfunctions as $appfunction)
				{
					if ($appfunction->label == "")
						echo "&nbsp;<br>";
					elseif ($_SESSION["wa_current_user"]->can_access_page($appfunction->access)) 
					{
							echo $img.menu_link($appfunction->link, $appfunction->label)."<br>\n";
					}
					else 
					{
							echo $img.'<span class="inactive">'
								.access_string($appfunction->label, true)
								."</span><br>\n";
					}
				}
				echo "</td>";
				if (sizeof($module->rappfunctions) > 0)
				{
					echo "<td width='50%' class='menu_group_items'>";
					foreach ($module->rappfunctions as $appfunction)
					{
						if ($appfunction->label == "")
							echo "&nbsp;<br>";
						elseif ($_SESSION["wa_current_user"]->can_access_page($appfunction->access)) 
						{
								echo $img.menu_link($appfunction->link, $appfunction->label)."<br>\n";
						}
						else 
						{
								echo $img.'<span class="inactive">'
									.access_string($appfunction->label, true)
									."</span><br>\n";
						}
					}
					echo "</td>";
				}

				echo "</tr></table></td></tr>";
			}

			echo "</table>";
		}
	}

?>