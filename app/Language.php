<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{


    protected $primaryKey = 'idLanguage';

    /** Mass Assignment Protection   */
    protected $guarded = [];

    /** Table name   */
    protected $table = 'languages' ;

    /**
     * open request attributes and return new instance
     * @param array $attributes
     * @return static
     */
    public static function open(array $attributes)    {
        return new static($attributes);
    }
}
