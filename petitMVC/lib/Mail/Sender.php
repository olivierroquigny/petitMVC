<?php

namespace lib\Mail;

/**
 * Aggregate and send a mail
 * @author Olivier Roquigny
 */
class Sender{
	public $to;
	public $from;
	public $replyTo;
	public $subject;
	public $text;
	public $html;
	public $charset = 'UTF-8';
	private $headers;
	private $message;
	private $boundary;

	/**
	 * Constructor init the mail, and send it if asked for.
	 * @param config
	 *   an array to configure the mail
	 * @param send
	 *   for directly send (or not) the mail
	 */
	public function __construct($config = null, $send = true) {
		$this->boundary = '_-----_-----_bound_' . uniqid();
		if($config !== null){
			$this->init($config);
			if($send === true){
				$this->initAndSend($config);
			}
		}
	}

	/**
	 * Init the mail
	 * @param config
	 *   array of config values
	 */
	protected function init($config) {
		if(isset($config['to'])){
			$this->to = $config['to'];
		}
		if(isset($config['subject'])){
			$this->subject = $config['subject'];
		}
		if(isset($config['text'])){
			$this->text = $config['text'];
		}
		if(isset($config['html'])){
			$this->html = $config['html'];
		}
		if(isset($config['from'])){
			$this->from = $config['from'];
		}
		if(isset($config['replyTo'])){
			$this->replyTo = $config['replyTo'];
		}
		if(isset($config['charset'])){
			$this->charset = $config['charset'];
		}
		$this->headers = '';
		$this->message = '';
	}

	/**
	 * Concat the diffrent part of the mail
	 */
	protected function concat() {
		$this->headers .= "MIME-Version : 1.0\r\n";
		$this->headers .= 'Content-Type : multipart/alternative; boundary="' . $this->boundary . "\"\r\n";
		if($this->replyTo !== ''){
			$this->headers .= 'Reply-To : ' . $this->cleanHeader($this->replyTo) . "\r\n";
		}
		if($this->from !== ''){
			$this->headers .= 'From : ' . $this->cleanHeader($this->from) . "\r\n";
		}
		if($this->text === "" && $this->html === ""){
			throw new Exception('Email::concat() you must enter text or/and html values.');
		}

		if(isset($this->text) && $this->text !== ""){
			$this->message .= '--' . $this->boundary . "\r\n";
			$this->message .= 'Content-Type : text/plain; charset="' . $this->cleanHeader($this->charset) . "\"\r\n";
			$this->message .= "Content-Transfer-Encoding : 8bit\r\n";
			$this->message .= "\r\n";
			$this->message .= $this->cleanBody($this->text) . "\r\n";
		}
		if(isset($this->html) && $this->html !== ""){
			$this->message .= '--' . $this->boundary . "\r\n";
			$this->message .= 'Content-Type : text/html; charset="' . $this->cleanHeader($this->charset) . "\"\r\n";
			$this->message .= "Content-Transfer-Encoding : 8bit\r\n";
			$this->message .= "\r\n";
			$this->message .= $this->cleanBody($this->html, true) . "\r\n";
		}	
		$this->message .= '--' . $this->boundary . "--\r\n";		
	}

	/**
	 * Send the mail
	 * @throw Exception if there is a problem to send the mail
	 */
	protected function send(){
		$internal_encoding = mb_internal_encoding();
		mb_internal_encoding('UTF-8');
		$subject = mb_encode_mimeheader($this->cleanHeader($this->subject, 'UTF-8'));
		mb_internal_encoding($internal_encoding);
		if(false === mail($this->to, $subject, $this->message, $this->headers)){
			throw new Exception('Email::send() There is a probleme to send email ...');
		}
	}

	/**
	 * Init, concat and send the mail
	 * @param config
	 *   an array of config key value
	 */
	public function initAndSend($config){
		$this->init($config);
		$this->concat();
		$this->send();
	}

	/**
	 * @TODO
	 * Filter the body of the mail
	 * @param str
	 *   the body as a string
	 * @param html
	 *   if it's html or not
	 * @return string
	 */
	protected function cleanBody($str, $html = false){
		// TODO: whitelist the body charaters
		/**********************************************
		http://tools.ietf.org/html/rfc5322#section-2.3
		2.3.  Body

		   The body of a message is simply lines of US-ASCII characters.  The
		   only two limitations on the body are as follows:

		   o  CR and LF MUST only occur together as CRLF; they MUST NOT appear
		     independently in the body.
		  o  Lines of characters in the body MUST be limited to 998 characters,
		     and SHOULD be limited to 78 characters, excluding the CRLF.

		     Note: As was stated earlier, there are other documents,
		      specifically the MIME documents ([RFC2045], [RFC2046], [RFC2049],
		     [RFC4288], [RFC4289]), that extend (and limit) this specification
		     to allow for different sorts of message bodies.  Again, these
		      mechanisms are beyond the scope of this document.
		***********************************************/

		// put it in a filter class ?
		
		return $str;
	}

	/**
	 * @TODO
	 * Filter the headers of the mail
	 * @param str
	 *   the headers as a string
	 * @return string
	 */
	protected function cleanHeader($str){
		/**********************************************
		// TODO: whitelist the header charaters
		http://tools.ietf.org/html/rfc5322#section-2.2
		2.2.  Header Fields

		 Header fields are lines beginning with a field name, followed by a
		 colon (":"), followed by a field body, and terminated by CRLF.  A
		 field name MUST be composed of printable US-ASCII characters (i.e.,
		 characters that have values between 33 and 126, inclusive), except
		 colon.  A field body may be composed of printable US-ASCII characters
		 as well as the space (SP, ASCII value 32) and horizontal tab (HTAB,
		 ASCII value 9) characters (together known as the white space
		 characters, WSP).  A field body MUST NOT include CR and LF except
		 when used in "folding" and "unfolding", as described in section
		 2.2.3.  All field bodies MUST conform to the syntax described in
		 sections 3 and 4 of this specification.
		// :
		// a-z A-Z 0-9  ! # $ % & ' * + - / = ? ^ _ ` { | } ~
		***********************************************/
		// TODO put it in a filter class ?

		return str_replace(array("\n", "\r", "\0"), '', $str);
	}

	/**
	 * @TODO
	 * Filter an email adress
	 * @param str
	 *   the body as a string
	 * @return string
	 */
	protected function cleanAdress($str){
		// TODO: whitelist the email adress charaters
		// a-z A-Z 0-9 ! # $ % & ' * + - / = ? ^ _ ` { | } ~

		// TODO put it in a filter class ?

		return str_replace(array(" ", "\t", "\n", "\r", "\0", "\x0B"), '', $str);
	}

}
