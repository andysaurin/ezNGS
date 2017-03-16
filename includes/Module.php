<?php

/**
* NQ_Module
*
* @package Framework
* @filesource
*/

/**
* NQ_Module
*
* The base module class. All applications will extends from this class. This
* means each module will, by default, have an open DB connection and an
* open log file to write to. Also, it's a good place to put functions,
* variables, etc. that all modules need.
*
* @package Framework
*/


abstract class NQ_Module extends NQ_Object_Web
{
	// {{{ properties
	/**
	* $presenter
	*
	* Used in NQ_Presenter::factory() to determine which presentation (view)
	* class should be used for the module.
	*
	* @var string $presenter
	* @see NQ_Presenter, NQ_Presenter_common, NQ_Presenter_smarty
	*/
	public $presenter;

	/**
	* $data
	*
	* Data set by the module that will eventually be passed to the view.
	*
	* @var mixed $data Module data
	* @see NQ_Module::set(), NQ_Module::getData()
	*/
	protected $data = array();
	/**
	* $name
	*
	* @var string $name Name of module class
	*/
	public $name;

	/**
	* $tplFile
	*
	* @var string $tplFile Name of template file
	* @see NQ_Presenter_smarty
	*/
	public $tplFile;

	/**
	* $moduleName
	*
	* @var string $moduleName Name of requested module
	* @see NQ_Presenter_smarty
	*/
	public $moduleName = null;

	/**
	* $pageTemplateFile
	*
	* @var string $pageTemplateFile Name of outer page template
	*/
	public $pageTemplateFile = null;
	// }}}
	// {{{ __construct()
	/**
	* __construct
	*
	*/
	public function __construct()
	{
		parent::__construct();

		if (PRESENTER == 'debug') {
			$this->presenter = SYSTEM_PRESENTER;
			$this->log->log('## DEBUG MODE START (' . _ID . ')##');
		} else {
			$this->presenter = PRESENTER; // smarty/rest
		}
		if ( ( (isset($_GET['ajax']) && $_GET['ajax']==1) || (isset($_GET['body']) && $_GET['body']==1) ) && !defined('MO_BODYONLY')) //ajax(y) call - show only body contents
			define('MO_BODYONLY', 1);

		if ( isset($_GET['nosidebar']) && $_GET['nosidebar'] == 1 ) {
			define('MO_NOSIDEBAR', 1);
		}
		$this->name = $this->me->getName();
		$this->tplFile = $this->name.'.tpl';
	}
	// }}}
	// {{{ __default()
	/**
	* __default
	*
	* This function is ran by the controller if an event is not specified
	* in the user's request.
	*
	*/
	abstract public function __default();
	// }}}
	// {{{ set($var,$val)
	/**
	* set
	*
	* Set data for your module. This will eventually be passed to the
	* presenter class via NQ_Module::getData().
	*
	* @param string $var Name of variable
	* @param mixed $val Value of variable
	* @return void
	* @see NQ_Module::getData()
	*/
	protected function set($var,$val) {
		$this->data[$var] = $val;
	}
	// }}}
	// {{{ getData()
	/**
	* getData
	*
	* Returns module's data.
	*
	* @return mixed
	* @see NQ_Presenter_common
	*/
	public function getData()
	{
		return $this->data;
	}
	// }}}

	protected function rssSet($var,$val)
	{
		if ($var == 'add_item')
			$this->rss['items'][] = $val;
		else
			$this->rss[$var] = $val;
	}
	public function rssGet()
	{
		return $this->rss;
	}
	// {{{ redirect()
	/**
	* redirect
	*
	* Header-independent Javascript-dependent browser redirect
	*
	* @return Void (Browser redirect)
	*/
	function redirect($location) {
		echo"<script language=\"JavaScript\"><!--
			var time = null
			window.location = '$location'
			//-->
			</script>";
		exit(0);
	}
	// }}}


	// gets user details for an id
	public function get_user_details($user_id)
	{

		if ( $this->user->is_admin != 1 && ( $this->user->id != $user_id ) )
			return array();

		if ( !preg_match("/^[0-9]+$/", $user_id) )
			return false;

		$sql = "SELECT *
			FROM users u
			WHERE u.id = {$user_id} LIMIT 1";
		$user = $this->db->get_row($sql);

		return $user;

	}


	//verifies if the username/email is unique (true) or not (false)
	public function unique_username($username)
	{

		$query = "SELECT count(id) FROM `users` WHERE `username` LIKE '{$username}' OR `email` LIKE '{$username}'";

		if ( $this->db->get_var($query) > 0 )
			return false;
		else
			return true;

	}

