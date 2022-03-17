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
require_once ('Database_Store.php');

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
echo "Creating line items...". PHP_EOL;
echo "------------------------" . PHP_EOL;

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
    'category'  => "Automotive",
    'tax_rates' => $tax_rates_3 ,
    'price'     => Utilities::random_price(),
];


$test_input_1  = LineItemBuilder::getUserData($user_data_1);
$test_input_2 = LineItemBuilder::getUserData($user_data_2);
$test_input_3 = LineItemBuilder::getUserData($user_data_3);


echo "------------------------" . PHP_EOL;
echo "Initializing receipt...";
echo "\n";

$receipt = new Receipt(uniqid("", false));

echo "------------------------" . PHP_EOL;
echo "Initializing line item 1...". PHP_EOL;
echo "\n";

$receipt->addItem($test_input_1);

//print_r($receipt);

echo "------------------------" . PHP_EOL;
//echo "Initializing line item 2...". PHP_EOL;
//echo "\n";

$receipt->addItem($test_input_2);

//print_r($receipt);

//echo "---------------------------------". PHP_EOL;
//echo "Initializing line item 3...". PHP_EOL;
//echo "\n";

$receipt->addItem($test_input_3);

print_r($receipt);

//echo "---------------------------------". PHP_EOL;
//$filtered_by_vendor = Filter::filter_by_vendor($receipt, "test-vendor-1");
//echo "Here's is the result of vendor filter: ";
//echo "\n";
//var_dump($filtered_by_vendor->line_items);
//echo "\n";
//echo "End Vendor filter test.";
//echo "\n";
//echo "---------------------------------". PHP_EOL;
//
//Filter::clear_filter($filtered_by_vendor);
//
//echo "Here's the result of category filter: ";
//echo "\n";
//$filtered_by_category = Filter::filter_by_category($receipt, "Bombs");
//var_dump($filtered_by_category->line_items);
//echo "\n";
//echo "End Category filter test.";
//echo "---------------------------------". PHP_EOL;
//echo "\n";
//
//echo "Here's the result of item name filter: ";
//echo "\n";
//$filtered_by_name = Filter::filter_by_item_name($receipt, "test-item-2");
//var_dump($filtered_by_name->line_items);
//echo "\n";
//echo "End item name filter test.";
//echo "---------------------------------". PHP_EOL;
//echo "\n";

echo "---------------------------------". PHP_EOL;
echo "Receipt subtotal: ";
print_r($receipt->subtotal());
echo "\n";
echo "---------------------------------". PHP_EOL;
echo "Receipt taxes: ";
echo "\n";
foreach ($receipt->taxes() as $tax) {
    echo $tax . "\n";
}
echo "\n";
echo "---------------------------------". PHP_EOL;
echo "Receipt final total: ";
echo $receipt->total();
echo "\n";
echo "---------------------------------". PHP_EOL;

