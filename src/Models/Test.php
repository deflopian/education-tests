<?php

namespace Deflopian\EducationTests\Models;

use Deflopian\EducationTests\Models\Traits\ExcludeFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Test extends Model
{
    use ExcludeFields;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'uuid', 'allowable_mistakes_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

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
        $this->table = Config::get('education-tests.tests_table');
    }

    /**
     * @return Question[]
     */
    public function getQuestions() {
        return Question::whereTestId($this->id)->get();
    }
}
