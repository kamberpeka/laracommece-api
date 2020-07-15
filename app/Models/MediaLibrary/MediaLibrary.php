<?php

namespace App\Models\MediaLibrary;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibrary extends Media
{
    use SoftDeletes;

    protected $table = 'media';

    /**
     * @return array
     */
    public function getBase64Array(){
        $path   = $this->getPath();
        $type   = pathinfo($path, PATHINFO_EXTENSION);
        $data   = file_get_contents($path);
        $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
        return ['type' => $type, 'file' => $base64];
    }
}
