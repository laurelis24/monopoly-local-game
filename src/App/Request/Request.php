<?php

namespace App\Request;

use App\Session\Session;
use App\Validation\Validator;

class Request {
    private Validator $validator;

    public function __construct() {
        $this->validator = new Validator();
        Session::setParam('old', $this->getInputs());
    }

    public function input(string $value) {
        if (isset($_REQUEST[$value])) {
            return $_REQUEST[$value];
        }
        abort(403, 'Forbidden!');
    }

    private function getInputs() {
        return $_REQUEST;
    }

    public function validate(array $data) {
        $this->validator->validate($_REQUEST, $data);

        return $this->validator;
    }
}
