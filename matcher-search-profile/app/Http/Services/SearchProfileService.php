<?php

namespace App\Http\Services;

use App\Models\SearchProfile;

class SearchProfileService
{
    /**
     * Search the database for matched searches
     *
     * @param object $data
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function find(object $data)
    {
        return SearchProfile::query()
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
    }
}