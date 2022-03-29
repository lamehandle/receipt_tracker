<?php
namespace app;
use DateTime;

require __DIR__ . '/vendor/autoload.php';
require_once('Purchase_Record.php');
require_once('Receipt.php');
require_once('Line_Item.php');
require_once('Utilities.php');
require_once('Filter.php');
require_once('Report.php');
require_once('Line_Item_Factory.php');
require_once ('Database_Store.php');

$tax_rates_1 = ["GST"=> 0.01, "PST"=> 0.01 ];
$tax_rates_2 = ["GST"=> 0.20];
$tax_rates_3 = ["PST"=> 0.07, "VAT" => 0.1];

$date = new DateTime();

$host       =  'localhost';
$dbname     = 'receipts_tracker';
$port       = '3306';
$charset    = 'utf8mb4';
$username   = 'root';
$password   = 'root';

$db = new Database_Store($host, $dbname, $port, $charset, $username, $password);

echo "file is powering up... \n";
echo "------------------------" . PHP_EOL;

echo "\n";
echo "Creating line items...". PHP_EOL;
echo "------------------------" . PHP_EOL;

$user_data_1 = [

    'vendor'    => "Co-op",
    'item'      => "Tomatoes",
    'category'  => "groceries",
    'tax_rates' => $tax_rates_1,
    'price'     => Utilities::random_price()
    ];
$user_data_2 = [

    'vendor'    => "Walmart",
    'item'      => "Diapers",
    'category'  => "misc",
    'tax_rates' => $tax_rates_2,
    'price'     => Utilities::random_price()
];
$user_data_3 = [

    'vendor'    => "Canadian Tire",
    'item'      => "Oil Change",
    'category'  => "Automotive",
    'tax_rates' => $tax_rates_3,
    'price'     => Utilities::random_price()
];

$test_input_1  = LineItemFactory::getUserData($user_data_1);
$test_input_2 = LineItemFactory::getUserData($user_data_2);
$test_input_3 = LineItemFactory::getUserData($user_data_3);

echo "Initializing receipt...";
echo "\n";

$receipt = new Receipt(uniqid("", false));

echo "------------------------" . PHP_EOL;
echo "Initializing line items...". PHP_EOL;
echo "\n";

$receipt->addItem($test_input_1);

$receipt->addItem($test_input_2);

$receipt->addItem($test_input_3);

//print_r($receipt);

echo "---------------------------------". PHP_EOL;
$filtered_by_vendor = Filter::filter_by_vendor($receipt, "Co-op");
echo "Here's is the result of vendor filter: ";
echo "\n";
print_r($filtered_by_vendor->line_items);
echo "\n";
echo "End Vendor filter test.";
echo "\n";
echo "---------------------------------". PHP_EOL;

Filter::clear_filter($filtered_by_vendor);

echo "Here's the result of category filter: ";
echo "\n";
$filtered_by_category = Filter::filter_by_category($receipt, "Automotive");
print_r($filtered_by_category->line_items);
echo "\n";
echo "End Category filter test.";
echo "---------------------------------". PHP_EOL;
echo "\n";

echo "Here's the result of item name filter: ";
echo "\n";
$filtered_by_name = Filter::filter_by_item_name($receipt, "Diapers");
print_r($filtered_by_name->line_items);
echo "\n";
echo "End item name filter test.";
echo "---------------------------------". PHP_EOL;
echo "\n";

echo "---------------------------------". PHP_EOL;
echo "Receipt subtotal: $" . number_format($receipt->subtotal(),2,'.',',') . PHP_EOL;

echo "---------------------------------". PHP_EOL;
echo "Receipt taxes: ";
echo "\n";
foreach ($receipt->taxes() as $tax) {
    echo "$". number_format($tax,2,'.',',') . PHP_EOL;
}
echo "\n";
echo "---------------------------------". PHP_EOL;
echo "Receipt final total: $" . number_format($receipt->total(),2,'.',',');
echo "\n";
echo "---------------------------------". PHP_EOL;

print_r($test_input_1);
$db->save_item($test_input_1);