<?php

Class Sendgrid{

	private $to_args 		= array();
	private $cc_args 		= array();
	private $bcc_args 		= array();

	private $from_args 		= null;

	private $reply_to_args 	= null;

	private $content_args 	= array();

	private $template_id 	= null;

	private $dynamic_data 	= null;

	private $subject_str 	= null;

	private $apikey 		= null;

	private $send_at		= null;


	public function __construct($params = null){

		$this->CI =& get_instance();
		$this->CI->config->load('sendgrid');

		$this->apikey = $params['apikey'];		

	}

	public function to($email, $name){

		$to = new StdClass;

		$to->email 	= $email;
		$to->name 	= $name;

		$this->to_args[] = $to;

	}

	public function cc($email, $name){

		$cc = new StdClass;

		$cc->email 	= $email;
		$cc->name 	= $name;

		$this->cc_args[] = $cc;

	}

	public function bcc($email, $name){

		$bcc = new StdClass;

		$bcc->email 	= $email;
		$bcc->name 		= $name;

		$this->bcc_args[] = $bcc;

	}

	public function send_at($timestamp){

		$this->send_at = $timestamp;
		
	}

	public function from($email, $name){

		$from = new StdClass;

		$from->email 	= $email;
		$from->name 	= $name;

		$this->from_args = $from;

	}

	public function reply_to($email, $name){

		$reply_to = new StdClass;

		$reply_to->email 	= $email;
		$reply_to->name 	= $name;

		$this->reply_to_args = $reply_to;

	}

	public function template($id){

		$this->template_id = $id;

	}

	public function template_data($key, $value){

		if(!$this->dynamic_data){
			$this->dynamic_data = new StdClass;
		}

		$this->dynamic_data->{$key} = $value;

	}

	public function subject($subject){

		$this->subject_str = $subject;

	}

	public function content($type, $value){

		$content = new StdClass;

		$content->type 		= $type;
		$content->value 	= $value;

		$this->content_args[] = $content;

	}

	private function mount(){

		$params = new StdClass;

		$params->personalizations = array();

		$personalization = new StdClass;

		$personalization->to 	= $this->to_args;
		if($this->cc_args){
			$personalization->cc 	= $this->cc_args;
		}

		if($this->bcc_args){
			$personalization->bcc 	= $this->bcc_args;
		}

		$params->from = $this->from_args;

		$params->reply_to = $this->reply_to_args;

		$params->content = $this->content_args;

		if($this->template_id){
			
			$params->template_id = $this->template_id;
			
			if($this->dynamic_data){
				$personalization->dynamic_template_data = $this->dynamic_data;
			}

		}

		$personalization->subject = $this->subject_str;

		if($this->send_at){
			$params->send_at = $this->send_at;
		}

		$params->personalizations[] = $personalization;

		return json_encode($params);

	}

	public function send(){

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
		curl_setopt($ch, CURLOPT_POST, true);

		$headers = [
		   'authorization: Bearer '.$this->apikey,
		   'Content-Type: application/json'
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->mount());
		
		$result = curl_exec($ch);

		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$result_obj = json_decode($result);

		$data_result['code'] = $httpcode;

		if(isset($result_obj->errors)){
			$data_result['errors'] = $result_obj->errors;
		} else {
			$data_result['errors'] = null;
		}

		return $data_result;

	}

}