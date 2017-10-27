<?php

use \Alexa\Skill_Template;
use GuzzleHttp\Client;

class Bitso_Skill extends Skill_Template {

	private $current_prices;

	public function __construct( $app_id ) {
		$this->text_launch = "Welcome to Bitso skill, You can ask \"What are the current prices?\" ";
		parent::__construct( $app_id );
	}

	public function intent_request() {
		$request = $this->input()->request();
		$response = $this->output()->response();
		$this->fetchPrices();

		switch ( $request->intent()->get_name() ) {
			case 'CurrentIntent':
				$reponse_text = "Current price for Bitcoin is: {$this->current_prices['btc_mxn']} pesos.\n";
				$reponse_text .= "Current price for Ethereum is: {$this->current_prices['eth_mxn']} pesos.\n";
				$reponse_text .= "Current price for Ripple is: {$this->current_prices['xrp_mxn']} pesos.\n";

				$response->output_speech()->set_text( $reponse_text );
				$response->card()->set_title( 'Current Prices' );
				$response->card()->set_text( $reponse_text );
				$response->end_session();

				break;
			case 'CurrencyIntent':
				$currency = $request->intent()->get_slot_value( 'CurrencyName' );
				$price = $this->getPrice( $currency );

				if( $price > 0 ){
					$reponse_text = "Current price for {$currency} is {$price} pesos.";
				}else{
					$reponse_text = "Currency not found.";					
				}

				$response->output_speech()->set_text( $reponse_text );
				$response->card()->set_title( "Current price for {$currency}" );
				$response->card()->set_text( $reponse_text );
				$response->end_session();

				break;
			default:
				$response->output_speech()->set_text( 'I did not understand, ask again' );

				break;
		}
	}

	private function fetchPrices() {
		$this->current_prices = [];
		$client = new Client();
		$body = $client->get('https://api.bitso.com/v3/ticker')->getBody();
		$prices = json_decode($body, true);

		foreach( $prices['payload'] as $price ) {
			if( stristr( $price['book'], '_mxn' ) ) {
				$this->current_prices[$price['book']] = $price['last'];
			}
		}

		$this->log ( $this->current_prices );
	}

	private function getPrice( $currencyName ) {
		$currencyName = strtolower($currencyName);

		switch ($currencyName) {
			case 'bitcoin':
				$book = 'btc_mxn';
				break;
			case 'ripple':
				$book = 'xrp_mxn';
				break;
			case 'ethereum':
				$book = 'eth_mxn';
				break;			
			default:
				$book = '';
				break;
		}

		if($book){
			return $this->current_prices[$book];
		}

		return -1;
	}
}
