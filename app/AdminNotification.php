<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{

    /** Notes
     * type col has 13 state : 1 = comment on article to be reviewed ,2 = comment on question to be reviewed ,
    //3 = reminder to meeting ,4 = answer to question to be published ,5 = survey done by customer ,
    //6 = meeting accepted by consultant ,7 = meeting rejected by consultant ,8 = consultant updated profile picture,
    // 9 = payment success by customer ,10= payment failed by customer ,11= customer uploaded profile picture ,
    //12 = new consultant registered on the system ,13 = customer write on consultant recommendation wall
     *
     *  idAdmin reference to table admins with cascade remove all rows related to parent id on delete
     *  idLanguage reference to table languages with cascade remove all rows related to parent id on delete
     *  idType : Based on the type - transaction ID will be put into this table
     *  status col has 4 state : 1 = pending to be send to customer , 2 = attempt to send and failed - no retry ,3 = succeed , 4 = retry
     **/

    protected $primaryKey = 'idNotification';

    /** Mass Assignment Protection   */
    protected $guarded = [];

    /** Table name   */
    protected $table = 'admin_notifications' ;

    /**
     * open request attributes and return new instance
     * @param array $attributes
     * @return static
     */
    public static function open(array $attributes)    {
        return new static($attributes);
    }


    /**
     *  Get specific Parent Admin
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admins()
    {
        return $this->belongsTo(Admin::class , 'idAdmin');
    }


}
