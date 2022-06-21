@extends('layouts.apps')
 
@section('content')
    @if (date('l') == "Saturday" || date('l') == "Sunday") 
        <div class="text-center">
            <p>Absen Libur</p>
        </div>
    @else
        @if ($present)
            @if ($present->keterangan_masuk == 'Alpha')
                <div class="text-center">
                    @if (strtotime(date('H:i:s')) >= strtotime('07:00:00') && strtotime(date('H:i:s')) <= strtotime('17:00:00'))
                        <p>Silahkan Check-in</p>
                        <form action="{{ route('kehadiran.check-in') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <button class="btn btn-primary" type="submit">Check-in</button>
                        </form>
                    @else
                        <p>Check-in Belum Tersedia</p>
                    @endif
                </div>
            @else
                <div class="text-center">
                    <p>
                        Check-in hari ini pukul : ({{ ($present->jam_masuk) }})
                    </p>
                    @if ($present->jam_keluar)
                        <p>Check-out hari ini pukul : ({{ $present->jam_keluar }})</p>
                    @else
                        <p>Jika pekerjaan telah selesai silahkan check-out</p>
                        <form action="{{ route('kehadiran.check-out', ['kehadiran' => $present]) }}" method="post">
                            @csrf @method('patch')
                            <button class="btn btn-primary" type="submit">Check-out</button>
                        </form>
                    @endif
                </div>
            @endif
        @else
            <div class="text-center">
                @if (strtotime(date('H:i:s')) >= strtotime('07:00:00') && strtotime(date('H:i:s')) <= strtotime('17:00:00'))
                    <p>Silahkan Check-in</p>
                    <form action="{{ route('kehadiran.check-in') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <button class="btn btn-primary" type="submit">Check-in</button>
                    </form>
                @else
                    <p>Check-in Belum Tersedia</p>
                @endif
            </div>
        @endif
    @endif
@endsection