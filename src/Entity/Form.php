<?php

namespace App\Entity;

class Form
{
    public $categories = [];
    public $email;

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories()
    {
        $this->categories = Joke::setCategories();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail()
    {
        $this->email = 'student_belgu@mail.ru';
    }
}