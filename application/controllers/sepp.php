    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class SEPP extends CI_Controller
    {
        public function text()
        {
            $this->load->config('twilio');
            $this->load->helper('twilio');
            $service = get_twilio_service();
            $from = $this->config->item('phone_number');
            $to = '6785770937';
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
        }

      public function call()
      {
        $this->load->config('twilio');
        $this->load->helper('twilio');
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

      public function walkscore()
      {
        $this->load->library("html_dom");
        $lat = $this->input->get('lat', TRUE);
        $long = $this->input->get('long', TRUE);



        $c = curl_init();
        $walkscore_api = "http://www.walkscore.com/score/123-asd/lat=$lat/lng=$long";
        curl_setopt($c, CURLOPT_URL, $walkscore_api);
        curl_setopt($c,CURLOPT_HTTPHEADER,array('Expect:'));
        curl_setopt($c,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($c,CURLOPT_FOLLOWLOCATION,true);
        $page = curl_exec($c);

        $this->html_dom->loadHTML($page);
        $dom_element = $this->html_dom->find('#score-description-sentence', 0);

        preg_match('#[0-9]{1,3}#', $dom_element->getInnerText(), $walkscore);
        $walkscore = intval($walkscore[0]);
        $message = "";
        if ($walkscore < 30)
          $message = "Dangerous";
        else if ($walkscore < 60)
          $message = "Be careful";
        else
          $message = "Safe";
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('walkscore' => $walkscore, 'message' => $message)));
      }

      public function email()
      {
          $url = 'https://api.sendgrid.com/';
          $user = 'thanhquanky';
          $pass = 'HackDuke2014';
          $to = $this->input->get('email', TRUE);
          $subject = 'SOS! Please call 911!';
          $text = '';
          $text = $this->input->get('message', TRUE);
          $params = array(
              'api_user'  => $user,
              'api_key'   => $pass,
              'to'        => 'cding9@gatech.edu',
              'subject'   => $subject,
              'text'      => $text,
              'from'      => 'thanhquanky@gatech.edu'
          );


          $request =  $url.'api/mail.send.json';

          // Generate curl request
          $session = curl_init($request);
          // Tell curl to use HTTP POST
          curl_setopt ($session, CURLOPT_POST, true);
          // Tell curl that this is the body of the POST
          curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
          // Tell curl not to return headers, but do return the response
          curl_setopt($session, CURLOPT_HEADER, false);
          curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

          // obtain response
          $response = curl_exec($session);
          curl_close($session);
      }

      public function setting()
      {
        $this->load->view('sepp_settings');
      }
    }
