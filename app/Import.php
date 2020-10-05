<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title', 'rows', 'inserted', 'failed', 'startedAt', 'endedAt', 'duration'
    ];
    /**
     * Table TimeStamps
     *
     * @var boolean
     */
    public $timestamps = false;
}
