<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PlatformCreateRequest;
use App\Http\Requests\PlatformUpdateRequest;
use App\Repositories\Interfaces\PlatformRepository;
use App\Repositories\Validators\PlatformValidator;

/**
 * Class PlatformsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PlatformsController extends Controller
{
    /**
     * @var PlatformRepository
     */
    protected $repository;

    /**
     * @var PlatformValidator
     */
    protected $validator;

    /**
     * PlatformsController constructor.
     *
     * @param PlatformRepository $repository
     * @param PlatformValidator $validator
     */
    public function __construct(PlatformRepository $repository, PlatformValidator $validator)
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
        $platforms = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $platforms,
            ]);
        }

        return view('platforms.index', compact('platforms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlatformCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PlatformCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $platform = $this->repository->create($request->all());

            $response = [
                'message' => 'Platform created.',
                'data'    => $platform->toArray(),
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
        $platform = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $platform,
            ]);
        }

        return view('platforms.show', compact('platform'));
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
        $platform = $this->repository->find($id);

        return view('platforms.edit', compact('platform'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PlatformUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PlatformUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $platform = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Platform updated.',
                'data'    => $platform->toArray(),
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
                'message' => 'Platform deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Platform deleted.');
    }
}
