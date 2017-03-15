<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /** Notes
     *  idUser reference to table users
     *  role col has 4 state : 1 = super user , 2 = content authority , 3 = financial  ,4 = meeting calendar
     *  thumbnail : Profile picture thumbnail
     * Gender has two param : M = Male , F = Female
     **/

    protected $primaryKey = 'idAdmin';

    /** Mass Assignment Protection   */
    protected $guarded = [];

    /** Table name   */
    protected $table = 'admins' ;

    /**
     * open request attributes and return new instance
     * @param array $attributes
     * @return static
     */
    public static function open(array $attributes)    {
        return new static($attributes);
    }

    /**
     *  Get specific Parent User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class , 'id');
    }


}
