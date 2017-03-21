<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    /** Notes
     *  active has 5 param : 1 = active, 2 = suspended ,3 = deleted by admin ,4 = expired ,5 = blocked
     *  Gender has two param : M = Male , F = Female
     *  idNationality reference to Country table
     *  idResidential_country reference to Country table
     **/
    protected $primaryKey = 'idCustomer';

    /** Mass Assignment Protection   */
    protected $guarded = [];

    /** Table name    */
    protected $table = 'customers' ;

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


    /**
     *  Get specific Parent Country
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nationality()
    {
        return $this->belongsTo(Country::class , 'idCountry');
    }

    /**
     *  Get specific Parent Country
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function residential_country()
    {
        return $this->belongsTo(Country::class , 'idCountry');
    }

}
