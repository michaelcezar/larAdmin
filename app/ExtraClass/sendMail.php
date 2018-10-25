<?php

namespace App\ExtraClass;

use Mail;
use Session;

class sendMail {

	public $email_layout;
	public $from_mail;
	public $from_name;
 	public $to_mail;
 	public $to_name;
 	public $subject;
 	public $bodyMessage;

 	public function send(){
 		if ($this->from_mail == ''){
 			if (!(session()->has('userId'))){
				$this->from_mail    = config('mail.from.address');
				$this->from_name    = config('mail.from.name');
			} else {
				$this->from_mail    = Session::get('userMail');
				$this->from_name    = Session::get('userName');
			}
 		}

 		$fromMail    = $this->from_mail;
 		$fromName    = $this->from_name;
 		$toMail      = $this->to_mail;
 		$toName      = $this->to_name;
 		$subjectMail = $this->subject;
 		$data        = array (
        	'bodyMessage' => $this->bodyMessage
        );
 		$layout      = $this->email_layout;

		Mail::send($layout , $data, function ($message) use ($fromMail, $fromName, $toMail, $toName, $subjectMail) {
            $message->from($fromMail, $fromName);
            $message->to($toMail, $toName);
            $message->subject($subjectMail);
        });

		if (count(Mail::failures()) > 0){
			return 0;
		} else {
			return 1;
		}
 	}
}
