<?php

namespace App\Http\Services;

use \Illuminate\Database\Eloquent\Collection;

class PrepareScoreService
{
    /**
     * Calculate the score for each data
     * 
     * @param \Illuminate\Database\Eloquent\Collection $search
     * @param object $data
     * @return array
     */
    public function score(Collection $search, object $data)
    {
        return $search->map(function($item, $key) use($data) {
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
    }
}