<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicesAttribute extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'services_attributes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts  =[
        'selecttype' =>'array'
    ];

    protected $fillable = [
        'service_id',
        'value',
        'type',
        'main',
        'linkservice',
        'selecttype',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        // 'image'  => 'image',
        'text'   => 'text',
        'number' => 'number',
        'select' => 'select',
        // 'link' => 'link',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
