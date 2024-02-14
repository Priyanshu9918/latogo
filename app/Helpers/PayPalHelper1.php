<?php
namespace App\Helpers;
session_start();
// include_once('HttpHelper1.php');
use App\Helpers\HttpHelper1;
use Illuminate\Support\Facades\Config;

/**
	*	PayPal helper class for REST API requests.
	*
*/

class PayPalHelper1 {

	private $_http = null;
	private $_apiUrl = null;
	private $_token = null;

	/**
		* 	Class constructor.
		*
	*/
	public function __construct() {
		$env = Config::get('paypal1.PAYPAL_ENVIRONMENT');
		$this->_http = new HttpHelper1;
		$this->_apiUrl = Config::get('paypal1.PAYPAL_ENDPOINTS.'.$env);
	}

	/**
		* 	Set PayPal default header for the curl instance.
		*
		* 	@return void
	*/
	private function _setDefaultHeaders() {
		$this->_http->addHeader("PayPal-Partner-Attribution-Id: " . Config::get('paypal1.SBN_CODE'));
	}

	/**
		* 	Create the PayPal REST endpoint url.
		*
		*	Use the configurations and 1combine resources to create the endpoint.
		*
        *	@param string $resource Url to be called using curl
		* 	@return string REST API url depending on environment.
	*/
	private function _createApiUrl($resource) {
		if($resource == 'oauth2/token')
			return $this->_apiUrl . "/v1/" . $resource;
		else
			return $this->_apiUrl . "/" . Config::get('paypal1.PAYPAL_REST_VERSION') . "/" . $resource;
	}

	/**
		* 	Request for PayPal REST oath bearer token.
		*
		* 	Reset curl helper.
		*	Set default PayPal headers.
		*	Set curl url.
		*	Set curl credentials.
		*	Set curl body.
		*	Set class token attribute with bearer token.
		*
		* 	@return void
	*/
	private function _getToken() {
		$env = Config::get('paypal1.PAYPAL_ENVIRONMENT');
		$client_id = Config::get('paypal1.PAYPAL_CREDENTIALS.'.$env.'.client_id');
		$client_secret = Config::get('paypal1.PAYPAL_CREDENTIALS.'.$env.'.client_secret');
		$this->_http->resetHelper();
		//$this->_setDefaultHeaders();
		$this->_http->setUrl($this->_createApiUrl("oauth2/token"));
		//$this->_http->setAuthentication(PAYPAL_CREDENTIALS[PAYPAL_ENVIRONMENT]['client_id'] . ":" . PAYPAL_CREDENTIALS[PAYPAL_ENVIRONMENT]['client_secret']);
		$this->_http->setAuthentication($client_id . ":" . $client_secret);
		$this->_http->setBody("grant_type=client_credentials");
		$returnData = $this->_http->sendRequest();
		$this->_token = $returnData['access_token'];
	}

	/**
		* 	Actual call to curl helper to create an order using PayPal REST APIs.
		*
		* 	Reset curl helper.
		*	Set default PayPal headers.
		* 	Set API call specific headers.
		*	Set curl url.
		*	Set curl body.
		*
        *	@param array $postData Url to be called using curl
		* 	@return array PayPal REST create response
	*/
	private function _createOrder($postData) {
		$this->_http->resetHelper();
		//$this->_setDefaultHeaders();
		$this->_http->addHeader("Content-Type: application/json");
		$this->_http->addHeader("Authorization: Bearer " . $this->_token);
		$this->_http->setUrl($this->_createApiUrl("checkout/orders"));
		$this->_http->setBody($postData);

		return $this->_http->sendRequest();
	}

    /**
     * 	Actual call to curl helper to get a payment using PayPal REST APIs.
     *
     * 	Reset curl helper.
     *	Set default PayPal headers.
     * 	Set API call specific headers.
     *	Set curl url.
     *
     * 	@param array $postData Url to be called using curl
     * 	@return array PayPal REST execute response
     */
    private function _getOrderDetails() {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['order_id']));
        return $this->_http->sendRequest();
	}

	/**
		* 	Actual call to curl helper to execute a payment using PayPal REST APIs.
		*
		* 	Reset curl helper.
		*	Set default PayPal headers.
		* 	Set API call specific headers.
		*	Set curl url.
		*	Set curl body.
		*
        *	@param array $postData Url to be called using curl
		* 	@return array PayPal REST execute response
	*/
	private function _patchOrder($postData) {
		$this->_http->resetHelper();
		$this->_setDefaultHeaders();
		$this->_http->addHeader("Content-Type: application/json");
		$this->_http->addHeader("Authorization: Bearer " . $this->_token);
		$this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['order_id']));
		$this->_http->setPatchBody($postData);
		return $this->_http->sendRequest();
	}

	/**
		* 	Actual call to curl helper to capture an order using PayPal REST APIs.
		*
		* 	Reset curl helper.
		*	Set default PayPal headers.
		* 	Set API call specific headers.
		*	Set curl url.
		*	Set curl body.
		*
        *	@param array $postData Url to be called using curl
		* 	@return array PayPal REST capture response
	*/
	private function _captureOrder() {
		$this->_http->resetHelper();
		$this->_setDefaultHeaders();
		$this->_http->addHeader("Content-Type: application/json");
		$this->_http->addHeader("Authorization: Bearer " . $this->_token);
		$this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['order_id'] . "/capture"));
		$postData='{}';
		$this->_http->setBody($postData);
		//unset($_SESSION['order_id']);
		return $this->_http->sendRequest();
	}

	/**
		* 	Call private order create class function to forward curl request to helper.
		*
		* 	Check for bearer token.
		*	Call internal REST create order function.
		*
        *	@param array $postData Url to be called using curl
		* 	@return array Formatted API response
	*/
	public function orderCreate($postData) {
		if($this->_token === null) {
			$this->_getToken();
		}

		$returnData = $this->_createOrder($postData);
		// dd($returnData);
		$_SESSION['order_id'] = $returnData['id'];
		return array(
			"ack" => true,
			"data" => array(
				"id" => $returnData['id']
			)
		);
	}

    /**
     * 	Call private payment get class function to forward curl request to helper.
     *
     * 	Check for bearer token.
     *	Call internal REST get order details function.
     *
     *  @param array $postData Url to be called using curl
     * 	@return array Formatted API response
     */
    public function orderGet() {
        if($this->_token === null) {
            $this->_getToken();
        }
        $returnData = $this->_getOrderDetails();
        return array(
            "ack" => true,
            "data" => $returnData
        );
	}

	/**
		* 	Call private patch order class function to forward curl request to helper.
		*
		* 	Check for bearer token.
		*	Call internal REST patch order function.
		*
        *   @param array $postData Url to be called using curl
		* 	@return array Formatted API response
	*/
	public function orderPatch($postData) {
		if($this->_token === null) {
			$this->_getToken();
		}
		$returnData = $this->_patchOrder($postData);
		return array(
			"ack" => true,
			"data" => $returnData
		);
	}

	/**
		* 	Call private capture order class function to forward curl request to helper.
		*
		* 	Check for bearer token.
		*	Call internal REST capture order function.
		*
        *   @param array $postData Url to be called using curl
		* 	@return array Formatted API response
	*/
	public function orderCapture() {
		if($this->_token === null) {
			$this->_getToken();
		}
		$returnData = $this->_captureOrder();
		//var_dump($returnData);
		return array(
			"ack" => true,
			"data" => $returnData
		);
	}

}
