<?php

// namespace Swinburne\Legacy;
namespace Base;

use Slim\Router;
use Slim\Flash\Messages as FlashMessages;
use Slim\Views\PhpRenderer;
use Monolog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Interop\Container\ContainerInterface;
// use Medoo\Medoo as m;
// use Upload;


final class MedooFormModel
{
    private $database;
    private $log;
    private $settings;


    public function __construct(ContainerInterface $container)
    {
        $this->database  = $container->get('medoo');
        $this->log       = $container->get('monolog');
        $this->settings  = $container->get('settings');
    }


    /**
      * Get all the column names of the tables
      *
      * @return string $column_list
      */
      public function getTableColumnNames($table_name)
      {
          try {
              $column_names =  $this->database->query(
                    " SELECT COLUMN_NAME"
                   ." FROM INFORMATION_SCHEMA.COLUMNS"
                   ." WHERE TABLE_SCHEMA = '".$this->settings['db']['database_name']."'"
                   ." AND TABLE_NAME = '".$table_name."'"
              )->fetchAll();

              $new_column_list = array();
              foreach ($column_names as $innerArray) {
                  array_push($new_column_list, $innerArray['COLUMN_NAME']);
              }

            //   return $column_names;
              return $new_column_list;
          } catch (\PDOException $e) {
                $this->log -> debug("SQL Column Name error. ", [$e->getMessage()]);
                $this->log -> debug("SQL Column Name error. ",[$this->database->log()]);
                return false;
          }
      }

    /**
      * Insert form data into database
      *
      * @param string $table_name - name of the
      * @param array $posted_data - input values passed through the form_title
      */
     public function formInsertModel($table_name, array $posted_data)
     {
       try {

        //    Dynamic insert

           $columns_headers = $this->getTableColumnNames($table_name);
           $value_to_insert = array();

           foreach ($posted_data as $key => $value) {

               if (in_array($key, $columns_headers)) {   //    if the posted fieldname matches with the database columnname
                   if (is_array($value)) {       // if the posted_data is an array then put '\' to separate the elements
                       $value_to_insert[$key] = htmlspecialchars(implode('| ', $value), ENT_QUOTES, 'UTF-8');
                   } else {
                       $value_to_insert[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                   }
               }
           }

           $insert_data = $this->database->insert($table_name, $value_to_insert);

         // finding error based on affected rows

         if ($insert_data->rowCount() > 0) {
             return true;
         } else {
             $this->log -> debug("SQL insert error. ",$this->database->error());
             $this->log -> debug("SQL insert query. ",$this->database->log());
             return false;
         }

       } catch (\PDOException $e) {
         $this->log -> debug("SQL insert error. ",[$e->getMessage()]);

           return false;
       }
     }

} // End of Class
