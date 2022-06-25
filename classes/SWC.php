<?php

define('OAUTH_ENDPOINT_AUTH', 'https://www.swcombine.com/ws/oauth2/auth/');
define('OAUTH_ENDPOINT_TOKEN', 'https://www.swcombine.com/ws/oauth2/token/');

class SWC extends DBHandler {
    private $token;
    private $redirectUrl;
    private $apiKey;
    private $apiSecret;
    private $accessType = 'offline';

    private function api_settings() {
        $path = "../" . $this->settingsPath;
        if (!file_exists($path)){
            $path = $this->settingsPath;
            if (!file_exists($path)){
                throw new Exception("Settings file not found");
            }
        }
        $file = fopen($path, "r") or die("Unable to open file!");
        $data = fread($file,filesize($path));
        $jsonData = json_decode($data);
        $this->apiKey = $jsonData->api->key;
        $this->apiSecret = $jsonData->api->secret;
        $this->redirectUrl = $jsonData->api->redirect_url;
        fclose($file);
    }

    public function attempt_authorize(array $scopes, $renew = true, $state = null) {
        $url = OAUTH_ENDPOINT_AUTH.'?response_type=code'.
                        '&client_id='.$this->apiKey.
                        '&scope='.implode(' ', $scopes).
                        '&redirect_uri='.$this->redirectUrl.
                        '&state='.urlencode($state).
                        '&access_type='.$this->accessType;
        if($renew) {
            $url .= '&renew_previously_granted=yes';
        }
        echo var_dump($this);
        header('Accept: '.ContentTypes::JSON);
        header('location: '.$url);
    }

    public function request_token($code, $method=RequestMethods::Post) {
        $values =   array
                        (
                            "code" => $code
                            ,"client_id" => $this->apiKey
                            ,"client_secret" => $this->apiSecret
                            ,"redirect_uri" => $this->redirectUrl
                            ,"grant_type" => GrantTypes::AuthorizationCode
                            ,"access_type" => $this->accessType
                        );

        $response = $this->make_request(OAUTH_ENDPOINT_TOKEN, $method, $values);

        if (isset($response->error)) {
            throw new SWCombineWSException('Failed to get token. Reason: '.$response->error, $response->error);
        }

        $this->token = new OAuthToken($response->expires_in, $response->access_token, isset($response->refresh_token) ? $response->refresh_token : null);
        return $this->token;
    }

    public function get_token(){
        return $this->token;
    }

    private static function make_request($url, $method, array $values) {
        $body = http_build_query($values);
        $headers = array('accept: '.ContentTypes::JSON);

        // open connection
        $ch = curl_init();
    
        if ($method == RequestMethods::Get) {
                // values should be query parameters so update uri
                $url .= '?'.$body;
                $headers[] = 'Content-type: '.ContentTypes::UTF8;
        } else {
                $headers[] = 'Content-type: '.ContentTypes::FormData;
                $headers[] = 'Content-length: '.strlen($body);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        // set url and headers
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        // set the method
        switch ($method) {
            case RequestMethods::Post:
                curl_setopt($ch, CURLOPT_POST, 1);
                break;
    
            case RequestMethods::Put:
                curl_setopt($ch, CURLOPT_PUT, 1);
                break;
    
            case RequestMethods::Delete:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        
        $response = curl_exec($ch);
        $httpRet = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpRet != 200){
            throw new SWCombineWSException("Request failed with error: $httpRet", $httpRet);
        }
        // close connection
        curl_close($ch);
    
        return (object)json_decode($response);
    }

    public function check_authentication(){
        $token = $this->token->get_access_token();
        $url = "https://www.swcombine.com/ws/v2.0/character";
        $values = array("access_token" => $token);
        try{
            $data = $this->make_request($url, "GET", $values);
            return $data;
        }
        catch(SWCombineWSException $e){
            //you should really log this
            return null;
        }
    }

    public function __construct() {
        $this->api_settings();
    }
}