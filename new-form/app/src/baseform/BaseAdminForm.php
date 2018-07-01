<?php
// namespace Swinburne\Legacy;
namespace Base;

use Interop\Container\ContainerInterface;

/**
 * all functions related to admin task
 */
class BaseAdminForm
{
    private $data;
    private $router;
    private $settings;
    private $dbAdmin;
    private $view;
    private $log;
    private $emailHandler;


    function __construct(ContainerInterface $container)
    {

        $this->dbAdmin      = $container->get('adminModel');
        $this->router       = $container->get('router');
        $this->settings     = $container->get('settings');
        $this->view         = $container->get('renderer');
        $this->log          = $container->get('monolog');
        $this->emailHandler = $container->get('sendEmail');

        $this->data = array(
            // Admin page settings
            'window_title_admin'     =>$this->settings['header_admin']['windowTitle'],
            'page_title_admin'       =>$this->settings['header_admin']['pageTitle'],
            'form_title_admin'       =>$this->settings['header_admin']['formTitle'],
            'form_description_admin' =>$this->settings['header_admin']['formDescription'],
            'meta_robots_admin'      =>$this->settings['header_admin']['metaRobots'],
            'meta_description_admin' =>$this->settings['header_admin']['metaDescription'],
            'meta_keywords_admin'    =>$this->settings['header_admin']['metaKeywords'],
            'admin_list'             =>$this->settings['admin_list'],
            'file_name_format'       =>$this->settings['csv_file_attributes']
        );

    }
    /**
     * Function to call the Admin form
     *
     * @param Request $request
     * @param response $response
     */
    public function adminForm($request, $response)
    {
        // Load header templates
          $this->view->render($response, 'templates/private/header.php', $this->data);

        $request_data_admin = $request->getParsedBody();
        // if (!$request_data_admin) {
        //     $this->view->render($response, 'AdminForm.php', $this->data);
        // }
        echo "<pre>";
        echo print_r($request_data_admin, TRUE);
        echo "\n" . print_r($_SERVER['REQUEST_METHOD'],TRUE);
        echo "</pre>";


        if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST')
        {
            foreach ($request_data_admin as $field_name => $field_value) {
                echo "Key: ". $field_name ."  Value:  " . $field_value."<br/>";

                if(strpos($field_name, 'continue') >= 0 ) {
                    $var_continue_button = $field_name;
                    // unset($request_data_admin[$field_name]);
                    foreach ($request_data_admin as $name => $value_name) {

                        if($name != $var_continue_button) {
                            if (isset($request_data_admin[$name])){
                                if (in_array($value_name, $this->data['admin_list'])) {
                                    $this->data["admin"] = $value_name;
                                    // $this->data[$name] = $value_name;
                                    $this->view->render($response, 'AdminConfirm.php', $this->data);
                                }
                                else{
                                    $this->data['email_error'] = "Email Not found";
                                    $this->view->render($response, 'AdminForm.php', $this->data);
                                    $this->log -> debug("Admin Email:", array($this->data['email_error']));
                                }
                            } else {
                                // $this->data['email_error'] = "Please select an option";
                                // $this->view->render($response, 'AdminForm.php', $this->data);
                            }
                        }
                    } // end of second loop
                }elseif(strpos($field_name, 'submit') >= 0) {
                    $var_submit_button = $field_name;
                    foreach ($request_data_admin as $name_sub => $value_sub) {
                        if ($name_sub != $var_submit_button) {
                            if (isset($request_data_admin[$name_sub])) {
                                if (in_array($value_sub, $this->data['admin_list'])) {
                                    $this->data['db_select_all']  = $this->dbAdmin->formSelectModel($this->settings['db']['table_name']);

                                    // get the csv file name to attach with email
                                    $file_name = $this->getCSVFileName();

                                    // get the query result as string and pass it to sendDynamicEmail()
                                    $csvString = $this->createCSVData($this->data['db_select_all']);

                                    // get the email settings from setting.email.php
                                    $email_settings       = $this->settings['email_csv'];
                                    $email_settings['to'] = $value_sub;
                                    $message_body         = $this->settings['email_csv']['body'];

                                    // Send email to user (admin) with attached CSV file
                                    $email_send_status = $this->emailHandler->sendEmail($email_settings, $message_body, $file_name, $csvString);

                                    //  if email sending successful then show the thankyou page
                                      if (empty($email_send_status)) {

                                        //  Success - Load the thankyou page
                                          $uri = $request->getUri()->withPath($this->router->pathFor('adminthankyou'));
                                          return $response->withRedirect((string)$uri);

                                      }else{
                                        //   Error - load the EmailError.php page
                                          $this->data['email_error'] = $email_send_status;
                                          $this->view->render($response, 'EmailError.php', $this->data);
                                      }
                                } else{
                                    $this->data['email_error'] = "Email Not found";
                                    // // Load the initial Admin form
                                    $this->view->render($response, 'AdminForm.php', $this->data);
                                }
                            } else {
                                $this->view->render($response, 'AdminForm.php', $this->data);
                            }
                        }
                    }

                }
                else{

                    echo "<br/>Inside else block";
                    // echo "<br/>". $name ." " . $value_name;
                    $this->view->render($response, 'AdminForm.php', $this->data);
                }
        } // End of for loop

    }else{
        // $this->view->render($response, 'AdminForm.php', $this->data);
    }// $_SERVER[$requestpost]
/*
        // if (isset($request_data_admin['users']) && $request_data_admin['continue_button'] == 'continue') {
        if (isset($request_data_admin['continue_button']) && isset($request_data_admin['users'])) {
            // Check whether user in the list or not
            if (in_array($request_data_admin['users'], $this->data['admin_list'])) {
                $this->data['users'] = $request_data_admin['users'];
                $this->view->render($response, 'AdminConfirm.php', $this->data);
            }
            else{
                $this->data['email_error'] = "Email Not found";
                $this->view->render($response, 'AdminForm.php', $this->data);
                $this->log -> debug("Admin Email:", array($this->data['email_error']));
            }

        // }elseif($request_data_admin['submit_button'] == 'submit'){
        }elseif(isset($request_data_admin['submit_button']) && isset($request_data_admin['useremail']) ){
            //  Fetch all the data from the database table
            if (in_array($request_data_admin['useremail'], $this->data['admin_list'])) {
                $this->data['db_select_all']  = $this->dbAdmin->formSelectModel($this->settings['db']['table_name']);

                // get the csv file name to attach with email
                $file_name = $this->getCSVFileName();

                // get the query result as string and pass it to sendDynamicEmail()
                $csvString = $this->createCSVData($this->data['db_select_all']);

                // get the email settings from setting.email.php
                $email_settings       = $this->settings['email_csv'];
                $email_settings['to'] = $_POST['useremail'];
                $message_body         = $this->settings['email_csv']['body'];

                // Send email to user (admin) with attached CSV file
                $email_send_status = $this->emailHandler->sendEmail($email_settings, $message_body, $file_name, $csvString);

                //  if email sending successful then show the thankyou page
                  if (empty($email_send_status)) {

                    //  Success - Load the thankyou page
                      $uri = $request->getUri()->withPath($this->router->pathFor('adminthankyou'));
                      return $response->withRedirect((string)$uri);

                  }else{
                    //   Error - load the EmailError.php page
                      $this->data['email_error'] = $email_send_status;
                      $this->view->render($response, 'EmailError.php', $this->data);
                  }
            } else{
                $this->data['email_error'] = "Email Not found";
                // // Load the initial Admin form
                $this->view->render($response, 'AdminForm.php', $this->data);
            }
        }elseif(isset($request_data_admin['cancel_button'])){
            // Load the initial Admin form
            $this->data['error_msg'] = "Please select an option";
            $this->view->render($response, 'AdminForm.php', $this->data);
        }
        else{
            $this->view->render($response, 'AdminForm.php', $this->data);
        }
*/
        // Load footer
        $this->view->render($response, 'templates/private/footer.php', $this->data);
    }

