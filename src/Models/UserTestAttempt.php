<?php

namespace Deflopian\EducationTests\Models;

use Deflopian\EducationTests\Models\Traits\ExcludeFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class UserTestAttempt extends Model
{
    use ExcludeFields;

    protected $casts = [
        'answers' => 'json'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answers', 'result', 'passed', 'attempt_num', 'test_id', 'user_id', 'uuid'
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
        $this->table = Config::get('education-tests.user_test_attempts_table');
    }
}
