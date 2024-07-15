<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewService extends Model
{
    use HasFactory;

    public $table = 'view_services';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'service_id',
        'service_attribute_id',
        'name',
        'data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts=[
        'data'=>'array'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    // public function ScopeGetlink($link,$colum)
    // {
    //     return $this->where(['service_id'=>$link])->first() ;
    // }

    // public function service_attribute()
    // {
    //     return $this->belongsTo(ServicesAttribute::class, 'service_attribute_id');
    // }
}
