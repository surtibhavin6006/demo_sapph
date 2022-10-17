<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AddTeamRequest;
use App\Http\Resources\Api\V1\TeamResource;
use App\Http\Resources\Api\V1\TeamResourceCollection;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public $teamRepository;
    public function __construct(
        TeamRepository $teamRepository
    )
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return TeamResourceCollection
     */
    public function index(Request $request)
    {
        // get all active teams
        $response =  $this->teamRepository->listAllTeams();
        return new TeamResourceCollection($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddTeamRequest  $request
     * @return TeamResource
     */
    public function store(AddTeamRequest $request)
    {
        // create a team and add a validation to not enter team more than 8 and slug should be unique
        $team = $this->teamRepository->saveTeam($request);
        return new TeamResource($team);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return TeamResourceCollection
     */
    public function winnerStep(Request $request,$stepId)
    {
        $this->teamRepository->saveWinners($request->winner_ids,$stepId);
        $response =  $this->teamRepository->listAllTeams();
        return new TeamResourceCollection($response);
    }
}
