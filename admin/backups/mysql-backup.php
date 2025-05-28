<?php
class MySQLBackup {
    private $conn;
    private $backupPath;

    public function __construct($conn, $backupPath) {
        $this->conn = $conn;
        $this->backupPath = $backupPath;

        $this->createBackup();
    }

    private function createBackup() {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $backup_file = $this->backupPath . $filename;

        $tables = array();
        $result = mysqli_query($this->conn, 'SHOW TABLES');
        while ($row = mysqli_fetch_array($result)) {
            $tables[] = $row[0];
        }

        $content = "-- Voorivex Weblog Backup - " . date('Y-m-d H:i:s') . "\n\n";
        foreach ($tables as $table) {
            $result = mysqli_query($this->conn, "SELECT * FROM $table");
            $num_fields = mysqli_num_fields($result);
            $content .= "DROP TABLE IF EXISTS $table;\n";
            $create_table = mysqli_fetch_array(mysqli_query($this->conn, "SHOW CREATE TABLE $table"));
            $content .= $create_table[1] . ";\n\n";

            $row_count = mysqli_num_rows($result);
            if ($row_count > 0) {
                $content .= "INSERT INTO $table VALUES\n";
                $first = true;
                while ($row = mysqli_fetch_array($result)) {
                    if (!$first) {
                        $content .= ",\n";
                    }
                    $content .= "(";
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j] ?? '');
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        $content .= '"' . $row[$j] . '"';
                        if ($j < ($num_fields - 1)) {
                            $content .= ',';
                        }
                    }
                    $content .= ")";
                    $first = false;
                }
                $content .= ";\n\n";
            }
        }

        if (file_put_contents($backup_file, $content)) {
            $_SESSION['backup_message'] = "Backup created successfully: <a href='/admin/backups/backups/$filename'>Download</a>";
        } else {
            $_SESSION['backup_message'] = "Failed to create backup.";
        }
    }
}
?>