<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller {

	public function send(){

		$this->load->library('Sendgrid');

		$this->sendgrid->to('to-email@example.com', 'Some Name');

		$this->sendgrid->from('sender@example.com', 'Sender Name');

		$this->sendgrid->reply_to('reply-to@example.com', 'Sender Name');

		// In case you want to set a date/time to schedule the email send, uncomment the line above, usign a timestamp to set it.
		//$this->sendgrid->send_at(<<TIMESTAMP>>);
		
		// Using Sendgrid templates (see Sendgrid documentation)
		//$this->sendgrid->template('d-984ba3d47f944f84b4b98ad45e7cc7d6');

		//Using Dynamic Data to set information to templates
		//$this->sendgrid->template_data('personal_text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vehicula tellus enim, ut ultricies est varius id. Aliquam et velit sit amet urna accumsan ornare. Mauris nisi ligula, tempor bibendum lacus eu, mollis euismod libero. Nam hendrerit odio dui, condimentum tincidunt sapien cursus a. Ut a malesuada est. Etiam iaculis nunc quis mi dapibus iaculis. Integer pretium ex ac feugiat elementum.');

		$this->sendgrid->subject('Nevermind, just a test!');
		$this->sendgrid->content('text/plain', 'This test is quite correct ;)');

		$this->sendgrid->send();

	}
}
