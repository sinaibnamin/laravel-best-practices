<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;

trait ImageUploaderTrait
{
    public function optimize_move_image($file, $destinationPath, int $height = 200)
    {
       
        if ($file) {
            $imgname = time() . '_' . $file->hashName(); // Combine timestamp and hash name
            $imgname = pathinfo($imgname, PATHINFO_FILENAME) . '.jpg'; // Ensure .jpg extension

            // Ensure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Resize, convert to JPEG, and optimize the image
            $img = Image::make($file)
                ->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio(); // Maintain aspect ratio
                    $constraint->upsize(); // Prevent upsizing the image
                })
                ->encode('jpg', 75); // Convert to JPEG and set quality to 75

            // Save the optimized image
            $img->save($destinationPath . '/' . $imgname);

            return $imgname; // Return the saved image name
        }

        return null; // Return null if no file is provided
    }
}
