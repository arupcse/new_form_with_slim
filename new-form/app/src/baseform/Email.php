<?php
/**
 * This class contains all the actions related to email
 * @author Arup Kumar Sarker (asarker@swin.edu.au)
 * Created Date: 2017-07-12 14:10
 */

// namespace Swinburne\Legacy;
namespace Base;

use Monolog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Email
{
    private $email_settings;
    private $student_headers;
    private $admin_headers;
    private $upload_dir;
    private $error_log;


    // function __construct($settings,$monolog)
    function __construct($settings,$monolog)
    {
        $this->email_settings  = $settings;
        $this->student_headers = $settings['email_student'];
        $this->admin_headers   = $settings['email_admin'];
        $this->upload_dir      = $settings['uploadeddir']['path'];
        $this->error_log       = $monolog;
    }

    /**
    * Sending email using swift email version 5.4
    *
    * @param array $email_settings -retrieve from, to, cc, bcc and subject
    * @param string $message_body - Email body
    * @param string $file_name
    * @param String $csv_String - data to write into the csv file
    *
    * @return True if email send is successful otherwise False
    */
    function sendEmail(array $email_settings, $message_body, $file_name, $csv_String = '')
    {

       $transport = new \Swift_SmtpTransport('localhost', 25);
      //  $transport = \Swift_SmtpTransport::newInstance('localhost', 25);

      //creat the mailer using the transport
      $mailer = new \Swift_Mailer($transport);
      // $mailer = \Swift_Mailer::newInstance($transport);

      // create the message
     // create the new Instance for $email_settings
      $message = new \Swift_Message($email_settings['subject']);

      if (strlen($csv_String)>0) {
          // create the CSV file attachment on run time
           $attachment =new \Swift_Attachment($csv_String, $file_name, 'application/csv');
           if ($attachment) {
               $message -> attach($attachment);
           }
      } else {
          if (is_array($file_name)) {
              foreach ($file_name as $key => $value) {
                   $attachment = \Swift_Attachment::fromPath($this->upload_dir  .'/'. $value) -> setFilename($value);
                   //   including the attachment
                   if ($attachment) {
                       $message -> attach($attachment);

                       // Encode data with MIME base64 and Split a string into smaller chunks
                       // $message -> attach(chunk_split(base64_encode($attachment)));
                   }
              }
          }
          // create the attachment and call its name with setFilename() method
        //    $attachment = \Swift_Attachment::fromPath($this->upload_dir  .'/'. $file_name) -> setFilename($file_name);
      }

      // create the attachment and call its name with setFilename() method
    //    $attachment = \Swift_Attachment::fromPath($this->upload_dir  .'/'. $file_name) -> setFilename($file_name);



      $email_header_error_msg = array();
        //   validation for email From
          if ($email_settings['from']) {
              try {
                  $message-> setFrom($email_settings['from']);
              } catch (\Swift_RfcComplianceException  $e) {
                   $email_header_error_msg['From'] = $e->getMessage();

              }
          } else {
              $email_header_error_msg['From'] = 'Email From is empty!';
          }

        //   validation for email To
          if ($email_settings['to']) {
              try {
                  $message-> setTo($email_settings['to']) ;
              } catch (\Swift_RfcComplianceException  $e) {
                  $email_header_error_msg['To'] = $e->getMessage();
              }
          } else {
               $email_header_error_msg['To'] = 'Email To is empty!';
          }

        //   validation for email Cc
        if ($email_settings['cc'] != '') {
            try {
                $message-> setCc($email_settings['cc']);
            } catch (\Swift_RfcComplianceException  $e) {

                 $email_header_error_msg['Cc'] = $e->getMessage();
            }
        }

        // validation for email Bcc
        if ($email_settings['bcc'] != '') {
            try {
                $message-> setBcc($email_settings['bcc']);
            } catch (\Swift_RfcComplianceException  $e) {
                $email_header_error_msg['Bcc'] = $e->getMessage();
            }
        }

        // setting the email message
          $message -> setBody($message_body, 'text/html');   // give a body and mark the content-type as HTML




        //  call send method to send email
        try {

            $result = $mailer -> send($message);
            // $result = $mailer -> send($message);
        }catch (\Swift_TransportException $Ste) {
            // $email_header_error_msg['Email-Send'] = $Ste->getMessage();
            $this->error_log ->error("Email-Send:", array($Ste->getMessage()));
            $email_header_error_msg['email_send'] = $Ste->getMessage();
        }

        if (!empty($email_header_error_msg)) {
            foreach ($email_header_error_msg as $key => $value) {
                $this->error_log->error($key .":", array($value));
            }
        }

        // if ($result) {
        //     return TRUE;
        // } else {
        //     return FALSE;
        // }
        return $email_header_error_msg;
    }  // End of function



    /**
    * Discard this function - it is not used anymore
    * createEmail creates the email body as well as retrieves email receivers
    * and senders from the settings_email.php file
    * @param array $input_fields - the input fields passed through the Form
    * @param FILE $uploaded_file_name - the name of the input field for upload
    * @return bool $status - True is send email is successful
    */
    /*
    public function createEmail($posted_data)
    {

      $message_body = '<div style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">
                        <h3 style="color: #C00000;">
                          <strong>Information from legacy form</strong>
                        </h3>
                        <p><strong>Full Name :</strong> '. $posted_data['full_name'] .'</p>'
                        .'<p><strong>Email Address :</strong> '. $posted_data['email'] .'</p>'
                        .'<p><strong>Comments :</strong> '. $posted_data['comments'] .'</p>'
                        .'<p><strong>Student Type :</strong> '. $posted_data['student_type'] .'</p>'
                        .'<p><strong>Student Interest :</strong> '. ucfirst(implode(',', $posted_data['student_interest'])) .'</p>'
                        .'<p><strong>Campus :</strong> '. $posted_data['campus'] .'</p>'
                        .'<p><strong>Faculty :</strong> '. implode(',', $posted_data['faculty']) .'</p>'
                      .'</div>';

        if(!empty($this->student_headers) && !empty($this->admin_headers))
        {
          // sendEmail($config, $message_body, $uploaded_file_name, $log);
         $student_email = $this-> sendEmail($this->student_headers, $message_body, $posted_data['file_to_upload']);
         $admin_email   = $this-> sendEmail($this->admin_headers, $message_body, $posted_data['file_to_upload']);
        }
        return $student_email && $admin_email;
    }*/
} // End of Class
