<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use App\Models\{
    AreaType,
    HouseType,
    Region,
    Area,
    City,
    RegionType,
    Settlement,
    SettlementType,
    Street,
    House,
    StreetType};

class AdressController extends Controller
{
    public function save_adress(Request $request){
        //передаём введённые в форме данные
        $dadata = DaDataAddress::standardization($request['title']);
        //переменные, которые будут хранить результат метода firstOrCreate, для связывания таблиц
        $region = $area = $city = $settlement = $street = null;
        // проверка полученных данных от dadata
        /* метод firstOrCreate попытается найти в БД запись, соответствующую указанным атрибутам,
        если модель не найдена, будет возвращен новый экземпляр модели
        */
        if ($dadata[0]['region'] != null) {
            $region_type = RegionType::firstOrCreate([
                'region_type' => $dadata[0]['region_type'],
                'region_type_full' => $dadata[0]['region_type_full']
            ]);
            $region = Region::firstOrCreate([
                'region_name' => $dadata[0]['region'],
                'region_type_id' => $region_type['id']
            ]);
        }
        if ($dadata[0]['area'] != null) {
            $area_type = AreaType::firstOrCreate([
                'area_type' => $dadata[0]['area_type'],
                'area_type_full' => $dadata[0]['area_type_full']
            ]);
            $area = Area::firstOrCreate([
                'area_name' => $dadata[0]['area'],
                'area_type_id' => $area_type['id'],
                'region_id' => $region['id']
            ]);
        }
        if ($dadata[0]['city'] != null) {
            $city = City::where('city_name', $dadata[0]['city']);
            if($city->count() > 0){
                \Illuminate\Support\Facades\Session::flash('message', 'Данный город уже есть в базе');
            }
            $city = City::firstOrCreate([
                'city_name' => $dadata[0]['city'],
                'city_type' => $dadata[0]['city_type'],
                'city_type_full' => $dadata[0]['city_type_full'],
                'region_id' => $region['id'],
            ]);
            $city = City::find($city['id']);
            if ($area != null) {
                $city->area_id = $area['id'];
                $city->save();
            }
        }
        if ($dadata[0]['settlement'] != null) {
            $settlement = Settlement::where('settlement_name', $dadata[0]['settlement']);
            if($settlement->count() > 0){
                \Illuminate\Support\Facades\Session::flash('message', 'Данный н.п. уже есть в базе');
            }
            $settlement_type = SettlementType::firstOrCreate([
                'settlement_type' => $dadata[0]['settlement_type'],
                'settlement_type_full' => $dadata[0]['settlement_type_full']
            ]);
            $settlement = Settlement::firstOrCreate([
                'settlement_name' => $dadata[0]['settlement'],
                'settlement_type_id' => $settlement_type['id'],
                'region_id' => $region['id'],
            ]);
            $settlement = Settlement::find($settlement['id']);
            if ($city != null) {
                $settlement->city_id = $city['id'];
                $settlement->save();
            }
            if ($area != null) {
                $settlement->area_id = $area['id'];
                $settlement->save();
            }
        }
        if ($dadata[0]['street'] != null) {
            $street_type = StreetType::firstOrCreate([
                'street_type' => $dadata[0]['street_type'],
                'street_type_full' => $dadata[0]['street_type_full']
            ]);
            $street = Street::firstOrCreate([
                'street_name' => $dadata[0]['street'],
                'street_type_id' => $street_type['id'],
                'region_id' => $region['id']
            ]);
            $street = Street::find($street['id']);
            if ($city != null) {
                $street->city_id = $city['id'];
                $street->save();
            }
            if($settlement != null){
                $street->settlement_id = $settlement['id'];
                $street->save();
            }
        }
        if ($dadata[0]['house'] != null) {
            $house_type = HouseType::firstOrCreate([
                'house_type' => $dadata[0]['house_type'],
                'house_type_full' => $dadata[0]['house_type_full']
            ]);
            $house = House::firstOrCreate([
                'house_name' => $dadata[0]['house'],
                'house_type_id' => $house_type['id'],
                'house_fias_id' => $dadata[0]['house_fias_id'],
            ]);
            $house = House::find($house['id']);
            if ($street != null) {
                $house->street_id = $street['id'];
                $house->save();
            }
            \Illuminate\Support\Facades\Session::flash('message_ok', 'Адрес сохранён в базе');
        }

        return redirect()->back();
    }
}
