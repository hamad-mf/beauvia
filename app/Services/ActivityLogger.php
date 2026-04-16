<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log an admin action
     */
    public static function log(string $action, $subject = null, array $metadata = []): void
    {
        $data = [
            'admin_id' => Auth::id(),
            'action' => $action,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        if ($subject) {
            $data['subject_type'] = get_class($subject);
            $data['subject_id'] = $subject->id ?? null;
        }

        AdminActivityLog::create($data);
    }
}
