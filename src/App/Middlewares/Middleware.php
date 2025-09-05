<?php

namespace App\Middlewares;

abstract class Middleware {
    abstract public function handle(): void;
}
