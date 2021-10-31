<?php

namespace App\Http\Controllers;

use App\Models\SearchProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SearchProfileController extends Controller
{
    /**
     * Gets the matching searches for a property
     *
     * @todo make a call from property 
     * services and do searchs based on the call
     * 
     * @param Request $request
     * 
     * @return Response 
     */
    public function __invoke(Request $request)
    {
        $data = optional($request->query());
        
        $search = SearchProfile::query()
            ->when(!is_null($data['price']), function($query) use($data) {
                return $query->where('min_price', $data['price'])
                    ->orWhere('max_price', $data['price'])
                    ->orWhere([
                        ['min_price', '>=', $data['price'] - (0.25 * $data['price'])],
                        ['min_price', '<=', $data['price']]
                    ])
                    ->orWhere([
                        ['max_price', '<=', $data['price'] + (0.25 * $data['price'])],
                        ['max_price', '>=', $data['price']]
                    ]);
            })
            ->when(!is_null($data['area']), function($query) use($data) {
                return $query->where('min_area', $data['area'])
                    ->orWhere('max_area', $data['area'])
                    ->orWhere([
                        ['min_area', '>=', $data['area'] - (0.25 * $data['area'])],
                        ['min_area', '<=', $data['area']]
                    ])
                    ->orWhere([
                        ['max_area', '<=', $data['area'] + (0.25 * $data['area'])],
                        ['max_area', '>=', $data['area']]
                    ]);
            })
            ->when(!is_null($data['construction_year']), function($query) use($data) {
                return $query->where('min_year_of_construction', $data['construction_year'])
                    ->orWhere('max_year_of_construction', $data['construction_year'])
                    ->orWhere([
                        ['min_year_of_construction', '>=', $data['construction_year'] - (0.25 * $data['construction_year'])],
                        ['min_year_of_construction', '<=', $data['construction_year']]
                    ])
                    ->orWhere([
                        ['max_year_of_construction', '<=', $data['construction_year'] + (0.25 * $data['construction_year'])],
                        ['max_year_of_construction', '>=', $data['construction_year']]
                    ]);
            })
            ->when(!is_null($data['rooms']), function($query) use($data) {
                return $query->where('min_rooms', $data['rooms'])
                    ->orWhere('max_rooms', $data['rooms'])
                    ->orWhere([
                        ['min_rooms', '>=', $data['rooms'] - (0.25 * $data['rooms'])],
                        ['min_rooms', '<=', $data['rooms']]
                    ])
                    ->orWhere([
                        ['max_rooms', '<=', $data['rooms'] + (0.25 * $data['rooms'])],
                        ['max_rooms', '>=', $data['rooms']]
                    ]);
            })
            ->when(!is_null($data['packing']), function($query) use($data) {
                return $query->where('packing', $data['packing']);
            })
            ->when(!is_null($data['heating_type']), function($query) use($data) {
                return $query->where('heating_type', $data['heating_type']);
            })
            ->get();
            
            $addScore = $search->map(function($item, $key) use($data) {
                $score = 0;
                $strictMatchesCount = 0;
                $looseMatchesCount = 0;

                if(!is_null($data['price'])) {
                    if($item->min_price == $data['price'] || $item->max_price == $data['price']) {
                        $score++;
                        $strictMatchesCount++;
                    } else if(
                        ($item->min_price >= ($data['price'] - (0.25 * $data['price'])) &&
                        $item->min_price < $data['price']) ||
                        ($item->max_price > $data['price'] && 
                        $item->max_price <= $data['price'] - (0.25 * $data['price']))
                    ) {
                        $score += 0.2;
                        $looseMatchesCount++;
                    }
                }
                
                if(!is_null($data['area'])) {
                    if($item->min_area == $data['area'] || $item->max_area == $data['area']) {
                        $score++;
                        $strictMatchesCount++;
                    } else if(
                        ($item->min_area >= ($data['area'] - (0.25 * $data['area'])) &&
                        $item->min_area < $data['area']) ||
                        ($item->max_area > $data['area'] && 
                        $item->max_area <= $data['area'] - (0.25 * $data['area']))
                    ) {
                        $score += 0.2;
                        $looseMatchesCount++;
                    }
                }
                
                if(!is_null($data['construction_year'])) {
                    if($data['construction_year'] >= $item->min_year_of_construction && $data['construction_year'] <= $item->max_year_of_construction) {
                        $score++;
                        $strictMatchesCount++;
                    }

                    if($item->min_year_of_construction == $data['construction_year'] || $item->max_year_of_construction == $data['construction_year']) {
                        $score++;
                        $strictMatchesCount++;
                    } else if(
                        ($item->min_year_of_construction >= ($data['construction_year'] - (0.25 * $data['construction_year'])) &&
                        $item->min_year_of_construction < $data['construction_year']) ||
                        ($item->max_year_of_construction > $data['construction_year'] && 
                        $item->max_year_of_construction <= $data['construction_year'] - (0.25 * $data['construction_year']))
                    ) {
                        $score += 0.2;
                        $looseMatchesCount++;
                    }
                }
                
                if(!is_null($data['rooms'])) {
                    if($item->min_rooms == $data['rooms'] || $item->max_rooms == $data['rooms']) {
                        $score++;
                        $strictMatchesCount++;
                    } else if(
                        ($item->min_rooms >= ($data['rooms'] - (0.25 * $data['rooms'])) &&
                        $item->min_rooms < $data['rooms']) ||
                        ($item->max_rooms > $data['rooms'] && 
                        $item->max_rooms <= $data['rooms'] - (0.25 * $data['rooms']))
                    ) {
                        $score += 0.2;
                        $looseMatchesCount++;
                    }
                }
                
                if(!is_null($data['packing'])) {
                    if($data['packing'] == $item->packing) {
                        $score++;
                    }
                }

                if(!is_null($data['heating_type'])) {
                    if($data['heating_type'] == $item->heating_type) {
                        $score++;
                    }
                }
                
                return [
                    'searchProfileId' => $item->id,
                    'score' => $score,
                    'strictMatchesCount' => $strictMatchesCount,
                    'looseMatchesCount' => $looseMatchesCount
                ];
            })->sortByDesc('score');
        
        if($addScore[0]['score'] == 0) return Response::json(
            ['message' => 'Search profile not found'], 404
        );

        return Response::json($addScore, 200);
    }
}
