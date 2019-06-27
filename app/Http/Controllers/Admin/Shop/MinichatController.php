<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateMinichatRequest;
use App\Http\Requests\UpdateMinichatRequest;
use App\Repositories\MinichatRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MinichatController extends AppBaseController
{
    /** @var  MinichatRepository */
    private $minichatRepository;

    public function __construct(MinichatRepository $minichatRepo)
    {
        $this->minichatRepository = $minichatRepo;
    }

    /**
     * Display a listing of the Minichat.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->minichatRepository->pushCriteria(new RequestCriteria($request));
        $minichats = $this->minichatRepository->all();

        return view('minichats.index')
            ->with('minichats', $minichats);
    }

    /**
     * Show the form for creating a new Minichat.
     *
     * @return Response
     */
    public function create()
    {
        return view('minichats.create');
    }

    /**
     * Store a newly created Minichat in storage.
     *
     * @param CreateMinichatRequest $request
     *
     * @return Response
     */
    public function store(CreateMinichatRequest $request)
    {
        $input = $request->all();

        $minichat = $this->minichatRepository->create($input);

        Flash::success('Minichat saved successfully.');

        return redirect(route('minichats.index'));
    }

    /**
     * Display the specified Minichat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $minichat = $this->minichatRepository->findWithoutFail($id);

        if (empty($minichat)) {
            Flash::error('Minichat not found');

            return redirect(route('minichats.index'));
        }

        return view('minichats.show')->with('minichat', $minichat);
    }

    /**
     * Show the form for editing the specified Minichat.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $minichat = $this->minichatRepository->findWithoutFail($id);

        if (empty($minichat)) {
            Flash::error('Minichat not found');

            return redirect(route('minichats.index'));
        }

        return view('minichats.edit')->with('minichat', $minichat);
    }

    /**
     * Update the specified Minichat in storage.
     *
     * @param  int              $id
     * @param UpdateMinichatRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMinichatRequest $request)
    {
        $minichat = $this->minichatRepository->findWithoutFail($id);

        if (empty($minichat)) {
            Flash::error('Minichat not found');

            return redirect(route('minichats.index'));
        }

        $minichat = $this->minichatRepository->update($request->all(), $id);

        Flash::success('Minichat updated successfully.');

        return redirect(route('minichats.index'));
    }

    /**
     * Remove the specified Minichat from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $minichat = $this->minichatRepository->findWithoutFail($id);

        if (empty($minichat)) {
            Flash::error('Minichat not found');

            return redirect(route('minichats.index'));
        }

        $this->minichatRepository->delete($id);

        Flash::success('Minichat deleted successfully.');

        return redirect(route('minichats.index'));
    }
}
