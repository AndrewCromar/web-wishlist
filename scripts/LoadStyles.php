<?php

function load_css($path)
{
    if (file_exists($path) && pathinfo($path, PATHINFO_EXTENSION) === 'css') {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($path) . '">' . PHP_EOL;
    }
}

function load_css_recursive($directory)
{
    if (!is_dir($directory)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'css') {
            $path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file->getPathname());
            echo '<link rel="stylesheet" href="' . htmlspecialchars($path) . '">' . PHP_EOL;
        }
    }
}

load_css(__DIR__ . '/../public/styles/root.css');
load_css_recursive(__DIR__ . '/../public/styles/');

?>
