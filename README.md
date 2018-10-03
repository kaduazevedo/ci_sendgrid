## Sendgrid API library for Codeigniter 3
A simple, lightweight, minimalist, mini, tyni Codeigniter 3 library that implements Sendgrid API V3.

##Features

- Support Sendgrid Templates amd Dynamic data parse;
- File attachment;
- Sending schedule;

## Requirements

- Codeigniter 3.x
- Sendgrid account
- PHP Curl extension

## Usage


		$this->load->library('Sendgrid');

		# You can add many "to:" using this method.
		$this->sendgrid->to('someone@example.com', 'Someone');

		$this->sendgrid->from('no-reply@example.com', 'Sender');

		$this->sendgrid->reply_to('me@example.com', 'It´s me, Mario');

		# You can use the "cc" and "bcc" methods too, as above.

		# Schedule the message send passing a timestamp or a "Y-m-d H:i:s" format date
		$this->sendgrid->send_at(1538502150);
		
		# Use a Sendgrid template (see Sendgrid templates documentation)
		$this->sendgrid->template('TEMPLATE ID');

		# You can pass dynamic data to parse into your template
		$this->sendgrid->template_data('personal_text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
		
		# The Subject (note that if you are using Templates and defined the subject at
		# template setting, this field will be ignored and the template subject will be 
		# used instead)
		$this->sendgrid->subject('A cool nice example');

		# The message content (note that if you are using Templates this field will
		# be ignored, but is always required)
		$this->sendgrid->content('text/plain', 'My very nice example content... CI Rulezz!');

		# You can attach files by passing the absolute path
		$this->sendgrid->attach('./somefile.pdf');

		# Lets go!
		$this->sendgrid->send();
