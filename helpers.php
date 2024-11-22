<?php
function asset($path)
{
    return '/public/' . ltrim($path, '/');
}

function style($path)
{
    return '<link rel="stylesheet" href="' . asset($path) . '">';
}