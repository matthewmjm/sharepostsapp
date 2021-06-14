<?php
    /*
    * App Core Class
    * Creates URL & loads core controller
    * URL FORMAT - /controller/method/params
    */

    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            // print_r($this->getUrl());
            $url = $this->getUrl();

            // Look in controllers for first index/value
            if(isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
                // If it exists, set it as controller
                $this->currentController = ucwords($url[0]);
                // unset the 0 index
                unset($url[0]);
            }

            // Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            // Instantiate controller class    ( $pages = new Pages)
            $this->currentController = new $this->currentController;

            // Check for second index/method of URL
            if(isset($url[1])){
                //Check to see if method exists in controller
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    // unset index
                    unset($url[1]);
                }
            }
            
            // Get params
            $this->params = $url ? array_values($url) : [];

            // Call a callback with an array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'],'/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }

        }
    }

// isset — Determine if a variable is declared and is different than null
// unset — Unset a given variable
// rtrim — Strip whitespace (or other characters) from the end of a string
// filter_var — Filters a variable with a specified filter
// explode — Split a string by a string
// file_exists — Checks whether a file or directory exists
// method_exists — Checks if the class method exists
// array_values — Return all the values of an array
// call_user_func_array — Call a callback with an array of parameters

?>
