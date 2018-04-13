<?php

namespace App\Http\Controllers\App\Repositories;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LoginCreateRequest;
use App\Http\Requests\LoginUpdateRequest;
use App\Repositories\App\Repositories\LoginRepository;
use App\Validators\App\Repositories\LoginValidator;

/**
 * Class LoginsController.
 *
 * @package namespace App\Http\Controllers\App\Repositories;
 */
class LoginsController extends Controller
{
    /**
     * @var LoginRepository
     */
    protected $repository;

    /**
     * @var LoginValidator
     */
    protected $validator;

    /**
     * LoginsController constructor.
     *
     * @param LoginRepository $repository
     * @param LoginValidator $validator
     */
    public function __construct(LoginRepository $repository, LoginValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $logins = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $logins,
            ]);
        }

        return view('logins.index', compact('logins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LoginCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(LoginCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $login = $this->repository->create($request->all());

            $response = [
                'message' => 'Login created.',
                'data'    => $login->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $login = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $login,
            ]);
        }

        return view('logins.show', compact('login'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $login = $this->repository->find($id);

        return view('logins.edit', compact('login'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LoginUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(LoginUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $login = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Login updated.',
                'data'    => $login->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Login deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Login deleted.');
    }
}
