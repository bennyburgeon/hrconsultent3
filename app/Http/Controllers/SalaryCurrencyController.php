<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalaryCurrencyRequest;
use App\Http\Requests\updateSalaryCurrencyRequest;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\Plan;
use App\Models\SalaryCurrency;
use App\Repositories\SalaryCurrencyRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SalaryCurrencyController extends AppBaseController
{
    /** @var SalaryCurrencyRepository */
    private $salaryCurrencyRepository;

    public function __construct(SalaryCurrencyRepository $salaryCurrencyRepo)
    {
        $this->salaryCurrencyRepository = $salaryCurrencyRepo;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('salary_currencies.index');
    }

    /**
     * @param  CreateSalaryCurrencyRequest  $request
     *
     *
     * @return JsonResponse
     */
    public function store(CreateSalaryCurrencyRequest $request)
    {
        $input = $request->all();
        $this->salaryCurrencyRepository->create($input);

        return $this->sendSuccess(__('messages.flash.salary_currency_store'));
    }

    /**
     * @param  SalaryCurrency  $currency
     *
     * @return JsonResponse
     */
    public function edit(SalaryCurrency $currency)
    {
        return $this->sendResponse($currency, __('messages.flash.salary_currency_edit'));
    }

    /**
     * @param  updateSalaryCurrencyRequest  $request
     *
     *
     * @param $currencyId
     * @return JsonResponse
     */
    public function update(updateSalaryCurrencyRequest $request, $currencyId)
    {
        $input = $request->all();
        $this->salaryCurrencyRepository->update($input, $currencyId);

        return $this->sendSuccess(__('messages.flash.salary_currency_update'));

    }

    /**
     * @param  SalaryCurrency  $currency
     *
     * @return JsonResponse
     */
    public function destroy(SalaryCurrency $currency)
    {
        $model = [
            Plan::class,
        ];
        $result = canDelete($model, 'salary_currency_id', $currency->id);
        if(!$result){
            $result = canDelete([Job::class], 'currency_id', $currency->id);
        }
        if (!$result) {
            $result = canDelete([Candidate::class], 'salary_currency', $currency->id);
        }
        if ($result) {
            return $this->sendError(__('messages.flash.salary_currency_cant_delete'));
        }
        $currency->delete();

        return $this->sendSuccess(__('messages.flash.salary_currency_destroy'));
    }
}
