<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
    $this->load->config('twilio');
    $this->load->helper('my-twilio-helper');
    $service = get_twilio_service();

		$from = $this->config->item('phone_number');
		$to = '9045140079';
		$message = $this->input->get('message', TRUE);

		$response = $service->account->messages->sendMessage(
      $from, // From a valid Twilio number
      $to, // Text this number
      $message
    );

    $data = array('message' => '');
		if($response->IsError)
			$data['message'] =  'Error: ' . $response->ErrorMessage;
		else
			$data['message'] =  'Sent message to ' . $to;
		$this->load->view('welcome_message', $data);
	}

  public function call()
  {
    $this->load->config('twilio');
    $this->load->helper('my-twilio-helper');
    $client = get_twilio_service();

    $from = $this->config->item('phone_number');
    //$to = '9045140079';
    $to = '6785770937';

    $call = $client->account->calls->create(
      $from, // From a valid Twilio number
      $to, // Call this number

      // Read TwiML at this URL when a call connects (hold music)
      'http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient'
    );
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
