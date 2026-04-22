<?php

use App\Models\ActivityLog;

if (!function_exists('logActivity')) {
    function logActivity($action, $module, $detail)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $module,
            'detail' => $detail,
        ]);
    }
}
