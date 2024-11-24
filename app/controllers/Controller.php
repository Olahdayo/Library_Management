<?php

    class Controller
    {
        protected function view($view, $data = [])
        {
            extract($data);
            require_once '../app/views/' . $view . '.php';
        }

        protected function model($model) {
            // Assuming your models are in app/models directory
            require_once '../app/models/' . $model . '.php';
            return new $model();
        }
    }
