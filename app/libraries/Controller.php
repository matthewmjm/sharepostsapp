<?php
    // * This is the Base Controller
    // * It loads the models and views
    // * It will have two functions, model and view

    class Controller {
        // Load model
        public function model($model) {
            // Require Model file
            require_once '../app/models/' . $model . '.php';

            // Instantiate model
            return new $model();
        }

        // Load view
        public function view($view, $data = []){
            // Check for the view file
            if(file_exists('../app/views/' . $view . '.php')){
                // Require View file, if it exists
                require_once '../app/views/' . $view . '.php';
            } else {
                // Views does not exist
                die('View does not exist');
            }
        }
    }


    // die — Equivalent to exit

?>