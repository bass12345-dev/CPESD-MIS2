<?php

namespace App\Http\Controllers\system_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Google\Client;
use Google\Service\Drive;

class BackUpDBController extends Controller
{
    public function index(){
        $data['title']  = 'Back Up Database';
        return view('system_management.contents.back_up_database.back_up_database')->with($data);
    }

    public function back_up_database(){
         // Database credentials
         $dbHost = env('DB_HOST');
         $dbUsername = env('DB_USERNAME');
         $dbPassword = env('DB_PASSWORD');
         $dbName = env('DB_DATABASE');


         $path = storage_path() . "//cso_files/" . . '/';






 
         // Backup file name and path
         $fileName = $dbName.'_backup-' . date('Y-m-d_H-i-s') . '.sql';
         $localFilePath = storage_path('app/' . $fileName);
 
         // Command to execute mysqldump for the backup
         $command = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$localFilePath}";
        
         // Execute the command
         $result = null;
         system($command, $result);
 
         if ($result !== 0) {
             return response()->json(['message' => 'Database backup failed'], 500);
         }
 
         // Upload to Google Drive
         $this->uploadFileToGoogleDrive($localFilePath);
 
         return response()->json(['message' => 'Database backup saved successfully', 'file' => $fileName]);
    }

    private function uploadFileToGoogleDrive($backupFilePath)
    {
        $folderId = '1mrgamhT_oaVVzirJxkc0yGV7MobGls-m'; // Replace with the ID of your existing Google Drive folder

        // Initialize Google Client
        $client = new Client();
        $client->setApplicationName('Laravel Google Drive Upload');
        $client->setAuthConfig(storage_path('app/service_account.json')); // Path to your service account JSON file
        $client->setScopes([Drive::DRIVE_FILE]);

        // Create a new Google Drive service
        $driveService = new Drive($client);

        // Upload the backup file
        $this->uploadFile($driveService, $backupFilePath, basename($backupFilePath), $folderId);
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
