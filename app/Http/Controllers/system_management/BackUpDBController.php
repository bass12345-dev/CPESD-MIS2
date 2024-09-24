<?php

namespace App\Http\Controllers\system_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Google\Client;
use Google\Service\Drive;
use Carbon\Carbon;

class BackUpDBController extends Controller
{
    protected $folderID = '1MNM-jZ17ycmWAmfT9Oi4xWkhxrqmJZQ9';
    protected $service_account = 'app/service_account.json';
    public function index(){
        $data['title']  = 'Back Up Database';
        return view('system_management.contents.back_up_database.back_up_database')->with($data);
    }


    public function get_databases(){

          // Initialize Google Client
          $client = new Client();
          $client->setApplicationName('Laravel Google Drive List Files');
          $client->setAuthConfig(storage_path($this->service_account)); // Path to your service account JSON file
          $client->setScopes([Drive::DRIVE_READONLY]); // Read-only scope for listing files
  
          // Create a new Google Drive service
          $driveService = new Drive($client);
  
          // The ID of the folder in Google Drive where your backups are stored
          $folderId = $this->folderID; // Replace with your folder ID
  
          // Fetch the list of files in the folder
          $files = $driveService->files->listFiles([
              'q' => "'$folderId' in parents",
              'fields' => 'files(id, name, mimeType, modifiedTime, size)',
          ]);
          
          $data = [];
          $i = 1;
          foreach ($files as $index => $file){
            $data[] = array(
                'i'                 => $i++,
                'file_name'         => $file->name,
                'file_size'         => $file->size,
                'modified_time'     => date('M d Y h:i A', strtotime($file->modifiedTime)),
                'file_id'           => $file->id 
                
            );
          }

        return response()->json($data);

          
    }

    public function back_up_database(){
        // Database credentials
        $dbHost = env('DB_HOST');
        $dbUsername = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');


        #DB NAME
        $dbName = env('DB_DATABASE');
        $dbNameLLS = env('DB_DATABASE_LLS');
        $dbNameDTS = env('DB_DATABASE_DTS');
        $dbNamePMAS = env('DB_DATABASE_PMAS');
        
        $date_now = date('Y-m-d_H-i-s');

        $file_path = storage_path("app/database/");
        
       


        if (is_dir($file_path)) {
            
            $fileName = $dbName.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
            $localFilePath = $file_path.$fileName;
            $fileNameLLS = $dbNameLLS.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
            $localFilePathLLS = $file_path.$fileNameLLS;
            $fileNameDTS = $dbNameDTS.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
            $localFilePathDTS = $file_path.$fileNameDTS;
            $fileNamePMAS = $dbNamePMAS.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
            $localFilePathPMAS = $file_path.$fileNamePMAS;


            $command = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePath}";
            $command2 = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePathLLS}";
            $command3 = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePathDTS}";
            $command4 = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePathPMAS}";
               // Execute the command
            $result = null;
            system($command,$result);
            system($command2,$result1);
            system($command3,$result2);
            system($command4,$result3);

            
            $this->uploadFileToGoogleDrive($localFilePath);
            sleep(2);
            $this->uploadFileToGoogleDrive($localFilePathLLS);
            sleep(2);
            $this->uploadFileToGoogleDrive($localFilePathDTS);
            sleep(2);
            $this->uploadFileToGoogleDrive($localFilePathPMAS);

              // Step 3: Remove the backup file after upload
            $this->deleteLocalBackup($localFilePath);
            $this->deleteLocalBackup($localFilePathLLS);
            $this->deleteLocalBackup($localFilePathDTS);
            $this->deleteLocalBackup($localFilePathPMAS);
            if ($result !== 0) {
                return response()->json(['message' => 'Database backup failed'], 500);
            }

            
            return response()->json(['message' => 'Database backup saved successfully', 'file' => $fileName]);
            
        }
    }


    private function deleteLocalBackup($backupFilePath)
    {
        // Delete the backup file from the local storage
        if (File::exists($backupFilePath)) {
            File::delete($backupFilePath);
        }
    }

    private function uploadFileToGoogleDrive($backupFilePath)
    {
        // Replace with the ID of your existing Google Drive folder

        // Initialize Google Client
        $client = new Client();
        $client->setApplicationName('Laravel Google Drive Upload');
        $client->setAuthConfig(storage_path($this->service_account)); // Path to your service account JSON file
        $client->setScopes([Drive::DRIVE_FILE]);

        // Create a new Google Drive service
        $driveService = new Drive($client);

        // Upload the backup file
        $this->uploadFile($driveService, $backupFilePath, basename($backupFilePath), $this->folderID);
    }

    private function uploadFile($driveService, $filePath, $fileName, $folderId)
    {
        $fileMetadata = new \Google\Service\Drive\DriveFile([
            'name' => $fileName,
            'parents' => [$folderId] // Set the parent folder ID here
        ]);

        $content = file_get_contents($filePath);
        $driveService->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => mime_content_type($filePath),
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
    }
}
