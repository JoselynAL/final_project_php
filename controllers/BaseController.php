<?php
ini_set("display_errors", 1);
class BaseController
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    protected function logAudit(
        $userId,
        $action,
        $table,
        $targetId,
        $old = null,
        $new = null
    ) {
        try {
            $stmt = $this->db->prepare("
            INSERT INTO audit_logs (user_id, action, target_table, target_id, old_values, new_values, ip_address, created_at)
            VALUES (:user_id, :action, :target_table, :target_id, :old_values, :new_values, :ip_address, NOW())
        ");
            $stmt->execute([
                "user_id" => $userId,
                "action" => $action,
                "target_table" => $table,
                "target_id" => $targetId,
                "old_values" => $old ? json_encode($old) : null,
                "new_values" => $new ? json_encode($new) : null,
                "ip_address" => $_SERVER["REMOTE_ADDR"] ?? null,
            ]);
        } catch (PDOException $e) {
            error_log("Audit log failed: " . $e->getMessage());
        }
    }
}
