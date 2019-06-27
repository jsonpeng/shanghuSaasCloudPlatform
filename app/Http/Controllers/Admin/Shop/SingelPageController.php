<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateSingelPageRequest;
use App\Http\Requests\UpdateSingelPageRequest;
use App\Repositories\SingelPageRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Overtrue\Pinyin\Pinyin;

class SingelPageController extends AppBaseController
{
    /** @var  SingelPageRepository */
    private $singelPageRepository;

    public function __construct(SingelPageRepository $singelPageRepo)
    {
        $this->singelPageRepository = $singelPageRepo;
    }

    /**
     * Display a listing of the SingelPage.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->singelPageRepository->pushCriteria(new RequestCriteria($request));
        $singelPages = $this->singelPageRepository->descToShow();

        return view('admin.singel_pages.index')
            ->with('singelPages', $singelPages);
    }

    /**
     * Show the form for creating a new SingelPage.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.singel_pages.create');
    }

    /**
     * Store a newly created SingelPage in storage.
     *
     * @param CreateSingelPageRequest $request
     *
     * @return Response
     */
    public function store(CreateSingelPageRequest $request)
    {
        $input = $request->all();
        if (!array_key_exists('slug', $input) || $input['slug'] == '') {
            $pinyin = new Pinyin();
            $input['slug'] = $pinyin->permalink($input['name']);
        }
        $singelPage = $this->singelPageRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('singelPages.index'));
    }

    /**
     * Display the specified SingelPage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $singelPage = $this->singelPageRepository->findWithoutFail($id);

        if (empty($singelPage)) {
            Flash::error('没有找到');

            return redirect(route('singelPages.index'));
        }

        return view('admin.singel_pages.show')->with('singelPage', $singelPage);
    }

    /**
     * Show the form for editing the specified SingelPage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $singelPage = $this->singelPageRepository->findWithoutFail($id);

        if (empty($singelPage)) {
            Flash::error('没有找到');

            return redirect(route('singelPages.index'));
        }

        return view('admin.singel_pages.edit')->with('singelPage', $singelPage);
    }

    /**
     * Update the specified SingelPage in storage.
     *
     * @param  int              $id
     * @param UpdateSingelPageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSingelPageRequest $request)
    {
        $singelPage = $this->singelPageRepository->findWithoutFail($id);

        if (empty($singelPage)) {
            Flash::error('没有找到');

            return redirect(route('singelPages.index'));
        }
        $input=$request->all();
        if (!array_key_exists('slug', $input) || $input['slug'] == '') {
            $pinyin = new Pinyin();
            $input['slug'] = $pinyin->permalink($input['name']);
        }
        $singelPage = $this->singelPageRepository->update($input, $id);

        Flash::success('保存成功');

        return redirect(route('singelPages.index'));
    }

    /**
     * Remove the specified SingelPage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $singelPage = $this->singelPageRepository->findWithoutFail($id);

        if (empty($singelPage)) {
            Flash::error('没有找到');

            return redirect(route('singelPages.index'));
        }

        $this->singelPageRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('singelPages.index'));
    }
}
