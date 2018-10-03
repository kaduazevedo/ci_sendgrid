<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller {

	public function send()
	{

		# Load de library
		$this->load->library('Sendgrid');

		# You can add many "to:" using this method.
		$this->sendgrid->to('someone@example.com', 'Someone');

		$this->sendgrid->from('no-reply@example.com', 'No Reply');

		$this->sendgrid->reply_to('itsme@example.com', 'Me');

		# You can use the "cc" and "bcc" methods too, as above.

		# Schedule the message send passing a timestamp or a "Y-m-d H:i:s" format date
		$this->sendgrid->send_at(1538502150);
		
		# Use a Sendgrid template (see Sendgrid templates documentation)
		$this->sendgrid->template('<<<TEMPLATE ID>>>');

		# You can pass dynamic data to parse into your template
		$this->sendgrid->template_data('personal_text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vehicula tellus enim, ut ultricies est varius id. Aliquam et velit sit amet urna accumsan ornare. Mauris nisi ligula, tempor bibendum lacus eu, mollis euismod libero. Nam hendrerit odio dui, condimentum tincidunt sapien cursus a. Ut a malesuada est. Etiam iaculis nunc quis mi dapibus iaculis. Integer pretium ex ac feugiat elementum.');
		
		# The Subject (note that if you are using Templates and defined the subject at
		# template setting, this field will be ignored and the template subject will be 
		# used instead)
		$this->sendgrid->subject('A cool nice example');

		# The message content (note that if you are using Templates this field will
		# be ignored, but is always required)
		$this->sendgrid->content('text/plain', 'My very nice example content... CI Rulezz!');

		# Lets go!
		$this->sendgrid->send();

	}
}
