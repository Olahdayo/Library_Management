<?php

class AboutController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'About Us'
        ];
        
        $this->view('about/index', $data);
    }
} 