<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService {
    private $fileName;
    private $fileInput;

    /**
     * This properties for setting an Imageable model.
     * The image will be saved for a specified model class and 
     * a specified model id.
     */
    private $modelId = null;
    private $modelType = null;

    public function setModelId(int $modelId)
    {
        $this->modelId = $modelId;
    }

    public function setModelType(string $modelType)
    {
        $this->modelType = $modelType;
    }
    
    /**
     * Checking whether file is multiple
     * 
     * @param array|UploadFile $fileInput
     * @return bool
     */
    public function isMultiple($fileInput)
    {
        return is_array($fileInput);
    }

    /**
     * Uploading a file
     * 
     * @param UploadFile $fileInput
     * @return void
     */
    public function upload($fileInput)
    {
        $this->fileInput = $fileInput;

        if($this->isMultiple($fileInput)) {
            $this->uploadMultiple($fileInput);
        }

        $extension = $fileInput->getClientOriginalExtension();
        $this->fileName = 'img_' . time() . '.' . $extension;

        if($this->fileInfoIsNotSaveable()) {
            throw new \InvalidArgumentException(
                __('messages.exception.upload_image')
            );
        }

        $fileInput->storeAs('public/images', $this->fileName);
        $this->saveFileInfo();
    }

    /**
     * Uploading multiple files
     * 
     * @param array $fileInput
     * @return void
     */
    public function uploadMultiple($fileInput)
    {
        foreach($fileInput as $file) {
            $this->upload($file);
        }
    }

    /**
     * Checking whether file info have to be saved in a database 
     * 
     * @return bool
     */
    public function fileInfoIsNotSaveable()
    {
        return is_null($this->modelId) || is_null($this->modelType);
    }

    /**
     * Saving file info in a database
     * 
     * @return void
     */
    public function saveFileInfo()
    {
        Image::create([
            'name' => $this->fileName,
            'mime' => $this->fileInput->getClientMimeType(),
            'imageable_id' => $this->modelId,
            'imageable_type' => $this->modelType
        ]);
    }

    /**
     * Updating file info in a database
     * 
     * @param Image $imgModel
     * @return void
     */
    public function updateFileInfo($imgModel)
    {
        $imgModel->update([
            'name' => $this->fileName,
            'mime' => $this->fileInput->getClientMimeType(),
        ]);
    }

    /**
     * Deleting a file
     * 
     * @param Image $image
     * @return void
     */
    public function delete($image)
    {
        if($image && Storage::exists('public/images/' . $image->name)) {
            Storage::delete('public/images/' . $image->name);
        }

        $image->delete();
    }
}