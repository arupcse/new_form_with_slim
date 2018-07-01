<?php

namespace Base;

// require_once('get_ip_country.php');

use Slim\Router;
use Slim\Flash\Messages as FlashMessages;
use Slim\Views\PhpRenderer;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use Monolog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Interop\Container\ContainerInterface;
use Dotenv\Dotenv;


// use Upload;

class BaseForm
{
    private $view;
    private $router;
    private $flash;
    private $validation_rules;
    private $validation_msg;
    private $email_settings;
    private $log;
    private $data;
    private $csrf;

    // private $dotenv;


    // public function __construct(PhpRenderer $renderer, Router $router, FlashMessages $flash,  $settings, $monolog)
    public function __construct(ContainerInterface $container)
    {
        // $this->view             = $renderer;
        // $this->router           = $router;
        // $this->flash            = $flash;
        // $this->settings         = $settings;
        // $this->log = $monolog;

        $this->view             = $container->get('renderer');
        $this->router           = $container->get('router');
        $this->flash            = $container->get('flash');
        $this->settings         = $container->get('settings');
        $this->db               = $container->get('FormInsertModel');
        $this->dbAdmin          = $container->get('adminModel');
        $this->fileUpload       = $container->get('fileUpload');
        $this->emailHandler     = $container->get('sendEmail');
        $this->log              = $container->get('monolog');
        $this->validation_rules = $this->settings['validation_rules'];
        $this->validation_msg   = $this->settings['validation_msg'];
        $this->csrf             = $container->get('csrf');
        // $this->dotenv        = $container->get('dotenv');


        // get all the default settings for templates
        $this->data = array(
            'settings'         =>$this->settings,
            'window_title'     =>$this->settings['header']['windowTitle'],
            'page_title'       =>$this->settings['header']['pageTitle'],
            'form_title'       =>$this->settings['header']['formTitle'],
            'form_description' =>$this->settings['header']['formDescription'],
            'meta_robots'      =>$this->settings['header']['metaRobots'],
            'meta_description' =>$this->settings['header']['metaDescription'],
            'meta_keywords'    =>$this->settings['header']['metaKeywords']
        );
    }

