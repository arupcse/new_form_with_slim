<?php

/**
 * @author Arup Kumar Sarker (asarker@swin.edu.au)
 * Created: 2017-07-12 13:32
 * Class to handle all file upload related actions
 */

// namespace Swinburne\Legacy;
namespace Base;

class FileUpload
{

    private $settings;
    private $file_extensions;
    private $file_size;
    private $upload_dir;


    function __construct($settings)
    {

        $this->settings         = $settings;
        $this->file_extensions  = $settings['extensions'];
        $this->file_size        = $settings['size'];
        $this->upload_dir       = $settings['uploadeddir']['path'];

    }
    /**
    *   This function validate the file size, extensions and file uploaded or not
    *
    *   @param string $file_key_name - the name of the file field in the form
    *   @param $request
    *   @param $response
    */
    public function validateFileUpload($file_key_name)
    {
      $storage = new \Upload\Storage\FileSystem($this->upload_dir);
      $file    = new \Upload\File($file_key_name, $storage);

      // Optionally you can rename the file on upload
      // $new_filename = uniqid();  // setting a unique name

      // adding current date and time at the end of the file name
      if ($file ->getName()) {
          $new_filename = $file -> getName(). '-'. date('Ymd_His');
      } else {
        $new_filename = $file -> getName();
      }


      $file->setName($new_filename);

      if ($file->getName()) {
          // Validate file upload
          // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
          $file->addValidations(array(
              // Ensure file is of type "image/png"
              // new \Upload\Validation\Mimetype('image/png'),

              //You can also add multi mimetype validation
              //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

              // Ensure, the file is of the following types
              new \Upload\Validation\Extension($this->file_extensions),

              // Ensure file is no larger than 5M (use "B", "K", M", or "G")
              new \Upload\Validation\Size($this->file_size)
          ));

          // Access data about the file that has been uploaded
          $data = array(
              'name'       => $file->getNameWithExtension(),
              'extension'  => $file->getExtension(),
              'mime'       => $file->getMimetype(),
              'size'       => $file->getSize(),
            //   'md5'        => $file->getMd5(),
            //   'dimensions' => $file->getDimensions()
          );
      }


      // Try to upload file
      try {
          // Success!
          $file->upload();
          // $response ->write('Upload successful!! '.$file_name . "<br/>");
      } catch (\Exception $e) {
          // Fail!
          $upload_errors = $file->getErrors();
          // $response ->write($upload_errors);
      }
      if(Count($upload_errors) > 0){
          return array(
            'error'     => $upload_errors[0],
            'file_name' => $data['name']
          );
      }else{
           return array(
               'error'     => '',
               'file_name' => $data['name']
           );
      }

    //   return array(
    //     'error'     => $upload_errors,
    //     'file_name' => $data['name']
    //   );
    }
} // End of class
