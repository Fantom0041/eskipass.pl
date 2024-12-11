<?php
// Basic error logging
error_log("API endpoint hit: " . date('Y-m-d H:i:s'));

// Set headers
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
use GuzzleHttp\Client;
    
// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 0 to ensure errors are returned as JSON

// Check if vendor/autoload.php exists
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Composer dependencies not installed'
    ]);
    exit;
}

try {
    require_once __DIR__ . '/../vendor/autoload.php';
    
 
    // Log the raw input
    error_log("Raw input: " . file_get_contents('php://input'));
    
    // Get and validate the POST data
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);
    
    if (!$data || !isset($data['url'])) {
        throw new Exception('Invalid request data: URL is required');
    }
    
    function scrapeDiscount($url) {
        $client = new Client();
        $response = $client->get($url);
        $html = (string) $response->getBody();
        
        // Use a DOM parser to find discount elements
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        
        // Look specifically for the discount label
        $discountLabels = $xpath->query("//label[contains(@class, 'label-primary')]");
        
        $highestDiscount = 0;
        foreach ($discountLabels as $label) {
            // Extract number from strings like "- 50 %"
            $discount = (int) preg_replace('/[^0-9]/', '', $label->textContent);
            if ($discount > $highestDiscount) {
                $highestDiscount = $discount;
            }
        }
        
        // If we found a discount, also get the discounted price
        if ($highestDiscount > 0) {
            $priceElements = $xpath->query("//span[@class='shop-item-price-discount']//span[contains(@id, 'shop-ticket-price')]");
            $lowestPrice = PHP_FLOAT_MAX;
            
            foreach ($priceElements as $element) {
                // Extract number from strings like "70.00 zł"
                $price = floatval(preg_replace('/[^0-9.]/', '', $element->textContent));
                if ($price > 0 && $price < $lowestPrice) {
                    $lowestPrice = $price;
                }
            }
            
            return [
                'success' => true,
                'discount' => $highestDiscount,
                'price' => $lowestPrice !== PHP_FLOAT_MAX ? $lowestPrice : null
            ];
        }
        
        return [
            'success' => true,
            'discount' => null,
            'price' => null
        ];
    }

    echo json_encode(scrapeDiscount($data['url']));

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 