<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    protected $table = 'message_templates';

    protected $fillable = [
        'partner_id',
        'title',
        'type',
        'message'
    ];

    public function getTypeTextAttribute()
    {
        if ($this->type === 'report') return 'Report Client';

        return 'Broadcast';
    }
}
