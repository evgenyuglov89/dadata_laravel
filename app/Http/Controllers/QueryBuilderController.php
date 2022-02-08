<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function query(){
        //запрос вернёт все адреса, группируя их по регионам и выводя в первом столбце
        //название региона, а во втором — количество совпадений в базе.
        $all_adress = DB::select('SELECT r.region_name name, COUNT(r.region_name) count
                                        FROM houses h
                                        LEFT JOIN streets st ON h.street_id = st.id
                                        LEFT JOIN cities cit ON st.city_id = cit.id
                                        LEFT JOIN settlements sett ON st.settlement_id = sett.id
                                        LEFT JOIN regions r ON cit.region_id = r.id OR sett.region_id = r.id OR st.region_id = r.id
                                        GROUP BY (r.region_name)');

        //запрос вернёт название регионов | кол-во адресов, где дом не имеет ФИАС( например: Москва, Санкт-Петербург)
        $adress_not_fias_region = DB::select('SELECT r.region_name name, Count(r.region_name) count
                                                    FROM houses h
                                                    LEFT JOIN streets str ON h.street_id = str.id
                                                    LEFT JOIN cities cit ON str.city_id = cit.id
                                                    LEFT JOIN settlements sett ON sett.id = str.settlement_id
                                                    LEFT JOIN regions r ON r.id = str.region_id
                                                    WHERE h.house_fias_id IS NULL AND cit.city_name IS NULL AND sett.settlement_name IS NULL
                                                    GROUP BY(r.region_name)');

        //запрос вернёт название городов | кол-во адресов, где дом не имеет ФИАС
        $adress_not_fias_city = DB::select('SELECT cit.city_name name, Count(cit.city_name) count
                                                  FROM houses h
                                                  LEFT JOIN streets str ON h.street_id = str.id
                                                  LEFT JOIN cities cit ON str.city_id = cit.id
                                                  LEFT JOIN settlements sett ON sett.id = str.settlement_id
                                                  LEFT JOIN regions r ON r.id = str.region_id
                                                  WHERE h.house_fias_id IS NULL AND sett.settlement_name IS NULL
                                                  GROUP BY(cit.city_name)');

        //запрос вернёт название н.п. | кол-во адресов, где дом не имеет ФИАС
        $adress_not_fias_settlement = DB::select('SELECT sett.settlement_name name, Count(sett.settlement_name) count
                                                        FROM houses h
                                                        LEFT JOIN streets str ON h.street_id = str.id
                                                        LEFT JOIN cities cit ON str.city_id = cit.id
                                                        LEFT JOIN settlements sett ON sett.id = str.settlement_id
                                                        LEFT JOIN regions r ON r.id = str.region_id
                                                        WHERE h.house_fias_id IS NULL
                                                        GROUP BY(sett.settlement_name)');

        //запрос вернёт полные адреса до домов, которые были сохранены в БД в интервале с 20 по 40 секунду
        $all_adress_by_time = DB::select('SELECT r.region_name rn, rt.region_type rt, a.area_name an, art.area_type art, cit.city_type ct, cit.city_name cn,
                                                sty.settlement_type sty, sett.settlement_name stn,strt.street_type st ,str.street_name sn,ht.house_type ht, h.house_name hn, h.created_at htime
                                                FROM houses h
                                                LEFT JOIN house_types ht ON ht.id = h.house_type_id LEFT JOIN streets str ON h.street_id = str.id
                                                LEFT JOIN street_types strt ON str.street_type_id = strt.id LEFT JOIN cities cit ON str.city_id = cit.id
                                                LEFT JOIN settlements sett on str.settlement_id = sett.id LEFT JOIN settlement_types sty ON sett.settlement_type_id = sty.id
                                                LEFT JOIN regions r ON cit.region_id = r.id OR sett.region_id = r.id OR str.region_id = r.id
                                                LEFT JOIN areas a ON a.id = sett.area_id OR a.id = cit.area_id LEFT JOIN area_types art ON art.id = a.area_type_id
                                                LEFT JOIN region_types rt ON rt.id = r.region_type_id
                                                WHERE EXTRACT( SECOND FROM h.created_at) BETWEEN 20 AND 40');

        // запрос вернёт адреса, где сущность «улица» не является улицей
        $adress_not_street = DB::select('SELECT r.region_name rn, rt.region_type rt, cit.city_type ct, cit.city_name c, setty.settlement_type setty,
                                                     sett.settlement_name sett, strt.street_type strt, str.street_name str, ht.house_type ht, h.house_name h
                                                FROM streets str
                                                LEFT JOIN street_types strt ON str.street_type_id = strt.id
                                                LEFT JOIN houses h ON h.street_id = str.id
                                                LEFT JOIN house_types ht ON h.house_type_id = ht.id
                                                LEFT JOIN settlements sett ON str.settlement_id = sett.id
                                                LEFT JOIN settlement_types setty ON sett.settlement_type_id = setty.id
                                                LEFT JOIN cities cit ON str.city_id = cit.id
                                                LEFT JOIN regions r ON cit.region_id = r.id OR sett.region_id = r.id OR str.region_id = r.id
                                                LEFT JOIN region_types rt ON r.region_type_id = rt.id
                                                WHERE str.street_type_id != (SELECT st.id FROM street_types st WHERE st.street_type_full = "улица")');

        // передаём полученные данные в view для вывода на странице /query_results
        return view('query_results',[
            'adress' => $all_adress,
            'adress_not_fias'=> [
                'adress_not_fias_region' => $adress_not_fias_region,
                'adress_not_fias_city' => $adress_not_fias_city,
                'adress_not_fias_settlement' => $adress_not_fias_settlement],
            'adress_by_time' => $all_adress_by_time,
            'adress_not_street' => $adress_not_street
        ]);
    }
}