    /**
    *   Get the csv file name from the settings_admin.php
    *
    *   @return string CSV file name
    */
    public function getCSVFileName()
    {
        //  generate the file name using settings_admin.php
        $prefix         = $this->data['file_name_format']['prefix'];
        $name_seperator = $this->data['file_name_format']['seperator'];
        $date_format    = $this->data['file_name_format']['date_format'];

        return $prefix.$name_seperator.date($date_format).".csv";
    }

    /**
    *   Validated whether email exists in the list - settings_admin.php
    *
    *   @param String $admin
    */
    public function validateAdmin($admin)
    {
        // Check whether user in the list or not
           if (in_array($admin, $this->data['admin_list'])) {
               $this->data['users'] = $admin;
               $this->view->render($response, 'AdminConfirm.php', $this->data);
               return true;
           }else{
               $this->data['error_msg'] = "Email Not found";
               $this->view->render($response, 'AdminForm.php', $this->data);
               $this->log -> debug("Admin Email:", array($this->data['error_msg']));
               return false;
           }
    }

    /**
    *   Get the data for the CSV file
    *
    *   @param array $db_select_all - data selected from the database tables
    *   @return string $data - values which are written in the files
    */
    public function createCSVData($db_select_all)
    {
	    $table_headers = '';
        $last_header = end($db_select_all);
        foreach ($db_select_all[0] as $key => $value) {

            $table_headers .= '"'.$key .'"';
            if($last_header != $key){
                $table_headers .= ',';
            }
        }

        // Loop data and write to file pointer
        $row_data = '';
        foreach ($db_select_all as $innerArray) {
            $lastof_innerarray = end($innerArray);
             foreach ($innerArray as $key => $value) {
                 $row_data  .= '"'.$value.'"';
                 if ($lastof_innerarray != $key) {
                     $row_data .= ',';
                 }
             }
             $row_data .= "\n";
        }
        $data = $table_headers. "\n" . $row_data;
      // Return the data as string
      return $data;
    }


