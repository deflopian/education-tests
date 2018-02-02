<?php

namespace Deflopian\EducationTests\Models;

use Deflopian\EducationTests\Models\Traits\ExcludeFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Variant extends Model
{
    use ExcludeFields;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'question_id', 'is_correct', 'uuid', 'order_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('education-tests.variants_table');
    }
}