	public function verify_captcha($string)
	{

		$url = "https://www.google.com/recaptcha/api/siteverify";
		$data = array(
			'secret' => RECAPTCHA_PRIVATE_KEY,
			'response' => $string,
			'remoteip'=> $_SERVER['REMOTE_ADDR']
			);

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data),
		    ),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { return false; }

		$obj = json_decode( $result );

		if ($obj === FALSE) { return false; }
		return $obj->success;

	}

	public function json_indent($json) {
//do not use this
//if a subject or any variable has [] in it, this fucks up the json encode!
	    $result    = '';
	    $pos       = 0;
	    $strLen    = strlen($json);
	    $indentStr = '  ';
	    $newLine   = "\n";

	    for($i = 0; $i <= $strLen; $i++) {

	        // Grab the next character in the string
	        $char = substr($json, $i, 1);
	        // Grab the two next characters in the string
	        $char2 = substr($json, $i, 2);

	        // If this character is the end of an element,
	        // output a new line and indent the next line
	        if($char == '}' || $char == ']') {
	            $result .= $newLine;
	            $pos --;
	            for ($j=0; $j<$pos; $j++) {
	                $result .= $indentStr;
	            }
	        }

	        // Add the character to the result string
	        $result .= $char;

	        // If the last character was the beginning of an element,
	        // output a new line and indent the next line
	        if ($char2 == ',"' || $char == '{' || $char == '[') {
	            $result .= $newLine;
	            if ($char == '{' || $char == '[') {
	                $pos ++;
	            }
	            for ($j = 0; $j < $pos; $j++) {
	                $result .= $indentStr;
	            }
	        }
	    }

	    return $result;
	}


	// {{{ cleanup()
	/**
	* cleanup
	*
	* cleans up a string, taking into account MS WORD special characters
	*
	* @return string cleaned string
	*/
	public function cleanup($str)
	{
		if (is_array($str)) {
			foreach ($str as $key=>$val) {
				$str[$key] = $this->cleanup($val);
			}
		} else {
			$str = html_entity_decode($str, ENT_QUOTES);
			//$str = stripslashes($str);
			$str = strtr($str, get_html_translation_table(HTML_ENTITIES));
			$str = str_replace( array("\x82", "\x84", "\x85", "\x91", "\x92", "\x93", "\x94", "\x95", "\x96",  "\x97"), array("&#8218;", "&#8222;", "&#8230;", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8226;", "&#8211;", "&#8212;"),$str);
		}
		return $str;
	}
	// }}}
	public function remove_accents($str, $charset='utf-8')
	{
	    $str = htmlentities($str, ENT_NOQUOTES, $charset);

	    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
	    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
	    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caract�res

	    return $str;
	}

	// {{{ nq_encrypt()
	/**
	* nq_encrypt
	*
	* encrypts a string with XXTEA
	*
	*
	* @return string encrypted string
	*/
	public function nq_encrypt($key, $string, $urlencode=false)
	{
		$this->key = $key;
		$tea = new NQ_Tea();
		$tea->setKey($key);
		$encrypted = $tea->encrypt($string);

		return trim(self::base64_url_encode($encrypted));

		if ( $urlencode )
			return urlencode(base64_encode($encrypted));
		else
			return base64_encode($encrypted);

	}
	// }}}
	// {{{ nq_decrypt()
	/**
	* nq_decrypt
	*
	* decrypts a string with XXTEA
	*
	*
	* @return string decrypted string
	*/
	public function nq_decrypt($key, $enc_string, $urldecode=false)
	{
		$tea = new NQ_Tea();
		$tea->setKey($key);

		return $tea->decrypt( self::base64_url_decode( trim( $enc_string ) ) );

		if ( $urldecode )
			return $tea->decrypt(base64_decode(urldecode($enc_string)));
		else
			return $tea->decrypt(base64_decode($enc_string));
/*
    	$iv =  '12345678';
    	$text = trim(NQ_Module::hex2bin($text));
    	return mcrypt_cbc(MCRYPT_BLOWFISH, $key, $text, MCRYPT_DECRYPT, $iv);
*/
	}
	// }}}
	public function base64_url_encode($input) {
		return strtr(base64_encode($input), '+/=', '-_,');
	}

	public function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_,', '+/='));
	}
	public function hex2bin($h)
	{
    	//this function is the opposite of php's bin2hex
   		if (!is_string($h)) return null;
    	$r='';
    	for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
    	return $r;
	}
	// }}}


	public function uuid()
	{
		$uuid = exec("/usr/bin/uuidgen"); //try linux uuidgen first
		if ( !preg_match("/^[a-zA-Z0-9]{8}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{12}$/", $uuid) ) {
			$uuid = random_bytes(8) . "-" . random_bytes(4) . "-" . random_bytes(4) . "-" . random_bytes(4) . "-" . random_bytes(12);
		}
		return $uuid;
	}

	public function expiring_key_create($decrypted_string, $valid_time)
	{
		$nvb = time(); //not valid before this time
		$nva = ( $nvb + $valid_time ); //not valid after this time
		$md5 = md5($nvb.$nva);

		return $this->nq_encrypt( SECRET_KEY, "{$decrypted_string}#{$nvb}#{$nva}#{$md5}", true);

	}

	public function expiring_key_validate($encrypted_string)
	{

		$decrypted_string = $this->nq_decrypt( SECRET_KEY, $encrypted_string, true);

		list($string, $nvb, $nva, $md5) = explode("#", $decrypted_string);

		if ( !$string || !$nvb || !$nva || !$md5 )
			return false;

		$now = time();

		if ( $nvb > $now )
			return false;

		if ( $nva < $now )
			return false;

		if ($md5 != md5($nvb.$nva) )
			return false;

		return $string;

	}

	public function xsrf_create($decrypted_string, $key)
	{

		$session_id = session_id();
		$session_id_md5 = md5(md5($session_id));

		$key_md5 = md5(md5($key));

		$time = time();

		$new_string = "{$key}#{$decrypted_string}#{$session_id_md5}#{$key_md5}#{$time}";

		if ( function_exists( $this->nq_encrypt ) )
			return $this->nq_encrypt( SECRET_KEY, $new_string, true);
		else
			return self::nq_encrypt( SECRET_KEY, $new_string, true);

	}

	public function xsrf_validate($encrypted_string, $decrypted_string, $key)
	{
		$now = time();
		$session_id = session_id();

		$string = $this->nq_decrypt( SECRET_KEY, $encrypted_string, true);

		list($new_key, $new_decrypted_string, $session_id_md5, $key_md5, $time) = explode("#", $string);

		if ( !is_numeric($time) || ($now - $time) > 3600 ) { // request only valid for 1 hr
			return false;
		}

		if ( md5(md5($key)) !=  $key_md5 ) {
			return false;
		}

		if ( md5(md5($session_id)) != $session_id_md5 ) {
			return false;
		}

		if ( $new_decrypted_string != $decrypted_string ) {
			return false;
		}

		if ( $new_key != $key ) {
			return false;
		}

		return true;

	}

	/**
	 * Encryption using blowfish algorithm
	 *
	 * @param   string  original data
	 * @param   string  the secret
	 *
	 * @return  string  the encrypted result
	 *
	 * @access  public
	 *
	 * @author  lem9
	 */
	public function blowfish_encrypt( $secret, $data, $urlencode=false) {
	    $pma_cipher = new NQ_Blowfish;
	    $encrypt = '';
	    for ($i=0; $i<strlen($data); $i+=8) {
	        $block = substr($data, $i, 8);
	        if (strlen($block) < 8) {
	            $block = $this->full_str_pad($block,8,"\0", 1);
	        }
	        $encrypt .= $pma_cipher->encryptBlock($block, $secret);
	    }
	    if ( $urlencode )
			return urlencode(base64_encode($encrypt));
		else
			return base64_encode($encrypt);
	}

	/**
	 * Decryption using blowfish algorithm
	 *
	 * @param   string  encrypted data
	 * @param   string  the secret
	 *
	 * @return  string  original data
	 *
	 * @access  public
	 *
	 * @author  lem9
	 */
	public function blowfish_decrypt( $secret, $encdata, $urldecode=false) {
	    $pma_cipher = new NQ_Blowfish;
	    $decrypt = '';

	    if ( $urldecode )
	    	$data = base64_decode(urldecode($encdata));
	    else
		    $data = base64_decode($encdata);

	    for ($i=0; $i<strlen($data); $i+=8) {
	        $decrypt .= $pma_cipher->decryptBlock(substr($data, $i, 8), $secret);
	    }
	    return trim($decrypt);
	}

	/**
	 * String padding
	 *
	 * @param   string  input string
	 * @param   integer length of the result
	 * @param   string  the filling string
	 * @param   integer padding mode
	 *
	 * @return  string  the padded string
	 *
	 * @access  public
	 */
	public function full_str_pad($input, $pad_length, $pad_string = '', $pad_type = 0) {
	    $str = '';
	    $length = $pad_length - strlen($input);
	    if ($length > 0) { // str_repeat doesn't like negatives
	        if ($pad_type == STR_PAD_RIGHT) { // STR_PAD_RIGHT == 1
	            $str = $input.str_repeat($pad_string, $length);
	        } elseif ($pad_type == STR_PAD_BOTH) { // STR_PAD_BOTH == 2
	            $str = str_repeat($pad_string, floor($length/2));
	            $str .= $input;
	            $str .= str_repeat($pad_string, ceil($length/2));
	        } else { // defaults to STR_PAD_LEFT == 0
	            $str = str_repeat($pad_string, $length).$input;
        }
	    } else { // if $length is negative or zero we don't need to do anything
	        $str = $input;
	    }
	    return $str;
	}

	// {{{ send_mail()
	/**
	 * Send mail using PHPMailer
	 *
	 *	@requirements
	 *		@object $this->mail
	 *		@string	$this->mail->to_email_address		(address where to send mail)
	 *		@string	$this->mail->subject				(message subject)
	 *		@string	$this->mail->body					(mail plain text body)
	 *
	 *	@optional
	 *		@string	$this->mail->body_html				(mail HTML body)
	 *		@string $this->mail->body_plaintext			(mail plain text body to use. If absent, $this->mail->body is used instead)
	 *		@string	$this->mail->from_email				(the login email to use)
	 *		@string	$this->mail->from_email_password	(the login email password to use)
	 *		@string	$this->mail->from_name				(the name to use in the From: header)
	 *		@string	$this->mail->to_name				(the name to use in the To: header)
	 *		@string	$this->mail->reply_to_email_address	(the address to use in ReplyTo: header)
	 *		@string	$this->mail->reply_to_name			(the name to use in ReplyTo: header)
	 *		@string	$this->mail->cc_email_address		(the address to use in CC: header)
	 *		@string	$this->mail->cc_name				(the name to use in CC: header)
	 *		@string	$this->mail->bcc_email_address		(the address to use in BCC: header)
	 *		@string	$this->mail->bcc_name				(the name to use in BCC: header)
	 *		@string	$this->mail->attachment_path		(file path to attachment file)
	 *		@string	$this->mail->attachment_name		(name of the attachment)
	 *
	 *
	 *
	 *
	 * @return  bool  send mail success
	 *
	 * @access  public
	 *
	 * @author  Andy
	 */
	public function send_mail()
	{

		//we can't send any email if none of these variables are set
		if ( !$this->mail || !is_object($this->mail) || !$this->mail->to_email_address || !$this->mail->subject || !$this->mail->body  ) {
			return false;
		}

		$mail = new PHPMailer;
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);
		//$mail->XMailer = 'Mailer';

		if ( !$this->mail->from_email || !$this->mail->from_email_password ) { //default mailer account
			$mail->Username = SMTP_USERNAME;	// SMTP username
			$mail->Password = SMTP_PASSWORD;	// SMTP password

			//default from email gets the email address as set in config.php, but can have a custom name
			if ( !$this->mail->from_name )
				$mail->setFrom(SMTP_USERNAME, MAIL_FROM);
			else
				$mail->setFrom(SMTP_USERNAME, $this->mail->from_name);

		} else {

			$mail->Username = $this->mail->from_email;	// SMTP username
			$mail->Password = $this->mail->from_email_password;	// SMTP password

			//if we have set the From name, use the full email login account as "From:", else use default email address
			if ( !$this->mail->from_name )
				$mail->setFrom(SMTP_USERNAME, MAIL_FROM);
			else
				$mail->setFrom($this->mail->from_email, $this->mail->from_name);
		}

		$mail->Subject = $this->mail->subject;

		$mail->addAddress( $this->mail->to_email_address, ($this->mail->to_name ? $this->mail->to_name : false ) );     // Add a recipient

		// do we want replies to go to another address?
		if ( $this->mail->reply_to_email_address ) {
			//$str = ($this->mail->reply_to_name ? ','.$this->mail->reply_to_name : '');
			$mail->addReplyTo($this->mail->reply_to_email_address, ($this->mail->reply_to_name ? $this->mail->reply_to_name : false ) );     // Add a CC recipient
		}

		// add carbon copy to someone?
		if ( $this->mail->cc_email_address ) {
			$mail->addCC($this->mail->cc_email_address, ($this->mail->cc_name ? $this->mail->cc_name : false ) );     // Add a CC recipient
		}

		// add blind carbon bopy to someone?
		if ( $this->mail->bcc_email_address ) {
			$mail->addCC($this->mail->bcc_email_address, ($this->mail->bcc_name ? $this->mail->bcc_name : false ) );     // Add a CC recipient
		}

		// adding an attachment?
		if ( $this->mail->attachment_path && is_file($this->mail->attachment_path) ) {
			$mail->addAttachment($this->mail->attachment_path, ($this->mail->attachment_name ? ','.$this->mail->attachment_name : false ) );     // Add a CC recipient
		}

		// do we have an HTML body
		if ( $this->mail->body_html ) {

			// HTML email
			$mail->isHTML(true);

			$header = "<!DOCTYPE html>
<html>
<body>
";
			$footer .= "\n</body>\n</html>\n";

			$mail->Body = $header . $this->mail->body_html . $footer;

			if ( $this->mail->body_plaintext )
				$altbody = $this->mail->body_plaintext;
			else
				$altbody = $this->mail->body;

			// Order of newline replacement
			$order   = array("\r\n", "\n", "\r");
			$replace = "\r\n";
			// Processes \r\n's first so they aren't converted twice.
			$altbody = preg_replace("|\r\n|", "\n", $altbody);
			$altbody = preg_replace("|\r|", "\n", $altbody);
			$altbody = preg_replace("|\n|", "\r\n", $altbody);

			$mail->AltBody = $altbody; //str_replace($order, $replace, $altbody);

		} else {

			$altbody = $this->mail->body;
			$altbody = preg_replace("|\r\n|", "\n", $altbody);
			$altbody = preg_replace("|\r|", "\n", $altbody);
			$altbody = preg_replace("|\n|", "\r\n", $altbody);

			$mail->Body = $altbody; //str_replace($order, $replace, $this->mail->body);

		}

		return $mail->send();

	}
	// }}}

	//returns an object of all admin IDs
	public function all_admins()
	{
		return $this->db->get_results("SELECT * FROM `users` WHERE `is_admin`=1 ORDER BY `id` ASC");
	}

	public function email_template_path($filename=null)
	{

		if (!$filename)
			return false;

		$base_path = SYSTEM_DIRECTORY_ROOT . '/email_templates';
		if ( is_file("{$base_path}/{$filename}") && is_readable("{$base_path}/{$filename}") )
			return "{$base_path}/{$filename}";
		else if ( is_file("{$base_path}/{$filename}.txt") && is_readable("{$base_path}/{$filename}.txt") )
			return "{$base_path}/{$filename}.txt";
		else if ( is_file("{$base_path}/{$filename}.tpl") && is_readable("{$base_path}/{$filename}.tpl") )
			return "{$base_path}/{$filename}.tpl";
		else
			return false;

	}

	// {{{ isValid($module)
	/**
	* isValid
	*
	* Determines if $module is a valid framework module. This is used by
	* the controller to determine if the module fits into our framework's
	* mold. If it extends from both NQ_Module and NQ_Auth then it should be
	* good to run.
	*
	* @static
	* @param mixed $module
	* @return bool
	*/
	public static function isValid($module)
	{
		return (is_object($module) &&
				$module instanceof NQ_Module &&
				$module instanceof NQ_Auth);
	}
	// }}}
	// {{{ errorDoc($type, $log)
	/**
	* errorDoc
	*
	* Throws an apache error document
	*
	* @static
	* @param string $type Error Document type
	* @param mixed $log Text to log
	* @return exit(0)
	*/
	public function errorDoc($type, $log)
	{
		switch ($type) {
			case '400': $txt = '400 Bad Request'; break;
			case '403': $txt = '403 Forbidden'; break;
			case '404': $txt = '404 Not Found'; break;
			case '503': $txt = '503 Temporarily Unavailable'; break;

		}
		header('HTTP/1.1 '.$txt);
		if (file_exists(NQ_ERRORDOCS_PATH.'/'.$type.'.php'))
			@include_once(NQ_ERRORDOCS_PATH.'/'.$type.'.php');

		$this->log->log($log, PEAR_LOG_ERROR);
		exit(0);

	}
	// }}}
	// {{{
	/**
	* array_find
	*
	* Searches for a string in every value of a one-dimensional array.
	*
	* @param string $needle.
	* @param mixed $haystack Array to search in.
	* @return mixed Index of the _first_ match, or FALSE if no match is found.
	*/
	public function array_find($pattern, $haystack)
	{
		for($i = 0; $i < count($haystack); $i++) {
			if (strpos($haystack[$i], $pattern))
				return $i;
		}
		return false;
	}
	// }}}
	// {{{ logQuery
	/**
	* logQuery
	*
	* Logs the last ezSQL mysql query, function call, and numrows
	*
	* @return void
	*/
	public function logQuery($conn) {
		$toLog = "<span><b>$conn MySQL Query</b> [".$this->$conn->num_queries."]<b>:</b> ".($this->$conn->last_query?preg_replace('|\n|', '', $this->$conn->last_query):"NULL")."</span><br>";
		if ($this->$conn->from_disk_cache == true)
			$toLog .= '<span><b><font color="orange">Using disk cache...</font></b></span><br />';
		else
			$toLog .= '<span><b>'.$conn.' Function Call:</b> ' . ($this->$conn->func_call?preg_replace('|\n|', '', $this->$conn->func_call):"None") . '</span><br>';
		if (count($this->$conn->last_result) < 1)
			$toLog .= '<span class="l'.PEAR_LOG_WARNING.'">';
		else
			$toLog .= '<span class="l'.PEAR_LOG_NOTICE.'">';
		$toLog .= '<b>Rows Returned:</b> '. count($this->$conn->last_result) .' in '. $this->$conn->query_time .' secs</span>';
		if ($this->$conn->last_error) {
			$toLog .= '<br><span class="l'.PEAR_LOG_EMERG.'">'.$this->$conn->last_error.'</span>';
			unset($this->$conn->last_error);
		}
		$this->log->log($toLog, PEAR_LOG_DEBUG);
	}
	// }}}
	// {{{ log2win
	/**
	* log2win
	*
	* Creates a log window popup if PRESENTER==debug && NQ_DEBUG_OUTPUT=display
	*
	* @param string $type Error Document type
	* @param mixed $log Text to log
	* @return void
	*/
	public function log2win()
	{
		if ($this->tplFile == 'index.tpl')
			$tplFile = $this->moduleName . '.tpl';
		else
			$tplFile = $this->moduleName .  ucfirst($this-tplFile);
		$log = file(SYSTEM_LOG_FILE);

		$start = $this->array_find('DEBUG MODE START ('. _ID .')', $log);
		$end = $this->array_find('DEBUG MODE END ('. _ID .')', $log);
		preg_match('/^([a-zA-Z]{3} [0-9]{2} [0-9:]{8})/', $log[$start], $start_time);
		preg_match('/^([a-zA-Z]{3} [0-9]{2} [0-9:]{8})/', $log[$end], $end_time);
		if ($start && $end) {
			$log = array_slice($log, $start+1, ($end-1)-$start);
		}
		$styles = array(
                        PEAR_LOG_EMERG   => 'background-color: red; color:yellow;',
                        PEAR_LOG_ALERT   => 'background-color: orange;',
                        PEAR_LOG_CRIT    => 'background-color: yellow; color:red;',
                        PEAR_LOG_ERR     => 'background-color: violet; color:yellow;',
                        PEAR_LOG_WARNING => 'background-color: #ff9900; color:blue;',
                        PEAR_LOG_NOTICE  => 'background-color: blue; color:yellow;',
                        PEAR_LOG_INFO    => 'background-color: #CCCCCC;',
                        PEAR_LOG_DEBUG   => 'background-color: green; color:yellow;'
                    );
		$win = 'debugLog';

		$logOut = array();
		$logOut[] = '<tr class="l'.PEAR_LOG_INFO.'"><td nowrap>'.$end_time[1].'</td><td align=center>info</td><td>Debug Log Ended</td></tr>';
		krsort($log);
		foreach ($log as $entry) {
			preg_match('/^([a-zA-Z]{3} [0-9]{2} [0-9:]{8}).[^\[]+\[([a-zA-Z]+)\] (.*)/', $entry, $matches);
			$ident = strtoupper($matches[2]);
			switch ($ident) {
				case 'ERROR':
					$ident = 'ERR';
					break;
				case 'EMERGENCY':
					$ident = 'EMERG';
					break;
				case 'CRITICAL':
					$ident = 'CRIT';
					break;
			}
			$ident = "PEAR_LOG_{$ident}";
			$logOut[] = '<tr class="l'.constant($ident).'"><td nowrap>'.$matches[1].'</td><td align=center>'.$matches[2].'</td><td>'.addslashes($matches[3]).'</td></tr>';
		}
		$logOut[] = '<tr class="l'.PEAR_LOG_INFO.'"><td nowrap>'.$start_time[1].'</td><td align=center>info</td><td>Debug Log Started</td></tr>';
		foreach ($logOut as $html) {
			$_html .= $win.".document.writeln('".$html."');\n";
		}
		echo <<< EOT
		<script language="JavaScript">
		$win = window.open('', '{$win}', 'toolbar=no,scrollbars,width=700,height=600');
		$win.document.writeln('<html>');
		$win.document.writeln('<head>');
		$win.document.writeln('<title>Runtime Log for {$this->presenter} {$tplFile}</title>');
		$win.document.writeln('<style type="text/css">');
		$win.document.writeln('body { font-family: monospace; font-size: 8pt; }');
		$win.document.writeln('td,th { font-size: 8pt; }');
		$win.document.writeln('td,th { border-bottom: #999999 solid 1px; }');
		$win.document.writeln('td,th { border-right: #999999 solid 1px; }');
		$win.document.writeln('tr { text-align: left; vertical-align: top; }');
		$win.document.writeln('.l0 { $styles[0] }');
		$win.document.writeln('.l1 { $styles[1] }');
		$win.document.writeln('.l2 { $styles[2] }');
		$win.document.writeln('.l3 { $styles[3] }');
		$win.document.writeln('.l4 { $styles[4] }');
		$win.document.writeln('.l5 { $styles[5] }');
		$win.document.writeln('.l6 { $styles[6] }');
		$win.document.writeln('.l7 { $styles[7] }');
		$win.document.writeln('</style>');
		$win.document.writeln('</head>');
		$win.document.writeln('<body>');
		$win.document.writeln('<table border="0" cellpadding="2" cellspacing="0">');
		$win.document.writeln('<tr><th>Time</th>');
		$win.document.writeln('<th>Priority</th><th width="100%">Message</th></tr>');
		$_html
		$win.document.writeln('</table>');
		$win.document.writeln('</body></html>');
		$win.document.close();
		</script>
EOT;
	}
	// }}}

	// {{{ sec2time()
	/*
	* sec2time
	*
	* returns a formatted HH:mm:ss value for seconds
	* @param string $seconds Number of seconds to convert
	* @return formatted time
	*/
	public function sec2time($seconds, $long=false) {
    	$hours = floor($seconds / 3600);
    	$minutes = floor($seconds % 3600 / 60);
    	$seconds = $seconds % 60;

		if ($long ===true) {
			return sprintf("%d hrs %02d mins %02d secs", $hours, $minutes, $seconds);
		} else {
	    	return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
		}
	}
	// }}}

	// {{{ bytesToSize()
	/**
	* bytesToSize
	*
 	* Convert bytes to human readable format
 	*
 	* @param integer bytes Size in bytes to convert
 	* @return string
	 */
	public function bytesToSize($bytes, $precision = 2)
	{
	    $kilobyte = 1024;
    	$megabyte = $kilobyte * 1024;
    	$gigabyte = $megabyte * 1024;
    	$terabyte = $gigabyte * 1024;

    	if (($bytes >= 0) && ($bytes < $kilobyte)) {
        	return $bytes . ' B';

    	} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
        	return round($bytes / $kilobyte, $precision) . ' KB';

    	} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
        	return round($bytes / $megabyte, $precision) . ' MB';

    	} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
        	return round($bytes / $gigabyte, $precision) . ' GB';

    	} elseif ($bytes >= $terabyte) {
        	return round($bytes / $gigabyte, $precision) . ' TB';
    	} else {
        	return $bytes . ' B';
    	}
	}
	// }}}


	public function regex_escape($str)
	{
		$str = str_ireplace('(', '\(', $str);
		$str = str_ireplace(')', '\)', $str);
		$str = str_ireplace(']', '\]', $str);
		$str = str_ireplace('[', '\[', $str);
		$str = str_ireplace('-', '\-', $str);
		$str = str_ireplace('.', '\.', $str);
		$str = str_ireplace('?', '\?', $str);
		$str = str_ireplace('"', '\"', $str);

		return $str;

	}

	/* convert Windows CRLF/CR to LF */
	public function normalise_linefeeds($s) {
		// Normalize line endings using Global
		// Convert all line-endings to UNIX format
		$s = str_replace(CRLF, LF, $s);
		$s = str_replace(CR, LF, $s);
		// Don't allow out-of-control blank lines
		$s = preg_replace("/\n{2,}/", LF . LF, $s);
		return $s;
	}




	/*
		Non base framework functions
	*/

	//all users in the system
	public function all_users( $exclude_users=false )
	{
		$all_users = $this->db->get_results("SELECT * FROM `users` ORDER BY `name` ASC");

		if ( !$exclude_users )
			return $all_users;

		foreach($exclude_users as $exclude_user) {

			$exclude_user_id = $exclude_user->id;

			foreach ( $all_users as $k=>$user ) {
				if ( $user->id == $exclude_user_id ) { //exclude this user
					unset($all_users[$k]);
				}
			}

		}
		return ($all_users);

	}

	public function all_projects()
	{

		if ( $this->user->is_admin == 1 ) {
			return $this->db->get_results("SELECT * FROM `projects` ORDER BY `name` ASC");
		}

        return $this->db->get_results("SELECT projects.* FROM `projects` JOIN `users_projects` ON projects.id=users_projects.project_id  WHERE `user_id`={$this->user->id} ORDER BY `name` ASC");

	}

	// test if a user is a project manager of a project
	public function is_project_manager( $user_id=0, $project_id=0 )
	{
		if ( $user_id < 1 || $project_id < 1 )
			return false;

		if ( $user_id == $this->user->id && $this->user->is_admin == 1 )
			return true;

		if ( $this->db->get_var( "SELECT `user_id` FROM `project_managers` WHERE `project_id`={$project_id} AND `user_id`={$user_id} LIMIT 1" ) == $user_id )
			return true;

		//return false;

	}

	// get all project managers of a project
	public function project_managers($project_id=0)
	{
		if ( $project_id < 1 || $this->user->id < 1 ) {
			return array();
		}

		//get all users of the project
		$project_users = self::project_users($project_id);
		foreach ($project_users as $k => $user) {

			if ( !self::is_project_manager($user->id, $project_id) )
				unset($project_users[$k]);

		}

		//what's left of the $project_users array are only the managers
		//create an array of user IDs which are all the project managers (if any)
		$project_managers = array();

		foreach ($project_users as $project_user) {
			$project_managers[] = $project_user->id;

		}
		return $project_managers;

	}

	// get all user details for users of a project
	public function project_users($project_id=0) {

		if ( $project_id < 1 || $this->user->id < 1 ) {
			return array();
		}

		$users =  $this->db->get_results("SELECT users.* FROM `users` INNER JOIN users_projects ON id=user_id  WHERE `project_id`={$project_id} ORDER BY `name` ASC");

		if ( !count($users) )
			return array();

		return $users;

	}

	//creation of a new project
	public function new_project($nameProject)
	{   //To create a new project we need to compute several variable
        //the md5sum's name project
        $md5sum = md5($nameProject);
        $created = time();
        $modified = $created;
        $uuid = $this->uuid(); //uniqid();
        $modified_by = $this->user->id;
		$this->db->query("INSERT INTO `projects` (id, name, md5sum, created, modified, uuid, modified_by) VALUES (NULL, '{$nameProject}', '{$md5sum}', {$created}, {$modified}, '{$uuid}', '{$modified_by}')");

        //We check if insertion is ok
        $rowsAffectedToCreateNewProject = $this->db->rows_affected;

		if ($rowsAffectedToCreateNewProject > 0) { //we have to check if the project name are not already use

            //We need to associated creator's project to this one
            //First get the project of the new project created
            $new_project_id = $this->db->get_var( "SELECT `id` FROM `projects` WHERE `name`='{$nameProject}' ");

            //we create manager association
            $this->db->query("INSERT INTO `project_managers` (`project_id`,`user_id`) VALUES ('{$new_project_id}','{$modified_by}')");
            //We check if insertion is ok
            $rowsAffectedToCreateNewManager = $this->db->rows_affected;

            //We create user association
            $this->db->query("INSERT INTO `users_projects` (`user_id`,`project_id`) VALUES ('{$modified_by}','{$new_project_id}')");
            //We check if insertion is ok
            $rowsAffectedToCreateNewUser = $this->db->rows_affected;

            /* 08/07/2016 if ($rowsAffectedToCreateNewProject > 0 && $rowsAffectedToCreateNewManager > 0 && $rowsAffectedToCreateNewUser > 0){ //we inserted the new project
                return true;
            } else {
                return $rowsAffectedToCreateNewProject . $rowsAffectedToCreateNewManager;
            }*/

            //We create a variable to know if creating project is successful for the database side.
            $creationNewProjectDbSide = false;

            if ($rowsAffectedToCreateNewProject > 0 && $rowsAffectedToCreateNewManager > 0 && $rowsAffectedToCreateNewUser > 0){ //we inserted the new project in the sqlite database
                $creationNewProjectDbSide =  true;
            } else {
                return $rowsAffectedToCreateNewProject . $rowsAffectedToCreateNewManager . " SQLITE issue with creating project";
            }

            //We need to create several folders for this new project.
            $oldmask = umask(0); //store the value of the old mask apply by apache config and remove it
            $pathFolder = SYSTEM_DATA_ROOT."/projects/" . $new_project_id;
            mkdir($pathFolder, 0777);
            $pathFolderSamples = SYSTEM_DATA_ROOT."/projects/" . $new_project_id. "/samples";
            mkdir($pathFolderSamples, 0777);
            $pathFolderResults = SYSTEM_DATA_ROOT."/projects/" . $new_project_id. "/results";
            mkdir($pathFolderResults, 0777);
            $pathFolderMetada = SYSTEM_DATA_ROOT."/projects/" . $new_project_id. "/metadata";
            mkdir($pathFolderMetada, 0777);

            /*//We want to be free about the config file's structure. So we need to create one and this one will be modified.
            $config = array(
                "project_name" => $nameProject
            );
            //Write the config file
            $res = yaml_emit_file($pathFolderMetada . "/config.yml", $config, $encoding = YAML_UTF8_ENCODING );*/

			//We need to make a gitclone of the git repository gene-regulation https://github.com/rioualen/gene-regulation.git
            $pathFolderGeneReg = SYSTEM_DATA_ROOT."/projects/" . $new_project_id. "/gene-regulation";
            mkdir($pathFolderGeneReg, 0777);//folder for scripts from the git repository gene-regulation https://github.com/rioualen/gene-regulation.git
            //command execute by php for make a clone of the git repository gene-regulation https://github.com/rioualen/gene-regulation.git
            $recup = shell_exec('git clone https://github.com/rioualen/gene-regulation.git ' . $pathFolderGeneReg );

            umask($oldmask); //re-install the mask

            return true;

        }else{// error message show to the user if the project name are not available
            return "this name project is already used, please choose another one";
        }

	}
	public function project_info($project_id=0)
    {
        /*verification*/
        if ( $project_id < 0 || $this->user->id < 1 ) {
            return array();
        }

        /*Make a request to get all info about this project*/
         return $this->db->get_row("SELECT * FROM `projects` WHERE `id`={$project_id} LIMIT 1");

    }

    //Get all information about data supported
    public function get_all_data_type()
    {
        return $this->db->get_results("SELECT * FROM `data_types`");
    }

    public function addfile_db($md5sum, $user_id=0, $file_name)
    {
        /*verification*/
        if ( $user_id < 0){
            return false;
        }
        $updated = time();
        //We insert file's information in the file table
        $this->db->query("INSERT INTO `files` (`file_id`, `md5sum`,`user_id`, `date_uploaded`,`file_name`) VALUES (NULL,'{$md5sum}','{$user_id}','{$updated}', '{$file_name}')");
        $rowsAffectedToCreateNewFile = $this->db->rows_affected;

        if ($rowsAffectedToCreateNewFile > 0){
            return true;
        } else
        	return false;
    }

	public function addfile_inproject_db($md5sum,$project_id=0)
    {
        /*Verification*/
        if ($project_id < 0){
            return false;
        }

        /*We need the file_id contain in the file table
        So we make a resquest to get this one*/
        $file_id = $this->db->get_var("SELECT `file_id` FROM `files` WHERE `md5sum`='{$md5sum}'");

        /*We create the association between the file with the project in the files_projects table*/
        if ( $this->file_in_project($file_id, $project_id) != true ) { // new file-project association

			$this->db->query("INSERT INTO `files_projects` (`file_id`, `project_id`, `md5sum`) VALUES ('{$file_id}','{$project_id}','{$md5sum}')");
			$rowsAffectedToCreateNewFileProjectAsso = $this->db->rows_affected;

			if ($rowsAffectedToCreateNewFileProjectAsso > 0) {
				return true;

			} else {
				return false;
			}
		} else {

			return false;

		}

    }

	public function all_data_types()
	{

		return $this->db->get_results("SELECT * FROM `data_types`");

	}

    public function file_in_project($file_id=0, $project_id=0)
    {
        /*Verification*/
		if($project_id < 0 || $file_id < 0){
            return true;
		}

        $cmd = "SELECT COUNT(`file_id`) FROM `files_projects` WHERE `project_id`={$project_id} AND `file_id`={$file_id} ";
        $assoAlreadyExist = $this->db->get_var( $cmd );

        //die($cmd);

        if(intval($assoAlreadyExist) > 0){
            return true;
        }else{
            return false;
        }

    }

    public function get_name_and_md5sum_by_file_id($file_id=0)
    {
        /*Verification*/
        if($file_id < 0 ){
            return array();
        }

        $info =  $this->db->get_results("SELECT files.file_name, files.md5sum FROM `files` WHERE `file_id`='{$file_id}'");

        if ( !count($info) )
            return array();

        return $info;
    }

    public function get_all_files_in_project($project_id=0)
	{
        /*Verification*/
        if($project_id < 0 ){
            return array();
        }

        /*Make a request to obtain all information about all files in this project*/

        $files =  $this->db->get_results("SELECT files.* FROM `files` INNER JOIN files_projects ON files.file_id=files_projects.file_id WHERE `project_id`={$project_id} ORDER BY `file_name` ASC");

        if ( !count($files) )
            return array();

        return $files;

	}


	public function metadata_in_db($all_col_name_array, $project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return false;
        }

        if(!is_array($all_col_name_array)){
            return false;
        }
        /*insert if the association don't already exist column name with the project in the metadata table*/
        foreach ($all_col_name_array as $col_name){
            if($this->metadata_in_project($col_name, $project_id) != true){//Check if the association already exist
                $this->db->query("INSERT INTO `metadata` (`metadata_id`, `project_id`, `column_name`) VALUES (NULL,'{$project_id}','{$col_name}')");
            }

            $metadata_id = $this->db->get_var("SELECT `metadata_id` FROM `metadata` WHERE `column_name`='{$col_name}'");
            if ($this->metadata_project_asso($metadata_id, $project_id) != true) {//Check if the association already exist
                $this->db->query("INSERT INTO `project_metadata` (`project_id`, `metadata_id`) VALUES ('{$project_id}','{$metadata_id}')");
            }
        }

        return true;
    }

    public function metadata_in_project($col_name, $project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return true;
        }
        $cmd = "SELECT COUNT(`project_id`) FROM `metadata` WHERE `project_id`={$project_id} AND `column_name`='{$col_name}' ";
        $assoAlreadyExistMetadataProjectInMetadataTable = $this->db->get_var( $cmd );

        //die($cmd);

        if(intval($assoAlreadyExistMetadataProjectInMetadataTable) > 0){
            return true;
        }else{
            return false;
        }

    }

    public function metadata_project_asso($metadata_id, $project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return true;
        }
        $cmd = "SELECT COUNT(`project_id`) FROM `project_metadata` WHERE `project_id`={$project_id} AND `metadata_id`='{$metadata_id}' ";
        $assoAlreadyExistMetadataProjectInProjectMetadataTable = $this->db->get_var( $cmd );

        //die($cmd);

        if(intval($assoAlreadyExistMetadataProjectInProjectMetadataTable) > 0){
            return true;
        }else{
            return false;
        }

    }

    public  function get_all_rna_groups_in_project($project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return array();
        }

        /*Make a request to obtain all rna groups in this project*/

        $rnaGroups =  $this->db->get_results("SELECT * FROM `groups` WHERE `project_id`={$project_id} AND `data_type_id`= 2 ORDER BY `group_name` ASC");

        if ( !count($rnaGroups) )
            return array();

        return $rnaGroups;
    }
    public  function get_all_chip_groups_in_project($project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return array();
        }

        /*Make a request to obtain all rna groups in this project*/

        $chipGroups =  $this->db->get_results("SELECT * FROM `groups` WHERE `project_id`={$project_id} AND `data_type_id`= 1  ORDER BY `group_name` ASC");

        if ( !count($chipGroups) )
            return array();

        return $chipGroups;
    }

    public function metadata_value_in_db($arraySampleAnnotations)
    {
        /*Verification*/
        if(!is_array($arraySampleAnnotations)){
            return false;
        }

        $all_col_name = array_keys($arraySampleAnnotations);
        //first line is empty used like a template
		//echo count($arraySampleAnnotations["md5sum"]);
        for($sample = 1; $sample < count($arraySampleAnnotations["md5sum"]); $sample++){
            $md5sum = $arraySampleAnnotations["md5sum"][$sample];
            $file_id = $this->db->get_var("SELECT `file_id` FROM `files` WHERE `md5sum`='{$md5sum}'");

            $col_number = 0;
            foreach ($arraySampleAnnotations as $key => $value){
                $col_name = $all_col_name[$col_number];
                $metadata_id = $this->db->get_var("SELECT `metadata_id` FROM `metadata` WHERE `column_name`='{$col_name}'");
				//Create a function to check if mid/fid already exist
                if ($this->metadata_file_asso($metadata_id, $file_id) != true) {//Check if the association already exist
                    $this->db->query("INSERT INTO `files_metadata` (`metadata_id`, `file_id`, `metadata_value` ) VALUES ('{$metadata_id}','{$file_id}','{$value[$sample]}')");
                }else{
                   return false;
                }

                $col_number++;
            }
        }
        return true; 
    }

    public function metadata_file_asso($metadata_id=0, $file_id=0)
    {
        /*Verification*/
        if($file_id < 0 ){
            return true;
        }
        if($metadata_id < 0 ){
            return true;
        }

        $cmd = "SELECT COUNT(`metadata_id`) FROM `files_metadata` WHERE `file_id`={$file_id} AND `metadata_id`='{$metadata_id}' ";
        $assoAlreadyExistMetadataFileInFileMetadataTable = $this->db->get_var( $cmd );

		if(intval($assoAlreadyExistMetadataFileInFileMetadataTable) == 0){
			return false;
		}elseif(intval($assoAlreadyExistMetadataFileInFileMetadataTable) == 1){
			//we allowed value's modification so we first delete previous data
            $this->db->query("DELETE FROM `files_metadata` WHERE `file_id`={$file_id} AND `metadata_id`='{$metadata_id}'");
            return false;
        }else{
            return true;
        }

    }

	public function add_rna_assignation_in_db($array_rna_assignation_files, $project_id=0)
    {

        /*Verification part*/
        if($project_id < 0 ){
            return false;
        }

        if (empty($array_rna_assignation_files)){
            return false;
        }
        /*Verification part end */

        for($sample = 1; $sample < count($array_rna_assignation_files["rna_groups_assignation"]["md5sum"]); $sample++) {
            $md5 = $array_rna_assignation_files["rna_groups_assignation"]["md5sum"][$sample];
            $Sample_name = $array_rna_assignation_files["rna_groups_assignation"]["Sample_name"][$sample];

            $file_id = $this->db->get_var("SELECT `file_id` FROM `files` WHERE `md5sum`='{$md5}'");

            $this->db->query("DELETE FROM `groups_files` WHERE `project_id`={$project_id} AND `file_id`='{$file_id}' ");

            foreach ($array_rna_assignation_files["rna_groups_assignation"][$md5] as $group => $groupName) {

                $rna_group_id = $this->db->get_var("SELECT `group_id` FROM `groups` WHERE `group_name`='{$groupName}' AND `project_id`='{$project_id}'");

                $this->db->query("INSERT INTO `groups_files` (`group_id`, `file_id`, `project_id` ) VALUES ({$rna_group_id},{$file_id},{$project_id})");

                /*29/09/2016  if ($this->rna_assignation_asso($group_id, $file_id, $project_id) != true) {//Check if the association already exist
                    $this->db->query("INSERT INTO `groups_files` (`group_id`, `file_id`, `project_id` ) VALUES ({$group_id},{$file_id},{$project_id})");
                }*/

            }

        }

        return true;
    }

    public function add_chip_assignation_in_db($array_chip_assignation_files, $project_id=0)
    {

        /*Verification part*/
        if($project_id < 0 ){
            return false;
        }

        if (empty($array_chip_assignation_files)){
            return false;
        }
        /*Verification part end */

        $pair_ids = array_keys($array_chip_assignation_files["group_association_chip"]); //Array ( [0] => 0 [1] => 1 [2] => 9 )
        for ($i=1; $i < count($pair_ids); $i ++){
            //return $array_chip_assignation_files["group_association_chip"][$pair_id[$i]]; //Array ( [0] => condA )
            if(is_array($array_chip_assignation_files["group_association_chip"][$pair_ids[$i]])){
                //The global idea it's to delete everything about an association for this pair_id and to rewrite it after
                //to make it we need two steps
                //step one get file_id by the pair_id
                $pair_id=$pair_ids[$i];

                //we need the input_file_id and treated_file_id we can get these with the pair_id
                $treated_file_id = $this->db->get_var("SELECT `treated_file_id` FROM `chip_sample_pair` WHERE `project_id`={$project_id} AND `chip_pair_id`={$pair_id}");
                $input_file_id = $this->db->get_var("SELECT `input_file_id` FROM `chip_sample_pair` WHERE `project_id`={$project_id} AND `chip_pair_id`={$pair_id}");

                //step two delete record
                $this->db->query("DELETE FROM `groups_files` WHERE `project_id`={$project_id} AND `file_id`='{$treated_file_id}' ");
                $this->db->query("DELETE FROM `groups_files` WHERE `project_id`={$project_id} AND `file_id`='{$input_file_id}' ");


                for ($group=0; $group < count($array_chip_assignation_files["group_association_chip"][$pair_ids[$i]]); $group ++){
                    //return $pair_ids[$i] . " et " . $array_chip_assignation_files["group_association_chip"][$pair_id[$i]][$group];// get pair_id and group_name

                    $group_name = $array_chip_assignation_files["group_association_chip"][$pair_ids[$i]][$group];

                    //we need to get the group_id
                    $group_id = $this->db->get_var("SELECT `group_id` FROM `groups` WHERE `project_id`={$project_id} AND `group_name`='{$group_name}' AND `data_type_id`=1");

                    $this->db->query("INSERT INTO `groups_files` (`group_id`, `file_id`, `project_id` ) VALUES ({$group_id},{$treated_file_id},{$project_id})");
                    $this->db->query("INSERT INTO `groups_files` (`group_id`, `file_id`, `project_id` ) VALUES ({$group_id},{$input_file_id},{$project_id})");

                }
            }
        }

        return true;
    }

        public function add_chip_sample_type_in_db($array_chip_assignation_files, $project_id=0)
        {

            /*Verification part*/
            if ($project_id < 0) {
                return false;
            }

            if (empty($array_chip_assignation_files)) {
                return false;
            }
            /*Verification part end */

            for ($sample = 1; $sample < count($array_chip_assignation_files["chip_groups_assignation"]["md5sum"]); $sample++) {
                $md5 = $array_chip_assignation_files["chip_groups_assignation"]["md5sum"][$sample];
                $Sample_name = $array_chip_assignation_files["chip_groups_assignation"]["Sample_name"][$sample];
                $data_type = $array_chip_assignation_files["chip_groups_assignation"]["Sample_type"][$sample];


                $file_id = $this->db->get_var("SELECT `file_id` FROM `files_projects` WHERE `md5sum`='{$md5}' AND `project_id`='{$project_id}'");

                if ($this->chip_sample_type_asso($file_id, $project_id) != true) { //Check if the association already exist
                    $this->db->query("INSERT INTO `chip_sample_type` (`file_id`, `project_id`, `sample_type` ) VALUES ({$file_id},{$project_id},'{$data_type}')");
                } else {
                    $this->db->query("DELETE FROM `chip_sample_type` WHERE `project_id`={$project_id} AND `file_id`='{$file_id}' ");
                    $this->db->query("INSERT INTO `chip_sample_type` (`file_id`, `project_id`, `sample_type` ) VALUES ({$file_id},{$project_id},'{$data_type}')");
                }
                //$this->db->query("INSERT INTO `chip_sample_type` (`file_id`, `project_id`, `sample_type` ) VALUES ({$file_id},{$project_id},'{$data_type}')");

            }

            return true;
        }

    public function add_chip_sample_pair_in_db($array_chip_sample_pair, $project_id=0)
    {

        /*Verification part*/
        if ($project_id < 0) {
            return false;
        }

        if (empty($array_chip_sample_pair)) {
            return false;
        }
        /*Verification part end */

        //un system ici de foreach car format type Array(array1())
		foreach ($array_chip_sample_pair as $pair){
		    //$pair[0] == "treated" md5sum
            //$pair[1] == "input" md5sum
			//return $pair[0];

            //We need the treated_file_id
            $treatedFileId = $this->db->get_var("SELECT `file_id` FROM `files_projects` WHERE `md5sum`='{$pair[0]}' AND `project_id`='{$project_id}'");

            //We need the input_file_id
            $inputFileId = $this->db->get_var("SELECT `file_id` FROM `files_projects` WHERE `md5sum`='{$pair[1]}' AND `project_id`='{$project_id}'");

            $this->db->query("INSERT INTO `chip_sample_pair` (`chip_pair_id`,`input_file_id`, `treated_file_id`, `project_id`) VALUES (NULL, {$inputFileId},{$treatedFileId},{$project_id})");

        }

        return true;
    }


    public function  get_all_chip_sample_type_asso($project_id= 0)
    {

        $allChipSampleTypeAsso = $this->db->get_results("SELECT chip_sample_type.*, files.md5sum FROM `chip_sample_type` INNER JOIN `files` ON files.file_id=chip_sample_type.file_id WHERE `project_id`={$project_id}");

        if ( !count($allChipSampleTypeAsso) )
            return array();
        return $allChipSampleTypeAsso;
    }

    public function get_all_chip_sample_type_input($project_id= 0)
	{
        $allChipSampleTypeInput = $this->db->get_results("SELECT files.file_name, files.md5sum FROM `files` INNER JOIN `chip_sample_type` ON files.file_id=chip_sample_type.file_id WHERE chip_sample_type.project_id={$project_id}  and chip_sample_type.sample_type = 'input'");

        if ( !count($allChipSampleTypeInput) )
            return array();
        return $allChipSampleTypeInput;
    }

	public function get_all_chip_sample_type_treated($project_id= 0)
	{
		$allChipSampleTypeTreated = $this->db->get_results("SELECT files.file_name, files.md5sum FROM `files` INNER JOIN `chip_sample_type` ON files.file_id=chip_sample_type.file_id WHERE chip_sample_type.project_id={$project_id}  and chip_sample_type.sample_type = 'treated'");

		if ( !count($allChipSampleTypeTreated) )
			return array();
		return $allChipSampleTypeTreated;
	}

	public function delete_chip_pair_already_define($md5sum_treated_sample,$md5sum_input_sample,$project_id)
    {
        /*Verification part*/
        if ($project_id < 0) {
            return false;
        }
        //we have only md5sum we need the file_id to delete this pair in the chip_sample_pair table
        $treatedFileId = $this->db->get_var("SELECT `file_id` FROM `files_projects` WHERE `md5sum`='{$md5sum_treated_sample}' AND `project_id`='{$project_id}'");

        $inputFileId = $this->db->get_var("SELECT `file_id` FROM `files_projects` WHERE `md5sum`='{$md5sum_input_sample}' AND `project_id`='{$project_id}'");

        $this->db->query("DELETE FROM `chip_sample_pair` WHERE `project_id`={$project_id} AND `input_file_id`='{$inputFileId}' AND `treated_file_id`='{$treatedFileId}'");

        return true;
    }
    public function get_all_chip_pair_already_defined($project_id = 0)
    {
        $allChipPairAlreadyDefined = $this->db->get_results("SELECT * FROM `chip_sample_pair` WHERE project_id={$project_id}");

        if ( !count($allChipPairAlreadyDefined) )
            return array();
        return $allChipPairAlreadyDefined;
    }

    public function chip_sample_type_asso($file_id, $project_id)
    {
        $cmd = "SELECT COUNT(`file_id`) FROM `chip_sample_type` WHERE `project_id`={$project_id} AND `file_id`='{$file_id}' ";
        $assoAlreadyExistChipSampleType = $this->db->get_var( $cmd );

        if(intval($assoAlreadyExistChipSampleType) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function rna_assignation_asso($rna_group_id, $file_id, $project_id)
    {
        $cmd = "SELECT COUNT(`file_id`) FROM `groups_files` WHERE `project_id`={$project_id} AND `file_id`='{$file_id}' AND `group_id`='{$rna_group_id}' ";
        $assoAlreadyExistRnaAssignation = $this->db->get_var( $cmd );

        if(intval($assoAlreadyExistRnaAssignation) > 0){
            return true;
        }else{
            return false;
        }


    }

	public function groups_in_db($array, $project_id=0,$data_type)

    {
        /*Verification*/
        if($project_id < 0 ){
            return false;
        }

        for ($i=0;$i<count($array["Group_name"]);$i++){
            $this->db->query("INSERT INTO `groups` (`group_id`,`data_type_id`, `group_name`, `group_description`, `created_by`, `project_id`) VALUES (NULL, {$data_type},'{$array["Group_name"][$i]}','{$array["Group_description"][$i]}','{$this->user->id}', '{$project_id}')");
        }
        return true;
    }

    public function chip_group_already_assigned_in_db($project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return array();
        }

        $chip_group_already_assignated =  $this->db->get_results("SELECT chip_sample_pair.chip_pair_id,groups.group_name FROM `groups_files` CROSS JOIN `chip_sample_pair`, `groups` WHERE chip_sample_pair.project_id=groups_files.project_id AND groups_files.group_id=groups.group_id AND groups_files.file_id=chip_sample_pair.treated_file_id AND groups_files.project_id='{$project_id}'");

        if ( !count($chip_group_already_assignated) )
            return array();
        return $chip_group_already_assignated;

    }

    public function rna_group_already_assigned_in_db($project_id=0)
    { //not used
        /*Verification*/
        if($project_id < 0 ){
            return array();
        }

        //$all_asso = $this->db->get_results("SELECT * FROM `groups_files` WHERE `project_id`='{$project_id}'");
		//$all_asso[0]->file_id;

		//return $all_asso[0];

        //$rna_group_already_assignated =  $this->db->get_results("SELECT files.* FROM `files` INNER JOIN files_projects ON files.file_id=files_projects.file_id WHERE `project_id`={$project_id} ORDER BY `file_name` ASC");

        $rna_group_already_assignated =  $this->db->get_results("SELECT files.file_id, files.file_name, files.md5sum, groups.group_id, groups.group_name FROM `groups_files` CROSS JOIN `files`, `groups` WHERE files.file_id=groups_files.file_id AND groups_files.group_id=groups.group_id AND groups_files.project_id='{$project_id}'");
        return $rna_group_already_assignated;
    }

    public function group_already_assigned_in_db($project_id=0, $data_type=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return array();
        }
        /*Verification*/
        if($data_type < 0 ){
            return array();
        }

        $group_already_assignated =  $this->db->get_results("SELECT files.file_id, files.file_name, files.md5sum, groups.group_id, groups.group_name FROM `groups_files` CROSS JOIN `files`, `groups` WHERE files.file_id=groups_files.file_id AND groups_files.group_id=groups.group_id AND groups_files.project_id={$project_id} AND groups.data_type_id ={$data_type} ");
        return $group_already_assignated;
    }

    public function write_chip_design($array, $project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return false;
        }
        //in $array there are only the group_name
        //Get the file name by the group_name
        //Get 2 array one for only treated_file the other for input_file


        $treatment = array();
        $control = array();
        $group = array();
		//return count($array);

        foreach ($array as $key => $value) {

            $group_id = $this->db->get_var("SELECT `group_id` FROM `groups` WHERE `group_name`='{$key}' AND `project_id`='{$project_id}' AND `data_type_id`=1");

            //Select all file_id link to this group_id
            $file_ids = $this->db->get_results("SELECT `file_id` FROM `groups_files` WHERE `group_id`='{$group_id}' AND `project_id`='{$project_id}'");

            //take all information about all sample_pair from this project
            $input_file_ids = $this->db->get_results("SELECT `input_file_id` FROM `chip_sample_pair` WHERE `project_id`='{$project_id}'");
            $treated_file_ids = $this->db->get_results("SELECT `treated_file_id` FROM `chip_sample_pair` WHERE `project_id`='{$project_id}'");

            foreach ($file_ids as $file) {
                //return $file->file_id ;
                foreach ($input_file_ids as $input_file_id) {

                    if ($file->file_id == $input_file_id->input_file_id) {
                        //requête pour obtenir le nom

                        $md5sum_input = $this->db->get_var("SELECT `md5sum` FROM `files` WHERE `file_id`='{$file->file_id}'");

                        array_push($control, $md5sum_input);
                        //add colone group in the design file in order to reload design on GUI when it's already defined
                        array_push($group,$key);
                    }
                }

                foreach ($treated_file_ids as $treated_file_id) {

                    if ($file->file_id == $treated_file_id->treated_file_id) {

                        $md5sum_treatment = $this->db->get_var("SELECT `md5sum` FROM `files` WHERE `file_id`='{$file->file_id}'");

                        array_push($treatment, $md5sum_treatment);
                    }

                }

            }
        }



        //$control = array_unique($control);

        //$treatment = array_unique($treatment);

            /*Part about create/write the design.tab file*/

        $pathFolderMetada = SYSTEM_DATA_ROOT."/projects/" . $project_id. "/metadata";


        if(file_exists($pathFolderMetada . "/ChIP/design.tab")) {
            unlink($pathFolderMetada . "/ChIP/design.tab");
        }

        $handle = fopen($pathFolderMetada . "/ChIP/design.tab", "a+");
        fwrite($handle, "treatment"."\t" . "control" ."\t" . "group" ."\n");

        for ($i=0;$i<max(count($control),count($treatment));$i++){
            fwrite($handle,$treatment[$i] . "\t" . $control[$i] . "\t" . $group[$i] . "\n");
        }

        fclose($handle);

        return true;

    }


    public function write_rna_design($array, $project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return false;
        }
        /*We need to check if the group name write by the user are defined and available*/
        //Group_reference part
        for ($i=0;$i<count($array["Group_reference"]);$i++){

            if (!in_array($array["Group_reference"][$i],$array["Group_name_available"])){
                unset($array["Group_reference"][$i]);
                unset($array["Group_test"][$i]);
            }

        }
        //Group_test part
        for ($i=0;$i<count($array["Group_test"]);$i++) {

            if (!in_array($array["Group_test"][$i], $array["Group_name_available"])) {
                unset($array["Group_reference"][$i]);
                unset($array["Group_test"][$i]);
            }
        }

        /*Part about create/write the design.tab file*/

        $pathFolderMetada = SYSTEM_DATA_ROOT."/projects/" . $project_id. "/metadata";


        if(file_exists($pathFolderMetada . "/RNA/design.tab")) {
            unlink($pathFolderMetada . "/RNA/design.tab");
        }

        $handle = fopen($pathFolderMetada . "/RNA/design.tab", "a+");
        fwrite($handle, "group1"."\t" . "group2" . "\n");

        for ($i=0;$i<count($array["Group_reference"]);$i++){
            fwrite($handle,$array["Group_reference"][$i] . "\t" . $array["Group_test"][$i] . "\n");
        }

        fclose($handle);

		return true;

        //print_r($array);
    }

    public function delete_group_already_define($group_id=0, $project_id=0)
    {
        /*Verification*/
        if($group_id < 0 ){
            return false;
        }

        /*Verification*/
        if($project_id < 0 ){
            return false;
        }

//        echo $group_id;

        $this->db->query("DELETE FROM `groups` WHERE `group_id`={$group_id} ");

        return true;
    }

    public function Write_tab_file_rna($array, $project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return false;
        }

        /*Part about create/write the samples.tab file*/

        $pathFolderMetadaRna = SYSTEM_DATA_ROOT."/projects/" . $project_id. "/metadata/RNA";

        if(file_exists($pathFolderMetadaRna . "/samples.tab")) {
            unlink($pathFolderMetadaRna . "/samples.tab");
        }

        $handle = fopen($pathFolderMetadaRna . "/samples.tab", "a+");
        fwrite($handle, "ID"."\t" . "name" . "\t" . "Condition" . "\n");

        foreach ($array as $line) {
            fputcsv($handle, $line, "\t");
        }

        fclose($handle);

        return true;

    }

    public function Write_tab_file_chip($array, $project_id=0)
    {
        /*Verification*/
        if($project_id < 0 ){
            return false;
        }

        /*Part about create/write the samples.tab file*/

        $pathFolderMetadaChIP = SYSTEM_DATA_ROOT."/projects/" . $project_id. "/metadata/ChIP";

        if(file_exists($pathFolderMetadaChIP . "/samples.tab")) {
            unlink($pathFolderMetadaChIP . "/samples.tab");
        }

        $handle = fopen($pathFolderMetadaChIP . "/samples.tab", "a+");
        fwrite($handle, "ID"."\t" . "type" . "\t" . "Condition" . "\n");

        foreach ($array as $line){
            fwrite($handle,$line[0]. "\t" . "treated" . "\t" . $line[2]. "\n");
            fwrite($handle,$line[1]. "\t" . "input" . "\t" . $line[2]. "\n");
        }

        /*foreach ($array as $line) {
            fputcsv($handle, $line, "\t");
        }*/


        fclose($handle);

        return true;

    }


	public function searchDir($base_dir=SYSTEM_UPLOAD_ROOT,$p="",$f="",$allowed_depth=-1){
		$contents=array();

		$base_dir=trim($base_dir);
		$p=trim($p);
		$f=trim($f);

		if($base_dir=="")$base_dir="./";
		if(substr($base_dir,-1)!="/")$base_dir.="/";
		$p=str_replace(array("../","./"),"",trim($p,"./"));
		$p=$base_dir.$p;

		if(!is_dir($p))$p=dirname($p);
		if(substr($p,-1)!="/")$p.="/";

		if($allowed_depth>-1){
			$allowed_depth=count(explode("/",$base_dir))+ $allowed_depth-1;
			$p=implode("/",array_slice(explode("/",$p),0,$allowed_depth));
			if(substr($p,-1)!="/")$p.="/";
		}

		$filter=($f=="")?array():explode(",",strtolower($f));

		$files=@scandir($p);
		if(!$files)return array("contents"=>array(),"currentPath"=>$p);

		for ($i=0;$i<count($files);$i++){
			$fName=$files[$i];
			$fPath=$p.$fName;

			$isDir=is_dir($fPath);
			$add=false;
			$fType="folder";

			if(!$isDir){
				$ft=strtolower(substr($files[$i],strrpos($files[$i],".")+1));
				$fType=$ft;
				if($f!=""){
					if(in_array($ft,$filter))$add=true;
				}else{
					$add=true;
				}
			}else{
				if($fName==".")continue;
				$add=true;

				if($f!=""){
					if(!in_array($fType,$filter))$add=false;
				}

				if($fName==".."){
					if($p==$base_dir){
						$add=false;
					}else $add=true;

					$tempar=explode("/",$fPath);
					array_splice($tempar,-2);
					$fPath=implode("/",$tempar);
					if(strlen($fPath)<= strlen($base_dir))$fPath="";
				}
			}

			if($fPath!="")$fPath=substr($fPath,strlen($base_dir));
			if($add)$contents[]=array("fPath"=>$fPath,"fName"=>$fName,"fType"=>$fType);
		}

		$p=(strlen($p)<= strlen($base_dir))?$p="":substr($p,strlen($base_dir));
		return array("contents"=>$contents,"currentPath"=>$p);
	}


	// {{{ __destruct()
	public function __destruct()
	{
		parent::__destruct();
	}
	// }}}
}

?>
