<?php
/**
 * Session handler class to manage the variables with session.
 * @author Mahendra
 *
 *
 * @example
 * <code>
 * include_once('session.php');
 *$session = Session::getInstance();
 *$session->start();
 *$session->set('name','MMS_Team');
 *echo $session->get('name');
 *echo "<br>";
 *echo $session->isRegistered('name');
 * </code>
 */

class Session {
	/**
	 * Declaration instance
	 * @var string
	 */
	private static $instance = null;

	/**
	 * Create the singlton instance of same class
	 * @param void
	 * @return object instance of this class
	 * @access public
	 */
	public static function getInstance($name = 'PHPSESSID', $id = null){
		if(null === self::$instance){
			self::$instance = new self($name, $id);
		}
		return self::$instance;
	}

	/**
	 * Magic constructor
	 * @param string
	 * @param string
	 * @return void
	 * @access private
	 */
	private function __construct($name = 'PHPSESSID', $id = null){
		if ($name != 'PHPSESSID') {
			$this->name($name);
		}

		if (!is_null($id)) {
			$this->id($id);
		}
	}

	/**
	 * @desc : start the session
	 * @param1 : not requried
	 * @return : blank
	 * @access public
	 */
	public function start(){
		if (!isset($_SESSION['tmobi'])) {
			session_start();
			//die('come here');

		}
	}

	/**
	 * Write session data and end session
	 * @param void
	 * @return void
	 * @access public
	 */
	public function pause(){
		session_write_close();
	}

	/**
	 * Unset and destroy all the session varibales
	 * @param void
	 * @return void
	 * @access public
	 */
	public function destroy(){
		session_unset();
		$id = $this->getId();
		if (!empty($id)) {
			session_destroy();
		}
	}

	/**
	 * Set or get session name
	 * @param string
	 * @return string
	 */
	public function name($name = '') {
		if (!empty($name)) {
			return session_name($name);
		}
		else {
			return session_name();
		}
	}

	/**
	 * Returns the current session Id
	 * @param void
	 * @return string
	 * @access public
	 */
	public function getId() {
		return session_id();
	}

	/**
	 * Set session id
	 * @param string
	 * @return boid
	 */
	public function setId($id) {
		session_id($id);
	}

	/**
	 * Check wherther a varibale is registered in session or not
	 * @param string
	 * @return boolean
	 * @access public
	 */
	public function isRegistered($name) {
		return isset($_SESSION['tmobi'][$name]);
	}

	/**
	 * Unregister the varibale in session.
	 * @param string
	 * @return void
	 * @access public
	 */
	public function unregister($name){
		if ($this->isRegistered($name)) {
			unset($_SESSION['tmobi'][$name]);
		}
	}

	/**
	 * Return the value of session varibale
	 * @param string
	 * @param mixed
	 * @return mixed
	 * @access public
	 */
	public function get($name, $default = '') {
		if ( $this->isRegistered($name) ) {
			return $_SESSION['tmobi'][$name];
		} else {
			return $default;
		}
	}

	/**
	 * Set the value into session
	 * @param string
	 * @param string
	 * @return void
	 * @access public
	 */
	public function set($name, $value){
		$_SESSION['tmobi'][$name] = $value;
	}
	

}
?>