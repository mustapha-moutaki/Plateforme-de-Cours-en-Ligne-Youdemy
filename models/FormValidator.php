<?php
namespace Models;


class FormValidator {
    private $errors = [];

    public function validateUsername($username) {
        if (empty($username)) {
            $this->errors['username'] = "Username required.";
        } elseif (strlen($username) < 3) {
            $this->errors['username'] = "<p style='color:white; background-color:red;width:100%;text-align:center; margin-top:10px'At least 3 letters required.</p>";
        }
    }

    public function validateEmail($email) {
        if (empty($email)) {
            $this->errors['email'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "<p style='color:white; background-color:red;width:100%;text-align:center; margin-top:10px'>Invalid email format.</p>";
        }
    }

    public function validatePassword($password) {
        if (empty($password)) {
            $this->errors['password'] = "Password required.";
        } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $this->errors['password'] = "<p style='color:white; background-color:red;width:100%;text-align:center; margin-top:10px'>Password must include at least 8 letters and a number.</p>";
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function isValid() {
        return empty($this->errors);
    }
}
