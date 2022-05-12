<?php
namespace app;
use DateTime;

require '../vendor/autoload.php';
require_once('Purchase_Record.php');
require_once('Receipt.php');
require_once('Line_Item.php');
require_once('Utilities.php');
require_once('Filter.php');
require_once('Report.php');
require_once('Line_Item_Factory.php.bak');
require_once ('Database_Store.php');
require_once('Tax.php');
require_once ('Taxes.php');
require_once ('Currency_Field.php');
require_once ('String_Field.php');
require_once ('Category.php');
require_once('Id.php');

echo "file is powering up... \n";
echo "------------------------" . PHP_EOL;

$tax_rates_1 = ["GST"=> 0.01, "PST"=> 0.01];
$tax_rates_2 = ["GST"=> 0.20];
$tax_rates_3 = ["PST"=> 0.07, "VAT" => 0.1];

$host       =  'localhost';
$dbname     = 'receipts_tracker';
$port       = '3306';
$charset    = 'utf8mb4';
$username   = 'root';
$password   = 'root';

$db = new Database_Store($host, $dbname, $port, $charset, $username, $password);

echo "Creating line items...". PHP_EOL;
echo "------------------------" . PHP_EOL;

$user_data_1 = [
    "vendor"    => "Co-op",
    "name"      => "Tomatoes",
    "category"  => "groceries",
    "price"     => Utilities::random_price(),
    "date"      => new DateTime(),
    "tax_rates" => $tax_rates_1
    ];
$user_data_2 = [
    "vendor"    => "Walmart",
    "name"      => "Diapers",
    "category"  => "misc",
    "price"     => Utilities::random_price(),
    "date"      => new DateTime(),
    "tax_rates" => $tax_rates_2
];
$user_data_3 = [
    "vendor"    => "Canadian Tire",
    "name"      => "Oil Change",
    "category"  => "Automotive",
    "price"     => Utilities::random_price(),
    "date"      => new DateTime(),
    "tax_rates" => $tax_rates_3
];

$test_line_item_1 = Line_Item::from_post_data($user_data_1);
$test_line_item_2 = Line_Item::from_post_data($user_data_2);
$test_line_item_3 = Line_Item::from_post_data($user_data_3);

echo "Initializing receipt...";
$receipt = new Receipt();

echo "------------------------" . PHP_EOL;
echo "Initializing line items...". PHP_EOL;

$receipt->add_item($test_line_item_1);
$receipt->add_item($test_line_item_2);
$receipt->add_item($test_line_item_3);

print_r($receipt->line_items);



////todo refactor filter class
echo "---------------------------------". PHP_EOL;
$filtered_by_vendor = Filter::filter_by_vendor($receipt, "Co-op");
echo "Here's is the result of vendor filter: ". PHP_EOL;

print_r($filtered_by_vendor::$line_items). PHP_EOL;

echo "End Vendor filter test.". PHP_EOL;
//
//
////todo not working
//echo "---------------------------------". PHP_EOL;
//Filter::clear_filter($filtered_by_vendor);
//echo "Here's the result of category filter: ";
//echo "\n";
//$filtered_by_category = Filter::filter_by_category($receipt, "Automotive");
//print_r($filtered_by_category::$line_items);
//echo "\n";
//echo "End Category filter test.";
//echo "---------------------------------". PHP_EOL;
//echo "\n";
//
////todo not working
//echo "Here's the result of item name filter: ";
//echo "\n";
//$filtered_by_name = Filter::filter_by_item_name($receipt, "Diapers");
//print_r($filtered_by_name::$line_items);
//echo "\n";
//echo "End item name filter test.";
//echo "---------------------------------". PHP_EOL;
//echo "\n";





//todo rework after new types are wired up
echo "---------------------------------". PHP_EOL;
echo "Receipt subtotal: $" . number_format($receipt->subtotal(), 2,'.',',') . PHP_EOL;

echo "---------------------------------". PHP_EOL;
echo "Receipt taxes: ";
echo "\n";
//todo rewrite properly lol.....
foreach ($receipt->line_items as $tax) {
    echo "$". number_format($tax->subtotal(),2, '.',',' ) . PHP_EOL;
}


echo "\n";
echo "---------------------------------". PHP_EOL;
echo "Receipt final total: $" . number_format($receipt->total(),2,'.',',');
echo "\n";
echo "---------------------------------". PHP_EOL;

//echo "good to here.". PHP_EOL;
