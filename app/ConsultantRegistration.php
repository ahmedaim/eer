<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantRegistration extends Model
{


    /** Notes
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



}
