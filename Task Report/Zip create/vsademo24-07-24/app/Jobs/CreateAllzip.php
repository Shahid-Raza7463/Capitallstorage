<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use DB;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use File;
class CreateAllzip implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    private $data;

    public function __construct($data)
    {
    $this->data = $data;
    }

    public function handle()
    {
        
      $dataa = $this->data; 

// Set Downloaded folder name 
$parentZipFileName = $dataa['assignmentgenerateid'] . '.zip';
// Set the local storage path for the zip file
$parentZipFilePath = storage_path('app/public/image/task/') . $parentZipFileName;
$parentZip = new ZipArchive;

// Open parent zip
if ($parentZip->open($parentZipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach ($dataa['assignmentfoldername'] as $foldername) {
        if ($foldername->filesname !== null) {
            // Replace server path here 
            $filePath = Storage::disk('s3')->temporaryUrl($dataa['assignmentgenerateid'].'/'.$foldername->filesname, now()->addMinutes(20));

            if ($filePath) {
                // Get the file content from the URL
                $fileContent = file_get_contents($filePath);

                if ($fileContent !== false) {
                    // Add file to the parent zip
                    $parentZip->addFromString($foldername->assignmentfoldersname . '/' . $foldername->realname, $fileContent);
                } else {
                    // Handle the case when the file content cannot be retrieved
                    // You can log an error or take appropriate action
                }
            } else {
                // Handle the case when the file URL cannot be obtained
                // You can log an error or take appropriate action
            }
        } else {
            // If there are no files, add an empty folder to maintain root structure
            $parentZip->addEmptyDir($foldername->assignmentfoldersname);
        }
    }

    $parentZip->close();
} else {
    // Handle the case when the parent zip cannot be opened
    // You can log an error or take appropriate action
}

return response()->json($parentZipFileName);
  
		
    }
}