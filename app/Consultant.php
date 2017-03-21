<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    /** Notes
     *  idUser reference to table users
     *  status col has 4 state : 1 = active  ,   2 = suspended  , 3 = left the company , 4 = no time slots available
     *  Gender has two param : M = Male , F = Female
     *  idAdmin_notified : Name of administrator will be notified
     **/
    protected $primaryKey = 'idConsultantRegistration';

    /** Mass Assignment Protection   */
    protected $guarded = [];

    /** Table name   */
    protected $table = 'consultant_registrations' ;

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
