<?php

namespace App\Models;

class Country extends AppwriteModel
{
    protected string $collectionName = 'countries';
    
    public $translatable = ['name'];

    public function destinations()
    {
        return Destination::where('country_id', $this->id);
    }
}
