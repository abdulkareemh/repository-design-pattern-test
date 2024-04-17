<?php

namespace App\Services;

class StoreImageService
{
    public function storeImage($image, $directory)
    {
        $imageName =  uniqid('', true) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/'. $directory.'/', $imageName);
        return 'storage/'. $directory .'/'. $imageName;
    }

}