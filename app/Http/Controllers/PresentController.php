<?php

namespace App\Http\Controllers;

use App\Models\Present;
use App\Models\User;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class PresentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presents = Present::whereTanggal(date('Y-m-d'))->orderBy('jam_masuk')->paginate(6);
        return view('presents.index', compact('presents'));
    }

    public function checkIn(Request $request)
    {
        $users = User::all();
        $alpha = false;

        if (date('l') == 'Saturday' || date('l') == 'Sunday') {
            return redirect()->back()->with('error','Hari Libur Tidak bisa Check In');
        }

        foreach ($users as $user) {
            $absen = Present::whereUserId($user->id)->whereTanggal(date('Y-m-d'))->first();
            if (!$absen) {
                $alpha = true;
            }
        }

        if ($alpha) {
            foreach ($users as $user) {
                if ($user->id != $request->user_id) {
                    Present::create([
                        'keterangan_masuk'    => 'Alpha',
                        'keterangan_keluar'    => 'Alpha',
                        'tanggal'       => date('Y-m-d'),
                        'user_id'       => $user->id,
                    ]);
                }
            }
        }

        $present = Present::whereUserId($request->user_id)->whereTanggal(date('Y-m-d'))->first();
        if ($present) {
            if ($present->keterangan_masuk == 'Alpha') {
                $data['jam_masuk']  = date('H:i:s');
                $data['tanggal']    = date('Y-m-d');
                $data['user_id']    = $request->user_id;
                $data['ip_masuk'] = $request->ip();
                if (strtotime($data['jam_masuk']) <= strtotime('09:00:00') ) {
                    $data['keterangan_masuk'] = 'Masuk';
                } else if (strtotime($data['jam_masuk']) > strtotime('09:00:00') && strtotime($data['jam_masuk']) <= strtotime('17:00:00')) {
                    $data['keterangan_masuk'] = 'Terlambat';
                } else {
                    $data['keterangan_masuk'] = 'Alpha';
                }
                // $ip = $request->ip();
                // $data['ip_masuk'] = Location::get($ip);
                $present->update($data);
                return redirect()->back()->with('success','Check-in berhasil');
            } else {
                return redirect()->back()->with('error','Check-in gagal');
            }
        }

        $data['jam_masuk']  = date('H:i:s');
        $data['tanggal']    = date('Y-m-d');
        $data['user_id']    = $request->user_id;
        $data['ip_masuk'] = $request->ip();
        if (strtotime($data['jam_masuk']) <= strtotime('09:00:00') ) {
            $data['keterangan_masuk'] = 'Masuk';
        } else if (strtotime($data['jam_masuk']) > strtotime('09:00:00') && strtotime($data['jam_masuk']) <= strtotime('17:00:00')) {
            $data['keterangan_masuk'] = 'Terlambat';
        } else {
            $data['keterangan_masuk'] = 'Alpha';
        }
        // $ip = $request->ip();
        // $data['ip_masuk'] = Location::get($ip);
        
        Present::create($data);
        return redirect()->back()->with('success','Check-in berhasil');
    }

    public function checkOut(Request $request, Present $kehadiran)
    {
        if ($kehadiran) {
            if ($kehadiran->keterangan_keluar == 'Alpha') {
                $data['jam_keluar']  = date('H:i:s');
                $data['ip_keluar'] = $request->ip();
                if (strtotime($data['jam_keluar']) <= strtotime('17:00:00') ) {
                    $data['keterangan_keluar'] = 'Pulang Cepat';
                }else {
                    $data['keterangan_keluar'] = 'Lembur';
                }
                // $ip = $request->ip();
                // $data['ip_keluar'] = Location::get($ip);
                $kehadiran->update($data);
                return redirect()->back()->with('success','Check-out berhasil');
            } else {
                return redirect()->back()->with('error','Check-out gagal');
            }
        }
        
        return redirect()->back()->with('success', 'Check-out berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $presents = Present::whereUserId(auth()->user()->id)->whereMonth('tanggal',date('m'))->whereYear('tanggal',date('Y'))->orderBy('tanggal','desc')->paginate(6);
        return view('presents.show', compact('presents'));
    }

}
