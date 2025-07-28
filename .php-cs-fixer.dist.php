<?php
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__,
        __DIR__ . "/configurations"
    ])
    ->exclude("venor")
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'single_quote' => true,
        'no_unused_imports' => true,
         "braces_position" => [
            "classes_opening_brace" => "same_line",
            "functions_opening_brace" => "same_line"
         ]
    ])
    ->setFinder($finder)
    ->setUsingCache(false);

