<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $category;
    public $word;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['category'], 'string'],
            [['word'], 'string'],    
        ];
    }
}

?>