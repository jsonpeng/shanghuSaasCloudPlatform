<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateTeamFollowRequest;
use App\Http\Requests\UpdateTeamFollowRequest;
use App\Repositories\TeamFollowRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TeamFollowController extends AppBaseController
{
    /** @var  TeamFollowRepository */
    private $teamFollowRepository;

    public function __construct(TeamFollowRepository $teamFollowRepo)
    {
        $this->teamFollowRepository = $teamFollowRepo;
    }

    /**
     * Display a listing of the TeamFollow.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->teamFollowRepository->pushCriteria(new RequestCriteria($request));
        $teamFollows = $this->teamFollowRepository->all();

        return view('admin.team_follows.index')
            ->with('teamFollows', $teamFollows);
    }

    /**
     * Show the form for creating a new TeamFollow.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.team_follows.create');
    }

    /**
     * Store a newly created TeamFollow in storage.
     *
     * @param CreateTeamFollowRequest $request
     *
     * @return Response
     */
    public function store(CreateTeamFollowRequest $request)
    {
        $input = $request->all();

        $teamFollow = $this->teamFollowRepository->create($input);

        Flash::success('Team Follow saved successfully.');

        return redirect(route('teamFollows.index'));
    }

    /**
     * Display the specified TeamFollow.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $teamFollow = $this->teamFollowRepository->findWithoutFail($id);

        if (empty($teamFollow)) {
            Flash::error('Team Follow not found');

            return redirect(route('teamFollows.index'));
        }

        return view('admin.team_follows.show')->with('teamFollow', $teamFollow);
    }

    /**
     * Show the form for editing the specified TeamFollow.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $teamFollow = $this->teamFollowRepository->findWithoutFail($id);

        if (empty($teamFollow)) {
            Flash::error('Team Follow not found');

            return redirect(route('teamFollows.index'));
        }

        return view('admin.team_follows.edit')->with('teamFollow', $teamFollow);
    }

    /**
     * Update the specified TeamFollow in storage.
     *
     * @param  int              $id
     * @param UpdateTeamFollowRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeamFollowRequest $request)
    {
        $teamFollow = $this->teamFollowRepository->findWithoutFail($id);

        if (empty($teamFollow)) {
            Flash::error('Team Follow not found');

            return redirect(route('teamFollows.index'));
        }

        $teamFollow = $this->teamFollowRepository->update($request->all(), $id);

        Flash::success('Team Follow updated successfully.');

        return redirect(route('teamFollows.index'));
    }

    /**
     * Remove the specified TeamFollow from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $teamFollow = $this->teamFollowRepository->findWithoutFail($id);

        if (empty($teamFollow)) {
            Flash::error('Team Follow not found');

            return redirect(route('teamFollows.index'));
        }

        $this->teamFollowRepository->delete($id);

        Flash::success('Team Follow deleted successfully.');

        return redirect(route('teamFollows.index'));
    }
}
