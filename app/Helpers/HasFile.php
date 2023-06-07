<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasFile
{
    /**
     * Update the model's file.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return void
     */
    public function addFile(UploadedFile $file)
    {
        $attribute = $this->getFileAttribute();
        $path = $this::PATH;

        tap($this->$attribute, function ($previous) use ($file, $attribute, $path) {
            $this->forceFill([
                $attribute => $file->storePublicly(
                    $path, ['disk' => $this->fileDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->fileDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the model's file.
     *
     * @return void
     */
    public function deleteFile()
    {
        $attribute = $this->getFileAttribute();

        Storage::disk($this->fileDisk())->delete($this->$attribute);

        $this->forceFill([
            $attribute => null,
        ])->save();
    }

    /**
     * Get the URL to the model's file.
     *
     * @return string
     */
    public function getFileUrlAttribute(): string
    {
        $attribute = $this->getFileAttribute();

        return $this->$attribute
            ? Storage::disk($this->fileDisk())->url($this->$attribute)
            : $this->defaultFileUrl();
    }

    /**
     * Get the default file URL if no file has been uploaded.
     *
     * @return string
     */
    protected function defaultFileUrl(): string
    {
        return asset('img/default-150x150.png');
    }

    /**
     * Get the disk that files should be stored on.
     *
     * @return string
     */
    protected function fileDisk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('livewire.file_disk', 'public');
    }

    protected function getFileAttribute(): string
    {
        return 'attach_file_path';
    }

    protected function getFilePath(): string
    {
        return 'files';
    }
}
