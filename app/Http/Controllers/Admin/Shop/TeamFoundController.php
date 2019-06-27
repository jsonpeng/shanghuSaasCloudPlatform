<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateTeamFoundRequest;
use App\Http\Requests\UpdateTeamFoundRequest;
use App\Repositories\TeamFoundRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TeamFoundController extends AppBaseController
{
    /** @var  TeamFoundRepository */
    private $teamFoundRepository;

    public function __construct(TeamFoundRepository $teamFoundRepo)
    {
        $this->teamFoundRepository = $teamFoundRepo;
    }

    /**
     * Display a listing of the TeamFound.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->teamFoundRepository->pushCriteria(new RequestCriteria($request));
        $teamFounds = $this->teamFoundRepository->all();

        return view('admin.team_founds.index')
            ->with('teamFounds', $teamFounds);
    }

    /**
     * Show the form for creating a new TeamFound.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.team_founds.create');
    }

    /**
     * Store a newly created TeamFound in storage.
     *
     * @param CreateTeamFoundRequest $request
     *
     * @return Response
     */
    public function store(CreateTeamFoundRequest $request)
    {
        $input = $request->all();

        $teamFound = $this->teamFoundRepository->create($input);

        Flash::success('Team Found saved successfully.');

        return redirect(route('teamFounds.index'));
    }

    /**
     * Display the specified TeamFound.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $teamFound = $this->teamFoundRepository->findWithoutFail($id);

        if (empty($teamFound)) {
            Flash::error('Team Found not found');

            return redirect(route('teamFounds.index'));
        }

        return view('admin.team_founds.show')->with('teamFound', $teamFound);
    }

    /**
     * Show the form for editing the specified TeamFound.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $teamFound = $this->teamFoundRepository->findWithoutFail($id);

        if (empty($teamFound)) {
            Flash::error('Team Found not found');

            return redirect(route('teamFounds.index'));
        }

        return view('admin.team_founds.edit')->with('teamFound', $teamFound);
    }

    /**
     * Update the specified TeamFound in storage.
     *
     * @param  int              $id
     * @param UpdateTeamFoundRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeamFoundRequest $request)
    {
        $teamFound = $this->teamFoundRepository->findWithoutFail($id);

        if (empty($teamFound)) {
            Flash::error('Team Found not found');

            return redirect(route('teamFounds.index'));
        }

        $teamFound = $this->teamFoundRepository->update($request->all(), $id);

        Flash::success('Team Found updated successfully.');

        return redirect(route('teamFounds.index'));
    }

    /**
     * Remove the specified TeamFound from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $teamFound = $this->teamFoundRepository->findWithoutFail($id);

        if (empty($teamFound)) {
            Flash::error('Team Found not found');

            return redirect(route('teamFounds.index'));
        }

        $this->teamFoundRepository->delete($id);

        Flash::success('Team Found deleted successfully.');

        return redirect(route('teamFounds.index'));
    }
}
