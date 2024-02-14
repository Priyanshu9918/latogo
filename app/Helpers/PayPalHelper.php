<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Session;

class PayPalHelper
{
    private $_http = null;
    private $_apiUrl = null;
    private $_token = null;

    public function __construct()
    {
        $env = Config::get('paypal.PAYPAL_ENVIRONMENT');
        $this->_http = new HttpHelper(); // Make sure HttpHelper is in the correct namespace
        $this->_apiUrl = Config::get('paypal.PAYPAL_ENDPOINTS.' . $env);
    }

    private function _setDefaultHeaders()
    {
        // Add your default headers if needed
        $this->_http->addHeader("PayPal-Partner-Attribution-Id: " . Config::get('paypal.SBN_CODE'));
    }

    private function _createApiUrl($resource)
    {
        // Implementation for creating API URL
        if ($resource == 'oauth2/token') {
            return $this->_apiUrl . "/v1/" . $resource;
        } else {
            return $this->_apiUrl . "/" . Config::get('paypal.PAYPAL_REST_VERSION') . "/" . $resource;
        }
    }

    private function _getToken()
    {
        // Implementation for obtaining access token
        $env = Config::get('paypal.PAYPAL_ENVIRONMENT');
        $client_id = Config::get('paypal.PAYPAL_CREDENTIALS.' . $env . '.client_id');
        $client_secret = Config::get('paypal.PAYPAL_CREDENTIALS.' . $env . '.client_secret');

        $this->_http->resetHelper();
        $this->_http->setUrl($this->_createApiUrl("oauth2/token"));
        $this->_http->setAuthentication($client_id . ":" . $client_secret);
        $this->_http->setBody("grant_type=client_credentials");

        $returnData = $this->_http->sendRequest();
        $this->_token = $returnData['access_token'];
    }

    private function _createOrder($postData)
    {
        // Implementation for creating an order
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders"));
        $this->_http->setBody($postData);

        return $this->_http->sendRequest();
    }

    private function _getOrderDetails()
    {
        // Implementation for getting order details
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['order_id']));

        return $this->_http->sendRequest();
    }

    private function _patchOrder($postData)
    {
        // Implementation for patching an order
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['order_id']));
        $this->_http->setPatchBody($postData);

        return $this->_http->sendRequest();
    }

    private function _captureOrder()
    {
        // Implementation for capturing an order
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['order_id'] . "/capture"));
        $postData = '{}';
        $this->_http->setBody($postData);

        return $this->_http->sendRequest();
    }

    private function _createSubscription($subscriptionData)
    {
        // Implementation for creating a subscription
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("billing/subscriptions"));
        $this->_http->setBody($subscriptionData);
		// dd($this->_http);
        $response = $this->_http->sendRequest();
		// dd($response);
        return $response;
    }

    public function orderCreate($postData)
    {
        // Implementation for handling order creation
        if ($this->_token === null) {
            $this->_getToken();
        }

        $returnData = $this->_createOrder($postData);
        $_SESSION['order_id'] = $returnData['id'];

        return array(
            "ack" => true,
            "data" => array(
                "id" => $returnData['id']
            )
        );
    }

    public function orderGet()
    {
        // Implementation for handling order retrieval
        if ($this->_token === null) {
            $this->_getToken();
        }

        $returnData = $this->_getOrderDetails();

        return array(
            "ack" => true,
            "data" => $returnData
        );
    }

    public function orderPatch($postData)
    {
        // Implementation for handling order patching
        if ($this->_token === null) { 
            $this->_getToken();
        }

        $returnData = $this->_patchOrder($postData);

        return array(
            "ack" => true,
            "data" => $returnData
        );
    }

    public function recurringPayment($subscriptionData)
    {
        // Implementation for handling recurring payments
        if ($this->_token === null) {
            $this->_getToken();
        }
		$requestId = 'REQ-' . time() . '-' . uniqid();
        $accessToken = $this->_token;
		 // Replace with your actual access token

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
            'PayPal-Request-Id' => $requestId,
        ])->post($this->_apiUrl.'/v1/catalogs/products', [
            'name' => 'Video Streaming Service',
            'description' => 'A video streaming service',
            'type' => 'SERVICE',
            'category' => 'SOFTWARE',
            'image_url' => 'https://example.com/streaming.jpg',
            'home_url' => 'https://example.com/home',
        ]);

        // $accessToken = 'your_access_token'; // Replace with your actual access token
        // $requestId = 'your_request_id'; // Replace with your actual request ID
        $amount = DB::table('orders')->where('id', $subscriptionData)->first();
        $response1 = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
            'PayPal-Request-Id' => $requestId,
        ])->post($this->_apiUrl.'/v1/billing/plans', [
            'product_id' => $response['id'],
            'name' => 'Basic Plan',
            'description' => 'Basic plan',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => 1,
                    ],
                    'tenure_type' => 'TRIAL',
                    'sequence' => 1,
                    'total_cycles' => 1,
                ],
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => 1,
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 2,
                    'total_cycles' => 12,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => $amount->total_price,
                            'currency_code' => 'USD',
                        ],
                    ],
                ],
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee' => [
                    'value' => $amount->total_price,
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 3,
            ],
            'taxes' => [
                'percentage' => '0',
                'inclusive' => false,
            ],
        ]);

		$data1 = $response1['id'];

        $startTime = now()->modify('1 day')->toIso8601String();
		// dd($startTime);
        Session::put('data',$response1['id']);

        $subscriptionData11 = [
            'plan_id' => $response1['id'],
            'start_time' => $startTime,
        ];

        $returnData = $this->_createSubscription($subscriptionData11);
		// dd($returnData);
        $_SESSION['order_id'] = $returnData['id'];

        return array(
            "ack" => true,
            "data" => array(
                "id" => $returnData['id'],
                "plan_id" => $data1
            )
        );
    }

    public function orderCapture()
    {
        // Implementation for handling order capture
        if ($this->_token === null) {
            $this->_getToken();
        }

        $returnData = $this->_captureOrder();
		// dd($returnData);
        return array(
            "ack" => true,
            "data" => $returnData
        );
    }
}
