<?php

namespace App\Models;

use App\Interfaces\TeamModelConstantInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class TeamModel extends Model implements TeamModelConstantInterface
{
    use HasFactory,SoftDeletes;

    protected $fillable = [self::NAME,self::SLUG];

    protected $table = self::TABLE_NAME;

    /**
     * @return Collection
     */
    public function getAllTeams() : Collection
    {
        return ($this->newQuery())->get();
    }

    /**
     * @param $slug
     * @return int
     */
    public function getSlugCount($slug) : int
    {
        return ($this->newQuery())
            ->where(self::SLUG,$slug)
            ->count();
    }

    public function updateWinnerFlag(array $teamIds,int $step)
    {
        ($this->newQuery())
            ->whereIn(self::ID,$teamIds)
            ->update([self::IS_WINNER => 1, self::STEP => $step]);
    }

    public function updateLoserFlag(array $teamIds,int $step)
    {
        ($this->newQuery())
            ->whereNotIn(self::ID,$teamIds)
            ->update([self::IS_WINNER => 0, self::STEP => $step]);
    }
}
