@extends(('layouts.app'))

@section('content')
    <h4>Все введённые адреса, группируя их по регионам и выводя в первом столбце
        название региона, а во втором — количество совпадений в базе. </h4>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Название региона</th>
            <th scope="col">Количество совпадений в базе</th>
        </tr>
        </thead>
        <tbody>
                @foreach($adress as $adres)
                    @if($adres->name != null)
                    <tr>
                        <td>{{$adres->name}}</td>
                        <td>{{$adres->count}}</td>
                    </tr>
                    @endif
                @endforeach
        </tbody>
    </table>

    <h4 class="mt-5">Название города/н.п. | кол-во адресов, где дом не имеет ФИАС. Пример:
        Самара | 16; Москва | 2; Саратов | 40</h4>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Название города/н.п.</th>
            <th scope="col">Кол-во адресов, где дом не имеет ФИАС</th>
        </tr>
        </thead>
        <tbody>
                @foreach($adress_not_fias as $adress)
                    @foreach($adress as $adres)
                        @if($adres->name != null)
                            <tr>
                                <td>{{$adres->name}}</td>
                                <td>{{$adres->count}}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
        </tbody>
    </table>
    <h4 class="mt-5"> Полные адреса до домов, которые были сохранены в БД в интервале с 20 по
        40 секунду (таймштампы). Пример:
        Самара, ул. Партизанская, 82а | 01.09.2021 17:32:29
        Сызрань, ул. Ленина 1 | 02.09.2021 09:00:40</h4>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Полные адреса</th>
            <th scope="col">Таймштампы с 20 по 40 секудну</th>
        </tr>
        </thead>
        <tbody>
        @foreach($adress_by_time as $adres)
            <div style="display: none;">
            {{$adr = null}}
            @if($adres->rn != null)
                {{$adr .= $adres->rn . ' ' . $adres->rt . ', '}}
            @endif
            @if($adres->an != null)
                {{$adr .= $adres->an . ' ' . $adres->art . ', '}}
            @endif
            @if($adres->cn != null)
                {{$adr .= $adres->ct . ' ' . $adres->cn . ', '}}
            @endif
            @if($adres->stn != null)
                {{$adr .= $adres->sty . ' ' . $adres->stn . ', '}}
            @endif
            @if($adres->sn != null)
                {{$adr .= $adres->st . ' ' . $adres->sn . ', '}}
            @endif
            {{$adr .= $adres->ht . ' ' . $adres->hn}}
            </div>
                <tr>
                    <td>{{$adr}}</td>
                    <td>{{$adres->htime}}</td>
                </tr>
        @endforeach
        </tbody>
    </table>
    <h4 class="mt-5"> Адреса, где сущность «улица» не является улицей: переулки, проезды,
        проспекты, тупики, шоссе и так далее. </h4>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Адреса, где сущность «улица» не является улицей</th>
        </tr>
        </thead>
        <tbody>
        @foreach($adress_not_street as $adres)
            <div style="display: none;">
                {{$adr = null}}
                @if($adres->rn != null)
                    {{$adr .= $adres->rn . ' ' . $adres->rt . ', '}}
                @endif
                @if($adres->c != null)
                    {{$adr .= $adres->ct . ' ' . $adres->c . ', '}}
                @endif
                @if($adres->sett != null)
                    {{$adr .= $adres->setty . ' ' . $adres->sett . ', '}}
                @endif
                @if($adres->str != null)
                    {{$adr .= $adres->strt . ' ' . $adres->str . ', '}}
                @endif
                {{$adr .= $adres->ht . ' ' . $adres->h}}
            </div>
            <tr>
                <td>{{$adr}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