    /**
     * Function to call the form
     *
     * @param Request $request
     * @param response $response
     */
    public function legacyForm($request, $response)
    {
        // Load header
        $this->view->render($response, 'templates/public/header.php', $this->data);

        // echo "<pre>";
        // echo "CONTROLLER" . "\n";
        // echo "MY_this" . var_dump($this) . "\n";
        // echo "MY_response" . var_dump($response) . "\n";
        // echo "MY_request" . var_dump($request). "\n";
        // echo "MY_request" . var_dump($request->getParsedBody()). "\n";
        // echo "</pre>";

        // echo "<pre>";
        // echo "POST: ". print_r($_POST, TRUE);
        // echo "FILES: ". print_r($_FILES, TRUE);
        //  echo "SESSION: ". print_r($_SESSION, TRUE);
        //  echo "classes: " .  print_r(get_declared_classes(), TRUE);
        //  echo "included: " .  print_r(get_included_files(), TRUE);
        //  echo "required: " .  print_r(get_required_files(), TRUE);
        // echo "</pre>";

        // CSRF token name and value
        $this->data['csrf_name_key']  = $this->csrf->getTokenNameKey();
        $this->data['csrf_value_key'] = $this->csrf->getTokenValueKey();
        $this->data['cs_name']        = $request->getAttribute($this->data['csrf_name_key']);
        $this->data['cs_value']       = $request->getAttribute($this->data['csrf_value_key']);
        $_SESSION['cs_value']         = $this->data['cs_value'];

        $this->data['DB_USERNAME']     = $this->settings['db']['username'];
        $this->data['DB_PASSWORD']     = $this->settings['db']['password'] ;


        $request_data = $request->getParsedBody();

        if (!$request_data) {
            $_SESSION['start_time'] = time();

        //   $this->view->render($response, 'templates/public/header.php', $this->data);
          $this->view->render($response, 'form.php', $this->data);
        //   $this->view->render($response, 'templates/public/footer.php', $this->data);
        }

        // if($_POST['submit_button'] == 'Submit')
        if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST')
        {
          $_SESSION['end_time'] = time();

          // defining error_msg_array
          $error_msg_array = array();
          $posted_data = array();

          // File upload
          if(!empty($_FILES)){

            $get_upload_info 	= array();
            $uploaded_file_name = array();
            foreach ($_FILES as $key => $files) {
                // validate file upload
                // if(!empty($_FILES[$key]['name'])){
                // if(!$file){
                    $get_upload_info            = $this->fileUpload->validateFileUpload($key);
                    $error_msg_array[$key]      = $get_upload_info['error'];
                    $uploaded_file_name[$key]   = $get_upload_info['file_name'];
                    $posted_data[$key]          = $get_upload_info['file_name'];
                // }
            }
          }

           // validate the input fields for error
          foreach ($this->validation_rules as $key => $value) {
            $error_msg_array[$key] = $this -> vlidateFormInputs($request_data[$key], $value);
          }

          if (empty(array_filter($error_msg_array))) {

              // insert values into the database table
              $table = $this->settings['db']['table_name'];
            //   $table = "meedo_test";

              // get the poseted values

                foreach ($this->validation_rules as $field_name => $value) {
                  $posted_data[$field_name] = $request_data[$field_name];
                }

              $extra_user_info = $this->getExtraInformation();    // get browser, os and device information
              $posted_data = array_merge($posted_data, $extra_user_info); // merge the extra info with posted form value

              $this->data['medoo_insert_message'] = $this->db->formInsertModel($table,$posted_data);
            //   $this->data['medoo_insert_message'] = $this->db->formInsertModel($table,$posted_data, $uploaded_file_name);

            //   if insert is successful, Send email to the senders
              if ($this->data['medoo_insert_message']) {

                  //   Send email to user
                  $message_content = $this->view->fetch('templates/email/LegacyFormBaseEmail.php', $posted_data);
                  //   $email_send_error = $this->emailHandler->createEmail($posted_data);
                  $email_headers = $this->settings['email_student'];

                  $email_headers['to'] = $posted_data['email'];
                  $email_send_error = $this->emailHandler->sendEmail($email_headers, $message_content, $uploaded_file_name);

                  //   Send email to Admin
                //   $message_content = $this->view->fetch('templates/email/LegacyFormBaseEmail.php', $posted_data);
                //   $email_send_error = $this->emailHandler->sendEmail($this->settings['email_admin'], $message_content, $posted_data['file_to_upload']);

                  //  if email sending successful then show the thankyou page
                  if (!$email_send_error) {
                      $uri = $request->getUri()->withPath($this->router->pathFor('thankyou'));
                      return $response->withRedirect((string)$uri);
                  }else{

                      $this->data['email_error'] = $email_send_error;
                    //   $this->view->render($response, 'templates/public/header.php', $this->data);
                      $this->view->render($response, 'EmailError.php', $this->data);
                    //   $this->view->render($response, 'templates/public/footer.php', $this->data);

                    //   $uri = $request->getUri()->withPath($this->router->pathFor('emailError'));
                    //   return $response->withRedirect((string)$uri);
                    //   $this->emailError($request, $response, $email_send_error);
                  }
              }

          }else{
            $this->data['error_message_array'] = $error_msg_array;
            // $this->view->render($response, 'templates/public/header.php', $this->data);
            $this->view->render($response, 'form.php', $this->data);
            // $this->view->render($response, 'templates/public/footer.php', $this->data);

            // log the error message for form validation failure
            foreach ($error_msg_array as $key => $value) {
                if (Trim($value)) {
                    $this->log -> debug($key.":", array(trim($value)));
                }
            }
        }
      }   // end of if($_POST[submit_button] == 'Submit')

    //   Load footer
    $this->view->render($response, 'templates/public/footer.php', $this->data);

  }   //end of function legacyForm()

    /** function to validate input fields and (file upload)
     *
     *   @param array $rules to validate the input fields
     *   @param array $field - values passsed after submit
     *
     *   @return $output - error nessage, if the validation fails
     */
    public function vlidateFormInputs($field, $rules)
    {
      // $output = TRUE;

    	try{
    		 $rules -> assert($field);
    	 } catch(NestedValidationException $ex){
    		 	$custom_error_messages = $ex -> findMessages($this->validation_msg);

        $errors = $ex->getMessages();

        if(count($errors) > 0)
        {
          $output = $errors[0];
        }

        return $output;
    	 }
    }

