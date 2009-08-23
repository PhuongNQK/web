<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2005-2006  Klemens Friedl <frik85@reactos.org>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
    */

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

if (get_magic_quotes_gpc()) {
	die("ERROR: Disable 'magic quotes' in php.ini (=Off)");
}

define('ROSCMS_PATH', '../roscms/');
define('CDB_PATH', '');
require_once("lib/Compat_Autoloader.class.php");
require_once('config.php');
$RSDB_intern_link_db_sec = 'index.php?show=';


	if ( !defined('RSDB') ) {
		define ("RSDB", "rossupportdb"); // to prevent hacking activity
	}
	




	// Global Vars:
	$RSDB_SET_letter=""; // Browse by Name: Letter: All, A, B, C, ..., X, Y, Z
	$RSDB_SET_group=""; // Group ID
	
	$rpm_lang="";



	if (isset($_COOKIE['rsdb_fstyle'])) {
		$RSDB_SET_fstyle = $_COOKIE['rsdb_fstyle'];
	}
	if (isset($_COOKIE['rsdb_order'])) {
		$RSDB_SET_order = $_COOKIE['rsdb_order'];
	}

	if (array_key_exists("letter", $_GET)) $RSDB_SET_letter=htmlspecialchars($_GET["letter"]);

	
	if(isset($_COOKIE['roscms_usrset_lang'])) {
		$roscms_usrsetting_lang=$_COOKIE["roscms_usrset_lang"];
	}
	else {
		$roscms_usrsetting_lang="";
	}

	require_once('lang.php');


switch (@$_GET['show']) {

  default:
    // AJAX requests
    if (isset($_GET['get']) && $_SERVER['QUERY_STRING'] != '') {
      switch (@$_GET['get']) {

        // Suggestions
        case 'suggestions':
          new List_Suggestions();
          break;

      } // end switch get
      break;
    }

  case 'home': 
    new HTML_Home();
    break;

  // Frontpage
    break;

  // RSDB About Page
  case 'about': 
    new About();
    break;

  // RSDB Submit Conditions Page
  case 'conditions': 
    new Conditions();
    break;

  // Browse by name
  case 'list': 
    $filter = '';
    if (isset($_GET['letter']) && $_GET['letter'] != '*') {
      $filter .= 's_w_'.$_GET['letter'];
    }
    if (isset($_GET['cat'])) {
      if ($filter !== '') $filter .= '|';
      $filter .= 'c_is_'.$_GET['cat'];
    }
    if (isset($_GET['tag']) && $_GET['tag'] != '*') {
      if ($filter !== '') $filter .= '|';
      $filter .= 't_is_'.$_GET['tag'];
    }
    if (isset($_GET['filter']) && $_GET['filter'] != '') {
      $filter = $_GET['filter'];
    }
    new HTML_List($filter);
    break;

  // Vendor information
  case 'vendor_info': 
    new HTML_VendorInfo();
    break;

  // show specific version
  case 'version':
    new HTML_Entry();
    break;
  
  /*
    switch (@$_GET['addbox']) {
      case 'add':
      case 'submit':
        switch (@$_GET['item2']) {

          // Screenshots
          case 'screens':
            new Submit_Screenshot();
            break;
        } // end switch item2
        break;

      // no addbox crap
      case '':
      default:
        switch (@$_GET['item2']) {

          // Screenshots
          case 'screens':
            new Item_Screenshots();
            break;

          // Tips & Tricks
          case 'tips':
            new Item_Tips();
            break;
        } // end switch item2
        break;
    } // end switch addbox
    break;
  */

  // Submit
  case 'submit': 
    new HTML_Submit();
    break;

  // Help
  case 'help':
    new Help();
    break;

} // end switch page

?>