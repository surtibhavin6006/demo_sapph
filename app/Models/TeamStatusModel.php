<?php

namespace App\Models;

use App\Interfaces\TeamStatusModelConstantInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamStatusModel extends Model implements TeamStatusModelConstantInterface
{
    use HasFactory;

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::FK_TEAM_ID,
        self::IS_WINNER,
        self::CURRENT_ROUND,
    ];
}
