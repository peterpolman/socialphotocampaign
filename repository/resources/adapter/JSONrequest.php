<?php 


/**
 * JSON -> OpenSSL handler
 * @author Guido
 */
WE::include_adapter('JSONrequestObject');
WE::include_adapter('JSONresponseObject');
WE::include_adapter('OpenSSL');
class JSONrequest {

	/**
	 * Handle a JSON request with the request en response objects
	 * @param $json JSONrequestObject
	 * @return JSONresponseObject
	 */
	public static function handleRequest(JSONrequestObject $json) {
		$preparedRequest = self::prepareRequest($json->getJsonArray());		// Prepare the request and get a prepared request
		$response = self::getResponse($preparedRequest);					// Get the response
		$decodedResponse = self::decodeResponse($response);					// Decode the response to a valid JSONresponseObject
		return $decodedResponse;											// Return the JSONresponseObject
	}
	
	/**
	 * Decode the Json response
	 * @param $response string
	 * @return JSONresponseObject
	 */
	private static function decodeResponse($response) {
		$response = self::validJson($response);								// Valid JSON check
		if ($response == false) {
			throw new Exception("Response is not valid JSON!");
		}
																			// OpenSSL based decode the data from the JSON response
		$response = OpenSSL::decrypt($response['result'], $response['key'], $response['signature'], Config::get('communication','clientprivate'), Config::get('communication','centralpublic'));
		$response = self::validJson($response);								// Valid JSON check
		if ($response == false) {
			throw new Exception("Decrypted response is not valid JSON!");
		}
		
		$responseObj = new JSONresponseObject($response);					// Build a JSON response object by the validated response
		
		return $responseObj;												// Return the JSON response object
	}
	
	/**
	 * Send the request and get the response
	 * @param $preparedRequest array
	 * @return string
	 */
	private static function getResponse($preparedRequest) {
																			// Build a post request array with the prepared request
		$options = 	array('http' => array(	'method'  => 'POST',
											'header'=>'Content-type: application/x-www-form-urlencoded',
											'content' => http_build_query($preparedRequest)
									)
					);
		$context  = stream_context_create($options);						// Create a stream context
		$result = file_get_contents(Config::get('communication','targeturl'), false, $context);	//Handle the postrequest
		return $result;														// Return the filestream
	}
	
	/**
	 * Prepare a JSON request
	 * @param $json array (JSON Array)
	 * @return array
	 */
	private static function prepareRequest($json) {
		$jsonTest = self::validJson($json);									// Valid JSON check
		if ($jsonTest == false) {
			throw new Exception("Request is not valid JSON!");
		}
																			// OpenSSL based encoding the data from the JSON request
		list($json,$key,$signature) = OpenSSL::encrypt($json, Config::get('communication','centralpublic'), Config::get('communication','clientprivate'));
		
		$data = array(														// Create a new JSON request array (NOT object)
				'json' => $json,
				'key' => $key,
				'signature'=>$signature,
				'clientsystem'=>Config::get('communication','clientid')
		);
		
		return $data;														// Return JSON request array
	}
	
	/**
	 * Check if the json string is valid by decoding it
	 * @param $json string
	 * @return array|false
	 */
	private static function validJson($json) {
		$json = json_decode($json,true);									// Try to decode a json string
		if ( !$json ) {														// If it fails
			return false;													// Return false
		}
		return $json;														// Return the decoded json string
	}
}


?>