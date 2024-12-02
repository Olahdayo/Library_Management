<?php

class ContactController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Contact Us'
        ];
        
        $this->view('contact/index', $data);
    }
} 