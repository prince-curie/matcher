<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Services\SearchProfileService;
use App\Http\Services\PrepareScoreService;

class SearchProfileController extends Controller
{
    private SearchProfileService $searchProfileService;
    private PrepareScoreService $prepareScoreService;

    function __construct(
        SearchProfileService $searchProfileService,
        PrepareScoreService $prepareScoreService
    )
    {
        $this->searchProfileService = $searchProfileService;
        $this->prepareScoreService = $prepareScoreService;
    }
    /**
     * Gets the matching searches for a property with its search score
     * 
     * @param Request $request
     * 
     * @return Response 
     */
    public function __invoke(Request $request)
    {
        $data = optional($request->query());

        $search = $this->searchProfileService->find($data);
            
        $addScore = $this->prepareScoreService->score($search, $data);
        
        if($addScore[0]['score'] == 0) return response(
            ['message' => 'Search profile not found'], 404
        );

        return response($addScore, 200);
    }
}
