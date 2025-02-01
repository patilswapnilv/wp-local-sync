<?php

class WLS_Backup_Manager {
    private $max_backups = 10;
    private $max_backup_age = 30; // days

    public function cleanup_old_backups() {
        global $wpdb;
        
        // Delete backups older than max_backup_age
        $old_date = date('Y-m-d H:i:s', strtotime("-{$this->max_backup_age} days"));
        $old_backups = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE created_at < %s",
                $old_date
            )
        );

        foreach ($old_backups as $backup) {
            $this->delete_backup($backup->id);
        }

        // Keep only max_backups number of recent backups
        $excess_backups = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} ORDER BY created_at DESC LIMIT %d, 999999",
                $this->max_backups
            )
        );

        foreach ($excess_backups as $backup) {
            $this->delete_backup($backup->id);
        }
    }

    private function delete_backup($id) {
        global $wpdb;
        
        $backup = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id)
        );

        if ($backup) {
            $file_path = $this->backup_dir . '/' . $backup->filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            $wpdb->delete($this->table_name, ['id' => $id]);
        }
    }
} 