    /**
    * Render the Thankyou.php page when all inputs are valid and email is sent
    * @param Request $request
    * @param response $response
    * @param array $posted_data - values submitted through form
    */
    public function thankYou($request, $response, $data)
    {
        $data = $this->data;

        $data['goback'] = 'form'; // set the hyperlink for Go Back in view\thankyou.php
        //   $data['session_time_diff'] = strtotime($_SESSION['end_time']) - strtotime($_SESSION['start_time']);
        $data['session_time_diff'] = $_SESSION['end_time']- $_SESSION['start_time'];

        $this->view->render($response, 'templates/public/header.php', $data);
        $this->view->render($response, 'thankyou.php', $data);
        $this->view->render($response, 'templates/public/footer.php', $data);
    }


    /**
    * Render the emailError.php page when sending email fails
    * @param Request $request
    * @param response $response
    * @param array $posted_data - values submitted through form
    */
    public function emailError($request, $response)
    {

        $this->view->render($response, 'templates/public/header.php', $this->data);
        $this->view->render($response, 'EmailError.php', $this->data);
        $this->view->render($response, 'templates/public/footer.php', $this->data);
    }


    /**
    *   Get Extra information from the browser
    *   Reference: https://github.com/WhichBrowser/Parser-PHP
    *   @return array $other_information
    */
    public function getExtraInformation()
    {
        $user_ip      = $this->getUserIpAddress();

        // get Country Name/Code

        $ip_geolocation = $this->get_ip_country($user_ip);
        if (isset ($ip_geolocation->country_name))
		{
			$country_name = $ip_geolocation->country_name;
		}

		if (isset ($ip_geolocation->$country_code))
		{
			$country_code = $ip_geolocation->$country_code;
		}
        // $user_country = $this->getUserLocationByIp($user_ip);

        $result       = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);

        $other_information = array(
            "created_date"          => date("Y-m-d H:i:s"),
            "browser_name"          => $result->browser->name,
            "borwser_version"       => $result->browser->version->toString(),  // Or, $result->browser->version->value
            "os_name"               => $result->os->name,
            "os_type"               => $result->os->version->toString(),
            "device"                => $result->device->type,
            "device_subtype"        => $result->device->subtype,
            "device_manufacturer"   => $result->device->manufacturer,
            "device_model"          => $result->device->model,
            "ip"                    => $user_ip,
            "country"               => $country_name
        );

        return $other_information;
    }
    /**
    * Retrive the current IP address of the client
    * @return string $ip
    */
    public function getUserIpAddress()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }else
        {
            $ip = $remote;
        }

        return $ip;
    }
    /**
     * Find the country of a given IP address - From Ramiro Rosales
     *
     * @return object $o for country code and country name
     */

    public function get_ip_country($ip)
    {
        $o = new \stdClass;
        $o->RESULT = False;

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $p = explode('.', $ip);
            $rev_ip = implode('.',  array_reverse($p));
            $x = dns_get_record($rev_ip . '.country.swin.edu.au', DNS_TXT);
        }
        else if (filter_var($ip,  FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $u = unpack('H*hex', inet_pton($ip));
            $h = $u['hex'];
            $rev_ip = implode('.', array_reverse(str_split($h)));
            $x = dns_get_record($rev_ip . '.country6.swin.edu.au', DNS_TXT);
        }

        if (isset($x[0]['type']) && $x[0]['type'] == 'TXT' && isset($x[0]['txt'])) {
            $ca = explode(';', $x[0]['txt']);
            $o->RESULT = True;
            $o->country_code = $ca[0];
            $o->country_name = $ca[1];
        }

        return($o);
    }

    /**
    *   Get user location (country) based on IP Address - Arup Sarker -Not Active
    *   Ref: http://www.apphp.com/index.php?snippet=php-get-country-by-ip
    *   @param string $ip_address
    *   @return string $country
    */
    public function getUserLocationByIp($ip_address)
    {
        $country = '';
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip_address));

       if($ip_data && $ip_data->geoplugin_countryName != null){
           $country = $ip_data->geoplugin_countryName;
       }
       return $country;
    }

} // End of Class
