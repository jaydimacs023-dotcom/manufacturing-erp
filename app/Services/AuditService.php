<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditService
{
    /**
     * Log an auditable event.
     */
    public function log(
        string $action,
        string $module,
        ?string $documentNumber = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $remarks = null,
        ?int $userId = null
    ): AuditLog {
        return AuditLog::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'module' => $module,
            'document_number' => $documentNumber,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'remarks' => $remarks,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log create event.
     */
    public function logCreate(string $module, string $documentNumber, array $values, ?string $remarks = null): AuditLog
    {
        return $this->log('create', $module, $documentNumber, null, $values, $remarks);
    }

    /**
     * Log update event.
     */
    public function logUpdate(string $module, string $documentNumber, array $oldValues, array $newValues, ?string $remarks = null): AuditLog
    {
        return $this->log('update', $module, $documentNumber, $oldValues, $newValues, $remarks);
    }

    /**
     * Log delete event.
     */
    public function logDelete(string $module, string $documentNumber, array $values, ?string $remarks = null): AuditLog
    {
        return $this->log('delete', $module, $documentNumber, $values, null, $remarks);
    }

    /**
     * Log submit event.
     */
    public function logSubmit(string $module, string $documentNumber, ?string $remarks = null): AuditLog
    {
        return $this->log('submit', $module, $documentNumber, null, null, $remarks);
    }

    /**
     * Log approve event.
     */
    public function logApprove(string $module, string $documentNumber, ?string $remarks = null): AuditLog
    {
        return $this->log('approve', $module, $documentNumber, null, null, $remarks);
    }

    /**
     * Log reject event.
     */
    public function logReject(string $module, string $documentNumber, ?string $remarks = null): AuditLog
    {
        return $this->log('reject', $module, $documentNumber, null, null, $remarks);
    }

    /**
     * Log cancel event.
     */
    public function logCancel(string $module, string $documentNumber, ?string $remarks = null): AuditLog
    {
        return $this->log('cancel', $module, $documentNumber, null, null, $remarks);
    }

    /**
     * Log complete event.
     */
    public function logComplete(string $module, string $documentNumber, ?string $remarks = null): AuditLog
    {
        return $this->log('complete', $module, $documentNumber, null, null, $remarks);
    }

    /**
     * Log login event.
     */
    public function logLogin(int $userId, bool $success, ?string $remarks = null): AuditLog
    {
        return $this->log(
            $success ? 'login' : 'failed_login',
            'Authentication',
            null,
            null,
            null,
            $remarks ?? ($success ? 'Successful login' : 'Failed login attempt'),
            $userId
        );
    }

    /**
     * Log logout event.
     */
    public function logLogout(int $userId): AuditLog
    {
        return $this->log('logout', 'Authentication', null, null, null, 'User logged out', $userId);
    }
}

