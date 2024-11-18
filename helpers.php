<?php
function asset($path)
{
    return '/public/' . ltrim($path, '/');
}