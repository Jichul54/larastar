@extends("layouts.app")
@section("content")
@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js',])
<div class="container">
    <form action="{{ route('commute.update', true) }}" method="post">
        @csrf
        @method('patch')
        <select class="form-select my-4" name="office_id">
            @foreach($offices as $office)
                @if($office_id == $office->id)
                <option selected value="{{ $office->id }}">{!! $office->location !!}</option>
                @else
                <option value="{{ $office->id }}">{!! $office->location !!}</option>
                @endif
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-4">
                <input type="datetime-local" class="form-control" name="start" placeholder="指定日開始（任意）">
            </div>
            <div class="col-md-4">
                <input type="datetime-local" class="form-control" name="end" placeholder="指定日終了（任意）">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">適用</button>
    </form> 
    <table class="table align-middle mb-0 bg-white mt-5">
        <thead class="bg-light">
            <tr>
            <th>Name</th>
            <th>Email</th>
            <th>出勤時刻</th>
            <th>退勤時刻</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commutes as $commute)
            <tr>
                <td>
                    <p class="fw-bold mb-1">{!! $commute->user->name !!}</p>
                </td>
                <td>
                    <p class="fw-normal mb-1">{!! $commute->user->email !!}</p>
                </td>
                <td>
                    <p class="fw-bold mb-1">{!! $commute->arrival !!}</p>
                </td>
                <td>
                    <p class="fw-bold mb-1">{!! $commute->departure !!}</p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>        
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("input[type=datetime-local]");
</script>
@endpush
@endsection