<?php

namespace App\Repositories;

use App\Interfaces\TeamModelConstantInterface;
use App\Models\TeamModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TeamRepository implements TeamModelConstantInterface
{
    /**
     * @param Request $request
     * @return TeamModel
     */
    public function saveTeam(Request $request) : TeamModel
    {
        $teamModel = new TeamModel();
        $teamModel->{self::NAME} = $request->name;
        $teamModel->{self::SLUG} = Str::slug($request->name);
        $teamModel->save();
        return $teamModel;
    }

    /**
     * @return Collection
     */
    public function listAllTeams() : Collection
    {
        return (new TeamModel())->getAllTeams();
    }

    /**
     * @param $title
     * @return int
     */
    public function checkDuplicateSlugAvailable($title) : int
    {
        return ((new TeamModel())->getSlugCount(Str::slug($title))) > 0;
    }

    /**
     * @param array $teamIds
     * @return bool
     */
    public function saveWinners(array $teamIds,$step) : bool
    {
        (new TeamModel())->updateWinnerFlag($teamIds,$step);
        (new TeamModel())->updateLoserFlag($teamIds,$step);

        return true;
    }

}
