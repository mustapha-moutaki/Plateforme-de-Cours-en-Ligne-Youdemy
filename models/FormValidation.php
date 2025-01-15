<?php
namespace Models;

class FormValidator {
    private $errors = [];

    public function validateUsername($username) {
        if (empty($username)) {
            $this->errors['username'] = "username required.";
        } elseif (strlen($username) < 3) {
            $this->errors['username'] = "at least 3 latters.";
        }
    }

    public function validateEmail($email) {
        if (empty($email)) {
            $this->errors['email'] = "email is required ";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "invalid email";
        }
    }

    public function validatePassword($password) {
        if (empty($password)) {
            $this->errors['password'] = "password required";
        } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $this->errors['password'] = "password must include at least 3 latters and number";
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function isValid() {
        return empty($this->errors);
    }
}
