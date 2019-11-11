<?php
namespace Brarcos\LogErrorFrontend\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorFrontend extends Model
{
    protected $table = 'errors_frontend';

    protected $fillable = [
        'user_id',
        'url',
        'user_agent',
        'ip',
        'error',
        'error_data',
    ];

    public function usuario()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
