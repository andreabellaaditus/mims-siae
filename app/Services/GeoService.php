<?php

namespace App\Services;

class GeoService
{
    public function getCoordinatesFromAddress($address): array
    {
        $arr_coordinates = [];
        $result = app('geocoder')->geocode($address)->get();
        $coordinates = $result[0]->getCoordinates();

        $arr_coordinates[] = [
            'lat' => $coordinates->getLatitude(),
            'lng' => $coordinates->getLongitude(),
        ];

        return $arr_coordinates;
    }
}