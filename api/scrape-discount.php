<?php
// Basic error logging
error_log("API endpoint hit: " . date('Y-m-d H:i:s'));

// Set headers
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);
require_once __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// todo: scrape for discount 
try {

    // Log the raw input
    error_log("Raw input: " . file_get_contents('php://input'));

    // Get and validate the POST data
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    if (!$data || !isset($data['url'])) {
        throw new Exception('Invalid request data: URL is required');
    }

    function scrapeDiscount($url)
    {
        // Replace localhost with the web service name from docker-compose

        try {
            $client = new Client([
                'verify' => false,  // Disable SSL verification for localhost
                'timeout' => 10,    // Set timeout
                'connect_timeout' => 5
            ]);


            error_log("Attempting to fetch URL: " . $url);

            $response = $client->get($url);
            $html = (string) $response->getBody();
            // error_log("HTML: " . $html);
            // Use a DOM parser to find discount elements
            $dom = new DOMDocument();
            @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $xpath = new DOMXPath($dom);

            // Look specifically for the discount label
            $discountLabels = $xpath->query("//label[contains(@class, 'ticket-discount-label')]");
            error_log("Number of discount labels found: " . $discountLabels->length);

            $highestDiscount = 0;
            foreach ($discountLabels as $label) {
                // Extract number from strings like "- 50 %"
                $discount = (int) preg_replace('/[^0-9]/', '', $label->textContent);
                if ($discount > $highestDiscount) {
                    $highestDiscount = $discount;
                }
            }

            error_log("Found discount: " . $highestDiscount);

            // If we found a discount, also get the discounted price
            if ($highestDiscount > 0) {

                return [
                    'success' => true,
                    'discount' => $highestDiscount,

                ];
            }

            return [
                'success' => true,
                'discount' => null,

            ];

        } catch (RequestException $e) {
            error_log("Guzzle error for URL {$url}: " . $e->getMessage());
            throw new Exception("Failed to fetch URL: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("General error for URL {$url}: " . $e->getMessage());
            throw $e;
        }
    }

    $result = scrapeDiscount($data['url']);
    error_log("Success response for URL {$data['url']}: " . json_encode($result));
    echo json_encode($result);

} catch (Exception $e) {
    error_log("Error processing request: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}