<?php

namespace App\Validation;

class Validator {
    public array $errors = [];

    public function validate(array $inputData, array $data): void {

        foreach ($data as $inputName => $value) {
            $rules = strlen($value) ? explode('|', $value) : [];


            foreach ($rules as $rule) {
                $ruleValue = str_contains($rule, ':') ? explode(':', $rule)[1] : null;

                if (str_starts_with($rule, 'min')) {
                    $this->min($inputName, $inputData[$inputName], $ruleValue);
                } elseif (str_starts_with($rule, 'max')) {
                    $this->max($inputName, $inputData[$inputName], $ruleValue);
                } else {
                    call_user_func([$this, $rule], $inputName, $inputData[$inputName]);
                }
            }



        }

    }



    private function min(string $inputName, string $inputData, int $ruleValue) {
        if (strlen($inputData) < $ruleValue) {
            $this->errors[$inputName] = "$inputName can't be shorter than $ruleValue chars!";
        }
    }

    private function max(string $inputName, string $inputData, int $ruleValue) {
        if (strlen($inputData) > $ruleValue) {
            $this->errors[$inputName] = "$inputName can't be longer than $ruleValue chars!";
        }
    }

    private function string(string $inputName, string $inputData) {
        if (!preg_match('/^[0-9a-zA-Z]*$/', $inputData)) {
            $this->errors[$inputName] = "$inputName should be string!";
        }
    }
    private function number(string $inputName, string $inputData) {
        if (!preg_match('/^[0-9]*$/', $inputData)) {
            $this->errors[$inputName] = "$inputName should be number!";
        }
    }

    private function required(string $inputName, string $inputData) {
        if (strlen($inputData) === 0) {
            $this->errors[$inputName] = "$inputName can't be empty!";
        }
    }

    public function successful() {
        return count($this->errors) <= 0;
    }
}
