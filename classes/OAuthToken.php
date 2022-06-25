<?php

class OAuthToken extends DBHandler{
    protected $sqlFilePath = "sql/oauthtoken.json";
    protected $tableName = "Token";
	/**
	 * @var int timestamp when access token will expire.
	 */
	private $expires_at;

	/**
	 * @var string Access token used when making a request.
	 */
	private $access_token;

	/**
	 * @var string Refresh token used to get renewed Access token.
	 */
	private $refresh_token;
	/**
	 * @var string session uuid 
	 */
	private $uuid;

	private function query_for_token($uid){
		$query = "SELECT * from $this->tableName where userId = ?";
		$result = $this->execute_query($query, array($uid), array("i"));
		if($result->num_rows == 0){
			return null;
		}
		$data = $result->fetch_all(MYSQLI_ASSOC);
		$this->access_token = $data[0]['token'];
		$this->refresh_token = $data[0]['refresh'];
		$this->expires_at = $data[0]['expires'];
	}

	public function __construct($expiresIn = null, $accessToken = null, $refreshToken = null, $uid=null) {
		$this->database_setup();
		if($expiresIn != null && $accessToken != null){
			$this->expires_at = time() + $expiresIn;
			$this->access_token = $accessToken;
			$this->refresh_token = $refreshToken;
			
		}
		elseif($uid != null){
			$this->query_for_token($uid);
		}

		$this->uuid = uniqid('php_');
	}

	/**
	 * Gets the access token.
	 *
	 * @return string Access token used when making a request.
	 */
	public function get_access_token() {
		return $this->access_token;
	}

	public function get_uuid(){
		return $this->uuid;
	}

	/**
	 * Gets the refresh token.
	 *
	 * @return string Refresh token used to get renewed Access token.
	 */
	public function get_refresh_token() {
		return $this->refresh_token;
	}

	/**
	 * Get remaining life time of token.
	 *
	 * @return int Total remaining life of access token in seconds.
	 */
	public function get_expires_in() {
		$expires_at = $this->get_expires_at();
		$now = time();
		return $expires_at - $now;
	}

	/**
	 * Get date and time when token expires.
	 *
	 * @return int timestamp when access token will expire.
	 */
	public function get_expires_at() {
		return $this->expires_at;
	}

	public function record_token($uid){
		$query = "SELECT * from $this->tableName where userId = ?";
		$result = $this->execute_query($query, array($uid), array("i"));
		$values = array(time(), $this->expires_at, $this->refresh_token, $this->access_token, $uid);
		$types = array("iissi");
		if($result->num_rows == 0){
			$insert = "INSERT INTO $this->tableName (timestamp, expires, refresh, token, userId) ";
			$insert .= "Values (?, ?, ?, ?, ?);";
			$result = $this->execute_query($insert, $values, $types);
		}else{
			$update = "UPDATE $this->tableName SET timestamp = ?, expires = ?, ";
			$update .= "refresh = ?, token = ? ";
			$update .= "WHERE userId = ?;";
			$result = $this->execute_query($update, $values, $types);
		}
	}
}