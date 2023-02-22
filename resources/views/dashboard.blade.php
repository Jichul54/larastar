@extends("layouts.app")
@section("content")
@vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
<div class="px-4 py-5 my-5 text-center bg-white">
    <h1 class="display-5 fw-bold">Centered hero</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <form action="{{ route('commute.store') }}" method="post">
                @csrf
                <select class="form-select mb-4" name="office_id">
                    @foreach($offices as $office)
                        @if($user->office_id == $office->id)
                        <option selected value="{{ $office->id }}">{!! $office->location !!}</option>
                        @else
                        <option value="{{ $office->id }}">{!! $office->location !!}</option>
                        @endif
                    @endforeach
                </select>
                @if ($user->working == false)
                <input type="submit" class="btn btn-primary btn-lg btn-block" name="arrival" value="出社">
                @else
                <input type="submit" class="btn btn-primary btn-lg btn-block" name="departure" value="退社">
                @endif
            </form>      
        </div>
    </div>
  </div>
@endsection
