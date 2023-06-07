<?php

namespace App\LivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Column;

class ImageColumn extends Column
{
    public static function make(string $title, string $from = null): Column
    {
        return parent::make($title, $from)
            ->format(function ($value) use ($title, $from) {
                if ($from == 'profile_photo_path') {
                    $imageUrl = getProfilePhotoUrlAttribute($value);
                    $img = "<img class='table-avatar' src='{$imageUrl}' alt='Avatar'>";
                } else {
                    $firstImage = is_object($value) ? $value->first() : null;
                    $imageUrl = is_null($firstImage) ? getPhotoUrlAttribute($value) : $firstImage->getPhotoUrlAttribute();
                    $img = "<img class='img-md' src='{$imageUrl}' alt='Image'>";
                }
                return $img;
            })->html();
    }
}
