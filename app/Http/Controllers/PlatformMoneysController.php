<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PlatformMoneyCreateRequest;
use App\Http\Requests\PlatformMoneyUpdateRequest;
use App\Repositories\Interfaces\PlatformMoneyRepository;
use App\Repositories\Validators\PlatformMoneyValidator;

/**
 * Class PlatformMoneysController.
 *
 * @package namespace App\Http\Controllers;
 */
class PlatformMoneysController extends Controller
{
    /**
     * @var PlatformMoneyRepository
     */
    protected $repository;

    /**
     * @var PlatformMoneyValidator
     */
    protected $validator;

    /**
     * PlatformMoneysController constructor.
     *
     * @param PlatformMoneyRepository $repository
     * @param PlatformMoneyValidator $validator
     */
    public function __construct(PlatformMoneyRepository $repository, PlatformMoneyValidator $validator)
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
        $platformMoneys = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $platformMoneys,
            ]);
        }

        return view('platformMoneys.index', compact('platformMoneys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlatformMoneyCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PlatformMoneyCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $platformMoney = $this->repository->create($request->all());

            $response = [
                'message' => 'PlatformMoney created.',
                'data'    => $platformMoney->toArray(),
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
        $platformMoney = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $platformMoney,
            ]);
        }

        return view('platformMoneys.show', compact('platformMoney'));
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
        $platformMoney = $this->repository->find($id);

        return view('platformMoneys.edit', compact('platformMoney'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PlatformMoneyUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PlatformMoneyUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $platformMoney = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PlatformMoney updated.',
                'data'    => $platformMoney->toArray(),
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
                'message' => 'PlatformMoney deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PlatformMoney deleted.');
    }
}
