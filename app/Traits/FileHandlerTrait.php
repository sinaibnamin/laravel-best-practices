<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait FileHandlerTrait
{
   
    public function copyImage($sourcePath, $destinationPath)
    {
        try {
            // Use base_path for source paths outside the public directory
            $fullSourcePath = $sourcePath;
            $fullDestinationPath = $destinationPath;

            // Create the destination directory if it doesn't exist
            if (!File::isDirectory(dirname($fullDestinationPath))) {
                File::makeDirectory(dirname($fullDestinationPath), 0755, true, true);
            }

            // Copy the file
            if (File::exists($fullSourcePath)) {
                File::copy($fullSourcePath, $fullDestinationPath);
                return 'File copied successfully.';
            } else {
                return 'Source file does not exist.';
            }
        } catch (\Exception $e) {
            return 'An error occurred: ' . $e->getMessage();
        }
    }
}
