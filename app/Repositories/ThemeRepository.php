<?php

namespace App\Repositories;

use App\Models\Theme;
use InfyOm\Generator\Common\BaseRepository;

class ThemeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'subtitle',
        'intro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Theme::class;
    }
}
