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
            <th></th>
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
                @if ($user_id == $commute->user_id)
                <td>
                    <form action="{{ route('commute.destroy',$commute->id) }}" method="POST" class="text-left">
                      @method('delete')
                      @csrf
                      <button type="submit" class="mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-white py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="black">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </form>
                </td>
                @else
                @endif
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