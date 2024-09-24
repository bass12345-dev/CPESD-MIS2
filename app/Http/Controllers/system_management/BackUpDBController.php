<?php

namespace App\Http\Controllers\system_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
// use Google\Client;
// use Google\Service\Drive;
use Carbon\Carbon;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BackUpDBController extends Controller
{
    protected $folderID = '1MNM-jZ17ycmWAmfT9Oi4xWkhxrqmJZQ9';
    protected $service_account = 'app/service_account.json';

    protected $conn_users;
    protected $conn_lls;
    protected $conn_whip;
    protected $conn_dts;
    protected $conn_pmas;
   

    public function __construct()
    {

        $this->conn_users = config('custom_config.database.users');
        $this->conn_lls = config('custom_config.database.lls_whip');
        $this->conn_dts = config('custom_config.database.dts');
        $this->conn_pmas = config('custom_config.database.pmas');
        
    }

    public function index(){
        $data['title']  = 'Back Up Database';
        return view('system_management.contents.back_up_database.back_up_database')->with($data);
    }


    public function get_databases(){

        //   // Initialize Google Client
        //   $client = new Client();
        //   $client->setApplicationName('Laravel Google Drive List Files');
        //   $client->setAuthConfig(storage_path($this->service_account)); // Path to your service account JSON file
        //   $client->setScopes([Drive::DRIVE_READONLY]); // Read-only scope for listing files
  
        //   // Create a new Google Drive service
        //   $driveService = new Drive($client);
  
        //   // The ID of the folder in Google Drive where your backups are stored
        //   $folderId = $this->folderID; // Replace with your folder ID
  
        //   // Fetch the list of files in the folder
        //   $files = $driveService->files->listFiles([
        //       'q' => "'$folderId' in parents",
        //       'fields' => 'files(id, name, mimeType, modifiedTime, size)',
        //   ]);
          
        //   $data = [];
        //   $i = 1;
        //   foreach ($files as $index => $file){
        //     $data[] = array(
        //         'i'                 => $i++,
        //         'file_name'         => $file->name,
        //         'file_size'         => $file->size,
        //         'modified_time'     => date('M d Y h:i A', strtotime($file->modifiedTime)),
        //         'file_id'           => $file->id 
                
        //     );
        //   }

        return response()->json([]);

          
    }   

    public function back_up_database()
    {
        // Get all tables
        // $tables = DB::select('SHOW TABLES');
        // $row = DB::connection($this->conn)->select('SHOW TABLES');
        

        $dbUsers = env('DB_DATABASE');
        $dbNameLLS = env('DB_DATABASE_LLS');
        $dbNameDTS = env('DB_DATABASE_DTS');
        $dbNamePMAS = env('DB_DATABASE_PMAS');
        $db_arr = [$dbUsers,$dbNameLLS,$dbNameDTS,$dbNamePMAS];
        $con_arr = [$this->conn_users,$this->conn_lls,$this->conn_dts,$this->conn_pmas];

        $i = 0;
        while ($i < count($con_arr)) {
            $dbName = $db_arr[$i];
            $connName = $con_arr[$i];


            $tables = DB::connection($connName)->select('SHOW TABLES');
           
            $backupFile = 'backups/' . $dbName.'_'.date('Y-m-d_H-i-s') . '_backup.sql';
            $sqlBackup = "";
            
            
            // Loop through tables and create the SQL dump
            foreach ($tables as $table) {
                $tableName = $table->{"Tables_in_$dbName"};
    
                // Get the table creation SQL
                $createTable = DB::select("SHOW CREATE TABLE $tableName")[0]->{'Create Table'} . ";\n\n";
                $sqlBackup .= $createTable;
    
                // Get the table data
                $rows = DB::table($tableName)->get();
    
                if ($rows->isNotEmpty()) {
                    $sqlBackup .= "INSERT INTO `$tableName` VALUES\n";
    
                    foreach ($rows as $row) {
                        $rowData = [];
    
                        foreach ($row as $column) {
                            $rowData[] = is_null($column) ? 'NULL' : DB::getPdo()->quote($column);
                        }
    
                        $sqlBackup .= '(' . implode(',', $rowData) . "),\n";
                    }
    
                    // Remove the last comma and replace with semicolon
                    $sqlBackup = substr($sqlBackup, 0, -2) . ";\n\n";
                }
            }
    
            // Store the backup SQL to a file
            Storage::put($backupFile, $sqlBackup);
            
            $i++;
        }






       

        // return response()->json(['message' => 'Database backup created successfully']);
    }

    // public function back_up_database()
    // {
    //     // Retrieve database connection details from the environment
    //     $username = env('DB_USERNAME');
    //     $password = env('DB_PASSWORD');
    //     $database = env('DB_DATABASE');
    //     $host = env('DB_HOST', '127.0.0.1');

    //     $dbNameLLS = env('DB_DATABASE_LLS');
    //     $dbNameDTS = env('DB_DATABASE_DTS');
    //     $dbNamePMAS = env('DB_DATABASE_PMAS');

        

    //     // Path where the backup will be saved
    //     $backupPath = storage_path('app/database/' . $database.'_'.date('Y-m-d_H-i-s') . '_backup.sql');
    //     $backupPath1 = storage_path('app/database/' . $dbNameLLS.'_'.date('Y-m-d_H-i-s') . '_backup.sql');
    //     $backupPath2 = storage_path('app/database/' . $dbNameDTS.'_'.date('Y-m-d_H-i-s') . '_backup.sql');
    //     $backupPath3 = storage_path('app/database/' . $dbNamePMAS.'_'.date('Y-m-d_H-i-s') . '_backup.sql');

    //     // Create a new Process instance
    //     $process = new Process([
    //         'mysqldump',
    //         '--user=' . $username,
    //         '--password=' . $password,
    //         '--host=' . $host,
    //         $database,
    //         '--result-file=' . $backupPath,
    //     ]);

    //     $process1 = new Process([
    //         'mysqldump',
    //         '--user=' . $username,
    //         '--password=' . $password,
    //         '--host=' . $host,
    //         $dbNameLLS,
    //         '--result-file=' . $backupPath1,
    //     ]);

    //     $process2 = new Process([
    //         'mysqldump',
    //         '--user=' . $username,
    //         '--password=' . $password,
    //         '--host=' . $host,
    //         $dbNameDTS,
    //         '--result-file=' . $backupPath2,
    //     ]);

    //     $process3 = new Process([
    //         'mysqldump',
    //         '--user=' . $username,
    //         '--password=' . $password,
    //         '--host=' . $host,
    //         $dbNamePMAS,
    //         '--result-file=' . $backupPath3,
    //     ]);

    //     try {
    //         // Execute the command
    //         $process->mustRun();
    //         $process1->mustRun();
    //         $process2->mustRun();
    //         $process3->mustRun();
            
    //         return response()->json(['message' => 'Database backup created successfully at ']);
    //     } catch (ProcessFailedException $exception) {
    //         // Handle failure
    //         return response()->json(['error' => 'Backup failed: ' . $exception->getMessage()], 500);
    //     }
    // }

    // public function back_up_database(){
    //     // Database credentials
    //     $dbHost = env('DB_HOST');
    //     $dbUsername = env('DB_USERNAME');
    //     $dbPassword = env('DB_PASSWORD');


    //     #DB NAME
    //     $dbName = env('DB_DATABASE');
    //     $dbNameLLS = env('DB_DATABASE_LLS');
    //     $dbNameDTS = env('DB_DATABASE_DTS');
    //     $dbNamePMAS = env('DB_DATABASE_PMAS');
        
    //     $date_now = date('Y-m-d_H-i-s');

    //     $file_path = storage_path("app/database/");
        
       


    //     if (is_dir($file_path)) {
            
    //         $fileName = $dbName.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
    //         $localFilePath = $file_path.$fileName;
    //         $fileNameLLS = $dbNameLLS.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
    //         $localFilePathLLS = $file_path.$fileNameLLS;
    //         $fileNameDTS = $dbNameDTS.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
    //         $localFilePathDTS = $file_path.$fileNameDTS;
    //         $fileNamePMAS = $dbNamePMAS.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
    //         $localFilePathPMAS = $file_path.$fileNamePMAS;


    //         $command = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePath}";
    //         $command2 = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePathLLS}";
    //         $command3 = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePathDTS}";
    //         $command4 = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePathPMAS}";
    //            // Execute the command
    //         $result = null;
    //         system($command,$result);
    //         system($command2,$result1);
    //         system($command3,$result2);
    //         system($command4,$result3);

            
    //         $this->uploadFileToGoogleDrive($localFilePath);
    //         sleep(2);
    //         $this->uploadFileToGoogleDrive($localFilePathLLS);
    //         sleep(2);
    //         $this->uploadFileToGoogleDrive($localFilePathDTS);
    //         sleep(2);
    //         $this->uploadFileToGoogleDrive($localFilePathPMAS);

    //           // Step 3: Remove the backup file after upload
    //         $this->deleteLocalBackup($localFilePath);
    //         $this->deleteLocalBackup($localFilePathLLS);
    //         $this->deleteLocalBackup($localFilePathDTS);
    //         $this->deleteLocalBackup($localFilePathPMAS);
    //         if ($result !== 0) {
    //             return response()->json(['message' => 'Database backup failed'], 500);
    //         }

            
    //         return response()->json(['message' => 'Database backup saved successfully', 'file' => $fileName]);
            
    //     }
    // }


    // private function deleteLocalBackup($backupFilePath)
    // {
    //     // Delete the backup file from the local storage
    //     if (File::exists($backupFilePath)) {
    //         File::delete($backupFilePath);
    //     }
    // }

    // private function uploadFileToGoogleDrive($backupFilePath)
    // {
    //     // Replace with the ID of your existing Google Drive folder

    //     // Initialize Google Client
    //     $client = new Client();
    //     $client->setApplicationName('Laravel Google Drive Upload');
    //     $client->setAuthConfig(storage_path($this->service_account)); // Path to your service account JSON file
    //     $client->setScopes([Drive::DRIVE_FILE]);

    //     // Create a new Google Drive service
    //     $driveService = new Drive($client);

    //     // Upload the backup file
    //     $this->uploadFile($driveService, $backupFilePath, basename($backupFilePath), $this->folderID);
    // }

    // private function uploadFile($driveService, $filePath, $fileName, $folderId)
    // {
    //     $fileMetadata = new \Google\Service\Drive\DriveFile([
    //         'name' => $fileName,
    //         'parents' => [$folderId] // Set the parent folder ID here
    //     ]);

    //     $content = file_get_contents($filePath);
    //     $driveService->files->create($fileMetadata, [
    //         'data' => $content,
    //         'mimeType' => mime_content_type($filePath),
    //         'uploadType' => 'multipart',
    //         'fields' => 'id'
    //     ]);
    // }
}
