<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIndustryRequest;
use App\Http\Requests\UpdateIndustryRequest;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Industry;
use App\Repositories\IndustryRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;

class IndustryController extends AppBaseController
{
    /** @var IndustryRepository */
    private $industryRepository;

    public function __construct(IndustryRepository $industryRepo)
    {
        $this->industryRepository = $industryRepo;
    }

    /**
     * Display a listing of the Industry.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('industries.index');
    }

    /**
     * Store a newly created Industry in storage.
     *
     * @param  CreateIndustryRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateIndustryRequest $request): JsonResponse
    {
        $input = $request->all();
        $industry = $this->industryRepository->create($input);

        return $this->sendResponse($industry, __('messages.flash.industry_save'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Industry  $industry
     *
     * @return JsonResponse
     */
    public function edit(Industry $industry)
    {
        return $this->sendResponse($industry, 'Industry Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified Industry.
     *
     * @param  Industry  $industry
     *
     * @return JsonResponse
     */
    public function show(Industry $industry)
    {
        return $this->sendResponse($industry, 'Industry Retrieved Successfully.');
    }

    /**
     * Update the specified Industry in storage.
     *
     * @param  UpdateIndustryRequest  $request
     * @param  Industry  $industry
     *
     * @return JsonResponse
     */
    public function update(UpdateIndustryRequest $request, Industry $industry)
    {
        $input = $request->all();
        $this->industryRepository->update($input, $industry->id);

        return $this->sendSuccess(__('messages.flash.industry_update'));
    }

    /**
     * Remove the specified Industry from storage.
     *
     * @param  Industry  $industry
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Industry $industry)
    {
        $Models = [
            Candidate::class,
            Company::class,
        ];
        $result = canDelete($Models, 'industry_id', $industry->id);
        if ($result) {
            return $this->sendError(__('messages.flash.industry_cant_delete'));
        }
        $industry->delete();

        return $this->sendSuccess(__('messages.flash.industry_delete'));
    }
}
