<?php
namespace Models;


class FormValidator {
    private $errors = [];

    public function validateUsername($username) {
        if (empty($username)) {
            $this->errors['username'] = "Username required.";
        } elseif (strlen($username) < 3) {
            $this->errors['username'] = "At least 3 letters required.";
        }
    }

    public function validateEmail($email) {
        if (empty($email)) {
            $this->errors['email'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Invalid email format.";
        }
    }

    public function validatePassword($password) {
        if (empty($password)) {
            $this->errors['password'] = "Password required.";
        } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $this->errors['password'] = "Password must include at least 8 letters and a number.";
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function isValid() {
        return empty($this->errors);
    }
}
