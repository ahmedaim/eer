<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $primaryKey = 'idCountry';

    /** Mass Assignment Protection   */
    protected $guarded = [];

    /** Table name   */
    protected $table = 'countries' ;

    /**
     * open request attributes and return new instance
     * @param array $attributes
     * @return static
     */
    public static function open(array $attributes)    {
        return new static($attributes);
    }

    /**
     *  Get all customers nationalities related to specific Country
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers_nationalities()
    {
        return $this->hasMany(Customer::class , 'idNationality') ;
    }

    /**
     *  Get all Customers residential countries related to specific Country
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers_residential_countries()
    {
        return $this->hasMany(Customer::class , 'idResidential_country') ;
    }



}
