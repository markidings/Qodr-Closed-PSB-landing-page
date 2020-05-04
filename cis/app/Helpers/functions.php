<?php

function flash($message = null, $level = 'info')
{
    // $level = info|success|warning|error
    $session = app('session');
    if (!is_null($message)) {
        $session->flash('flash_notification.message', $message);
        $session->flash('flash_notification.level', $level);
    }
}

function format_rupiah($nominal)
{
    return "Rp " . number_format($nominal,0,',','.');
}
