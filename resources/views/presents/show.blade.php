@extends('layouts.app')

@section('title')
Detail User - {{ config('app.name') }}
@endsection

@section('content')

    <div class="container">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold float-left">Kehadiran</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Keterangan Masuk</th>
                                <th>Ip Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Keterangan Keluar</th>
                                <th>Ip Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$presents->count())
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data yang tersedia</td>
                                </tr>
                            @else
                                @foreach ($presents as $present)
                                    <tr>
                                        <td>{{ $present->user->name }}</td>
                                        <td>{{ $present->tanggal }}</td>
                                        @if ($present->jam_masuk)
                                            <td>{{ date('H:i:s', strtotime($present->jam_masuk)) }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>{{ $present->keterangan_masuk }}</td>
                                        <td>{{ $present->ip_masuk }}</td>
                                        @if($present->jam_keluar)
                                            <td>{{ date('H:i:s', strtotime($present->jam_keluar)) }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>{{ $present->keterangan_keluar }}</td>
                                        @if($present->ip_keluar)
                                            <td>{{ ($present->ip_keluar) }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    </tr>
                                @endforeach 
                            @endif
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $presents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection