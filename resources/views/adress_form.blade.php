@extends(('layouts.app'))

@section('content')
<form class="mb-4" action="/save_adress" method="post">
    @csrf
    <div class="mb-3 form-group">
        @if(Session::has('message'))
            <h3>{{Session::get('message')}}</h3>
        @endif
        <label for="title">Введите ваш адрес</label>
        <input type="text" name="title" id="title" class="form-control">
    </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    @if(Session::has('message_ok'))
        <h3>{{Session::get('message_ok')}}</h3>
    @endif
</form>

    <a href="/query_results" class="alert alert-success " role="alert">
        Результаты запросов
    </a>

@endsection
