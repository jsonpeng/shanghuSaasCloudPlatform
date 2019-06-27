<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateUserLevelRequest;
use App\Http\Requests\UpdateUserLevelRequest;
use App\Repositories\UserLevelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\User;

class UserLevelController extends AppBaseController
{
    /** @var  UserLevelRepository */
    private $userLevelRepository;

    public function __construct(UserLevelRepository $userLevelRepo)
    {
        $this->userLevelRepository = $userLevelRepo;
    }

    /**
     * Display a listing of the UserLevel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userLevelRepository->pushCriteria(new RequestCriteria($request));

        $this->userLevelRepository->accountLevel(admin()->account);

        $userLevels = $this->defaultSearchState($this->userLevelRepository);

        $userLevels = $this->accountInfo($userLevels,false,'asc');

       //dd($this->userLevelRepository->nextLevel(2,admin()->account));

        return view('admin.user_levels.index')
            ->with('userLevels', $userLevels);
    }

    /**
     * Show the form for creating a new UserLevel.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.user_levels.create');
    }

    /**
     * Store a newly created UserLevel in storage.
     *
     * @param CreateUserLevelRequest $request
     *
     * @return Response
     */
    public function store(CreateUserLevelRequest $request)
    {
        $input = $request->all();

        $input = attachAccoutInput($input);

        $userLevel = $this->userLevelRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('userLevels.index'));
    }

    /**
     * Display the specified UserLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userLevel = $this->userLevelRepository->findWithoutFail($id);

        if (empty($userLevel)) {
            Flash::error('信息不存在');

            return redirect(route('userLevels.index'));
        }

        return view('admin.user_levels.show')->with('userLevel', $userLevel);
    }

    /**
     * Show the form for editing the specified UserLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userLevel = $this->userLevelRepository->findWithoutFail($id);

        if (empty($userLevel)) {
            Flash::error('信息不存在');

            return redirect(route('userLevels.index'));
        }

        return view('admin.user_levels.edit')->with('userLevel', $userLevel);
    }

    /**
     * Update the specified UserLevel in storage.
     *
     * @param  int              $id
     * @param UpdateUserLevelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserLevelRequest $request)
    {
        $userLevel = $this->userLevelRepository->findWithoutFail($id);

        if (empty($userLevel)) {
            Flash::error('信息不存在');
            return redirect(route('userLevels.index'));
        }

        $input = $request->all();
        
        $input = attachAccoutInput($input);

        $userLevel = $this->userLevelRepository->update($input, $id);

        Flash::success('更新成功');

        return redirect(route('userLevels.index'));
    }

    /**
     * Remove the specified UserLevel from storage.
     *
     * @param  int $id 
     *
     * @return Response
     */
    public function destroy($id)
    {
        $levelCount = User::where('user_level', $id)->count();
        if ($levelCount) {
            Flash::error('该等级下有用户存在，不能删除');
            return redirect(route('userLevels.index'));
        }
        $userLevel = $this->userLevelRepository->findWithoutFail($id);

        if (empty($userLevel)) {
            Flash::error('信息不存在');
            return redirect(route('userLevels.index'));
        }

        $this->userLevelRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('userLevels.index'));
    }
}
