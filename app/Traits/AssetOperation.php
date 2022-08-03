<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\AppMedia;

trait AssetOperation
{
    protected static function boot()
    {
        parent::boot();
        static::saved(function ($data) {
            if (request()->hasFile('image')) {
                if ($data->media()->exists()) {
                    $image = AppMedia::where(['app_mediaable_type' => get_class($data),'app_mediaable_id' => $data->id ,'media_type' => 'image'])->first();
                    $image->delete();
                    if (file_exists(storage_path('app/public/'.$image->media))) {
                        \File::delete(storage_path('app/public/'.$image->media));
                    }
                }
                $class_basename = Str::snake(class_basename(get_class($data)));
                $image_name = time().'.'.request()->image->extension();  
                $path = self::checkOrCreateDirectory(storage_path('app/public/images/'.$class_basename));
                request()->image->move($path, $image_name);
                $data->media()->create(['media' => 'images/' . $class_basename . '/' .$image_name,'media_type' => 'image']);
            }
        });

        static::deleted(function ($data) {
            if ($data->media()->exists()) {
                $image = AppMedia::where(['app_mediaable_type' => get_class($data),'app_mediaable_id' => $data->id ,'media_type' => 'image'])->first();
                if (file_exists(storage_path('app/public/'.$image->media))) {
                    \File::delete(storage_path('app/public/'.$image->media));
                }
                $image->delete();
            }
        });
    }

    public function media()
    {
        return $this->morphOne(AppMedia::class, 'app_mediaable');
    }

    public function getImageAttribute()
    {
        $image = $this->media()->exists() ? 'storage/'.$this->media?->media : 'global/images/default_image.jpeg'; //setting('default_image')
        return asset($image);
    }

    private static function checkOrCreateDirectory($path)
    {
        if (!\File::isDirectory($path)) {
            \File::makeDirectory($path, 0755, true);
        }
        return $path;
    }
}
