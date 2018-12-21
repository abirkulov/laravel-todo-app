<?php

namespace App\Services;

use App\Models\Images;
use Illuminate\Support\Facades\Storage;

class ImageService {
    private $fileInput;
    private $fileName;
    private $params;

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
     * @param array|null $params
     * @return void
     */
    public function upload($fileInput, $params = null)
    {
        $this->params = $params;
        $this->fileInput = $fileInput;

        if($this->isMultiple($fileInput)) {
            $this->uploadMultiple($fileInput);
        }

        $extension = $fileInput->getClientOriginalExtension();
        $this->fileName = 'img_' . time() . '.' . $extension;

        if($this->fileInfoIsSaveable()) {
            $this->saveFileInfo($params['modelId'], $params['modelType']);
        }

        $fileInput->storeAs('public/images', $this->fileName);
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
    public function fileInfoIsSaveable()
    {
        return array_has($this->params, 'modelId') && array_has($this->params, 'modelType');
    }

    /**
     * Saving file info in a database
     * 
     * @param integer $modelId
     * @param string $modelType
     * @return void
     */
    public function saveFileInfo($modelId, $modelType)
    {
        Images::create([
            'name' => $this->fileName,
            'mime' => $this->fileInput->getClientMimeType(),
            'imageable_id' => $modelId,
            'imageable_type' => $modelType
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
        if(Storage::exists('public/images/' . $image->name)) {
            Storage::delete('public/images/' . $image->name);
        }

        $image->delete();
    }
}