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


final class MedooAdminModel
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
        * Select all values from the tables
        *
        * @param string $table_name - name of the table from where values are selected
        *
        * @return array $result - if the query runs successfully
        * @return bool false - if there are errors in executing the query
        */
          public function formSelectModel($table_name)
          {
              try {
                $column_headings = $this->getTableColumnNames($table_name);

                $result  = $this->database->select( $table_name, $column_headings); // select($table, $columns, $where)

              //   $result  = $this->database->select(
              //       "meedo_test",             // Table name
              //       [                         // list of columns
              //           "id",
              //           "full_name",
              //           "email",
              //           "comments",
              //           "student_type",
              //           "student_interest",
              //           "campus",
              //           "faculty",
              //           "file_to_upload",
              //           "created_date"
              //       ]
              //   );

              if (empty(array_filter($result))) {
              // if ($this->database->error()[0] !== 0) {
                  $this->log -> debug("SQL select failed: ", $this->database->log());
                  return false;
              }else{
                  return $result;
              }

            } catch (\PDOException $e) {
              $this->log -> debug("SQL select error. ", [$e->getMessage()]);
              //   $this->log -> debug("SQL select error. ",[$this->database->error()]);
              return false;

              }
          }

} // End of Class
