<?php

/**
 * Renders alert-panel with a messages
 * 
 * @param string $type
 * @param string $message
 * @return void
 */
function setActionResponse($type, $message = null)
{
    $message = $message ?? 'You are not allowed to perform this action!';

    $types = collect([
        'success' => 'alert-success',
        'failed' => 'alert-danger', 
        'warning' => 'alert-warning'
    ]);

    if(!$types->has($type)) {
        throw new OutOfBoundsException("This alert type doesn't exist!");
    }

    session()->flash('message', $message);
    session()->flash('alertType', $types->get($type));
    session()->flash('actionResponse', true);
}