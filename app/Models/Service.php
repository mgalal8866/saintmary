<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'services';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'service_id',
        'subservies_id',
        'mainservice',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function service()
    {
        return $this->belongsTo(self::class, 'service_id');
    }

    public function subservies()
    {
        return $this->belongsTo(self::class, 'subservies_id');
    }
    public function service_attribute()
    {
        return $this->hasMany(ServicesAttribute::class, 'service_id');
    }
}
