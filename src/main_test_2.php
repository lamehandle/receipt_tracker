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
require_once ('Line_Item_Builder.php');

$tax_rates_1 = ["GST"=> 0.01, "PST"=> 0.01 ];
$tax_rates_2 = ["GST"=> 0.20];
$tax_rates_3 = ["PST"=> 0.07, "VAT" => 0.1];

$date = new DateTime();

//test adding arrays of categories to a category list
//$new_category_test_1 = ["Lasers?","Bombs?"];
//$new_category_test_2 = ["Kittens","Puppies","Snakes"];
//$new_category_test_3 = ["Kittens","Puppies","Snakes!", "Knives!"];


echo "\n";
echo "file is powering up... \n";
echo "------------------------" . PHP_EOL;
echo "\n";

echo "\n";
echo "Creating line items...";
echo "------------------------" . PHP_EOL;
echo "\n";

$user_data_1 = [

    'vendor'    => "Co-op",
    'item'      => "Tomatoes",
    'category'  => "groceries",
    'tax_rates' => $tax_rates_1 ,
    'price'     => Utilities::random_price(),
    ];
$user_data_2 = [

    'vendor'    => "Walmart",
    'item'      => "Diapers",
    'category'  => "misc",
    'tax_rates' => $tax_rates_2 ,
    'price'     => Utilities::random_price(),
];
$user_data_3 = [

    'vendor'    => "Canadian Tire",
    'item'      => "Oil Change",
    'category'  => "misc",
    'tax_rates' => $tax_rates_3 ,
    'price'     => Utilities::random_price(),
];

$test_input_1 = new Line_Item(uniqid("", false), "test-vendor-1",
    "test-item-1","Kittens", $tax_rates_1,Utilities::random_price(), $date);


$test_input_1  = LineItemBuilder::getUserData($user_data_1);
$test_input_2 = LineItemBuilder::getUserData($user_data_2);
$test_input_3 = LineItemBuilder::getUserData($user_data_3);
exit();

echo "------------------------" . PHP_EOL;
echo "Initializing receipt...";
echo "\n";
echo "\n";

$receipt = new Receipt(uniqid("", false));

echo "------------------------" . PHP_EOL;
//echo "Initializing line item 1...";
//echo "\n";
//echo "\n";
$receipt->addItem($test_input_1);

//print_r($receipt);

//echo "------------------------------------------------------------------------------------- \n";
//echo "Initializing line item 2...";
//echo "\n";
//echo "\n";
$receipt->addItem($test_input_2);

//print_r($receipt);

//echo "------------------------------------------------------------------------------------- \n";
//echo "Initializing line item 3...";
//echo "\n";
//echo "\n";
$receipt->addItem($test_input_3);

//print_r($receipt);

echo "------------------------------------------------------------------------------------- \n";
$filtered_by_vendor = Filter::filter_by_vendor($receipt, "test-vendor-1");
echo "Here's is the result of vendor filter: ";
echo "\n";
var_dump($filtered_by_vendor->line_items);
echo "\n";
echo "End Vendor filter test.";
echo "\n";
echo "------------------------------------------------------------------------------------- \n";

Filter::clear_filter($filtered_by_vendor);

echo "Here's the result of category filter: ";
echo "\n";
$filtered_by_category = Filter::filter_by_category($receipt, "Bombs");
var_dump($filtered_by_category->line_items);
echo "\n";
echo "End Category filter test.";
echo "------------------------------------------------------------------------------------- \n";
echo "\n";

echo "Here's the result of item name filter: ";
echo "\n";
$filtered_by_name = Filter::filter_by_item_name($receipt, "test-item-2");
var_dump($filtered_by_name->line_items);
echo "\n";
echo "End item name filter test.";
echo "------------------------------------------------------------------------------------- \n";
echo "\n";

echo "------------------------------------------------------------------------------------- \n";
echo "Receipt subtotal: ";
print_r($receipt->subtotal());
echo "\n";
echo "------------------------------------------------------------------------------------- \n";
echo "Receipt taxes: ";
echo "\n";
foreach ($receipt->taxes() as $tax) {
    echo $tax . "\n";
}
echo "\n";
echo "------------------------------------------------------------------------------------- \n";
echo "Receipt final total: ";
echo $receipt->total();
echo "\n";
echo "------------------------------------------------------------------------------------- \n";

//todo test DataBase Store

$host = '';
$dbname = '';
$port = '';
$charset = '';
$username = '';
$password = '';

$data_store = new Database_Store($host = '', $dbname = '', $port = '', $charset = '', $username = '', $password = '');