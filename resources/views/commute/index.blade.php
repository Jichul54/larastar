@vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('出社表') }}
        </h2>
    </x-slot>

    <div class="container">
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
        
</x-app-layout>
