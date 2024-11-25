<?php

/**
 * Generate link to CSS file
 * @param string $file CSS filename
 * @return string HTML link tag
 */
function style($file)
{
    $basePath = defined('BASE_PATH') ? BASE_PATH : '';
    return '<link rel="stylesheet" href="' . $basePath . '/css/' . $file . '.css">';
}

/**
 * Generate link to JavaScript file  
 * @param string $file JavaScript filename
 * @return string HTML script tag
 */
function script($file)
{
    $basePath = defined('BASE_PATH') ? BASE_PATH : '';
    return '<script src="' . $basePath . '/js/' . $file . '.js"></script>';
}