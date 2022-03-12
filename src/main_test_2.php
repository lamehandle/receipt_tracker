<?php
namespace app;
use DateTime;

require_once '../vendor/composer/autoload_real.php';
require_once('Purchase_Record.php');
require_once('Receipt.php');
require_once('Line_Item.php');
require_once('Utilities.php');
require_once('Filter.php');
require_once('Report.php');
require_once ('Database_Store.php');

$tax_rates_1 = ["GST"=> 0.01, "PST"=> 0.01 ];
$tax_rates_2 = ["GST"=> 0.20];
$tax_rates_3 = ["PST"=> 0.07, "VAT" => 0.1];

$date = new DateTime();

$host       = 'localhost';
$dbname     = 'receipts_tracker';
$port       = '80';
$charset    = 'utf8mb4';
$username   = 'root';
$password   = 'admin';

$dsn = "mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=$this->charset;";


$dataBase = new Database_Store($host, $dbname, $username, $password, $port, $charset, $options);
$dataBase->connect($dsn, $username, $password, $this->options); //todo re-write to conform to required info
print_r($dataBase);
 exit();


echo "\n";
echo "file is powering up..." . PHP_EOL;
echo "-----------------------------------------------------" . PHP_EOL;

echo "Creating line items...";
echo "\n";


$test_input_1 = new Line_Item(uniqid("", false), "test-vendor-1",
    "test-item-1","Kittens", $tax_rates_1,Utilities::random_price(), $date);

$test_input_2 = new Line_Item(uniqid("", false), "test-vendor-2",
    "test-item-2","Lasers", $tax_rates_2,Utilities::random_price(), $date);

$test_input_3 = new Line_Item(uniqid("", false), "test-vendor-3",
    "test-item-3","Bombs", $tax_rates_3,Utilities::random_price(), $date);


echo "-----------------------------------------------------"  . PHP_EOL;
echo "Initializing receipt..." . PHP_EOL;
echo "\n";

$receipt = new Receipt(uniqid("", false));


$receipt->addItem($test_input_1);

$receipt->addItem($test_input_2);

$receipt->addItem($test_input_3);


echo "-----------------------------------------------------" . PHP_EOL;
$filtered_by_vendor = Filter::filter_by_vendor($receipt, "test-vendor-1");
echo "Here's is the result of vendor filter: ";
echo "\n";
var_dump($filtered_by_vendor->line_items);
echo "\n";
echo "End Vendor filter test.";
echo "\n";
echo "-----------------------------------------------------" . PHP_EOL;

Filter::clear_filter($filtered_by_vendor);

echo "Here's the result of category filter: " . PHP_EOL;
echo "\n";
$filtered_by_category = Filter::filter_by_category($receipt, "Bombs");
var_dump($filtered_by_category->line_items);
echo "\n";
echo "End Category filter test.";
echo "-----------------------------------------------------" . PHP_EOL;
echo "\n";

echo "Here's the result of item name filter: ";
echo "\n";
$filtered_by_name = Filter::filter_by_item_name($receipt, "test-item-2");
var_dump($filtered_by_name->line_items);
echo "\n";
echo "End item name filter test.";
echo "----------------------------------------------------- \n";
echo "\n";

echo "----------------------------------------------------- \n";
echo "Receipt subtotal: ";
print_r($receipt->subtotal());
echo "\n";
echo "----------------------------------------------------- \n";
echo "Receipt taxes: ";
echo "\n";
foreach ($receipt->taxes() as $tax) {
    echo $tax . "\n";
}
echo "\n";
echo "----------------------------------------------------- \n";
echo "Receipt final total: ";
echo $receipt->total();
echo "\n";
echo "----------------------------------------------------- \n";