    /**
    * Render the Admin Thankyou.php page when CSV is generated and email is sent
    *
    * @param Request $request
    * @param response $response
    */
    public function adminThankYou($request, $response)
    {
        $this->data['goback_admin'] = 'admin'; // set the hyperlink for Go Back in view\thankyou.php
        $this->view->render($response, 'templates/private/header.php', $this->data);
        $this->view->render($response, 'AdminThankyou.php', $this->data);
        $this->view->render($response, 'templates/private/footer.php', $this->data);
    }

    /**
    *   Unused - Write the data into CSV files
    *
    *   @param string $file_name - form-data_<date_time>.csv
    *   @param array $db_select_all - data selected from the tables
    *   @return string - values which are written in the files
    */
    public function createCSVFile($file_name, $db_select_all)
    {
      // Open temp file pointer
      //    if (!$fp = fopen(APPPATH.'/uploads/csv_form_data.csv', 'w+')){

       if (!$fp = fopen($this->settings['uploadeddir']['path']. '/'. $file_name, 'w+')){

           $this->log -> debug("File:", array('Failed to create file.'));
           return FALSE;
       }


        $table_headers = array();
        foreach ($db_select_all[0] as $key => $value) {
            if (!in_array($key, $table_headers)) {
                array_push($table_headers, $key);
            }
        }
        fputcsv($fp, $table_headers);  // Write table column header into csv file

        // Loop data and write to file pointer
        foreach ($db_select_all as $innerArray) {
             fputcsv($fp, $innerArray); // write table rows into csv file

        }

      // Place stream pointer at beginning
      rewind($fp);

      // Return the data
      return stream_get_contents($fp);
    }

    /**
  * Display all the records submitted through the form
  *
  * @param Request $request
  * @param Response $response
  *
  */
    public function showAllRecords($request, $response)
    {
        $this->data['db_select_all']  = $this->dbAdmin->formSelectModel('meedo_test');

        // $this->view->render($response, 'templates/public/header.php', $this->data);
        $this->view->render($response, 'medoo_database.php', $this->data);
        // $this->view->render($response, 'templates/public/footer.php', $this->data);
    }

  /**
    * Render individual record
    *
    * @param Request $request
    * @param response $response
    * @param int $param - id is passed to get individual details
    */
    public function viewForm($request, $response, $param)
    {
        $data = $this->db-> getIndividualDetail('meedo_test',(int)$param['id']);
        $this->view->render($response, 'templates/public/header.php', $data);
        $this->view->render($response, 'ViewForm.php', $data);
        $this->view->render($response, 'templates/public/footer.php', $data);
    }

    /**
    * Delete individual record
    *
    * @param Request $request
    * @param response $response
    * @param int $param - id is passed to get individual details
    */
    public function deleteForm($request, $response, $param)
    {
        $table = "meedo_test";
        $data  = $this->db-> deleteIndividualRecord($table,(int)$param['id']);
        $uri   = $request->getUri()->withPath($this->router->pathFor('showall'));
        return $response->withRedirect((string)$uri);
    }

} // end of class
