<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePeminjamanRequest;
use App\User;
use App\Peminjaman;
use App\Http\Controllers\Admin\KunciController;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;


class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('peminjaman_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peminjamans = Peminjaman::all();

        return view('admin.peminjaman.index', compact('peminjamans'));
        // return "mamang";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        // return $tampung;
        return view ('admin.peminjaman.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePeminjamanRequest $request)
    {
        //
        $idUser = Auth::user()->id;

        // //validasi data
        $validated = $request->all();
        $idPeminjaman = Peminjaman::latest()->first()->id +1;
        // dd($lastId);
        $peminjaman = new Peminjaman;
        
        $peminjaman->nama = $request->name;
        $peminjaman->email = $request->email;
        $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
        $peminjaman->tanggal_kembali = $request->tanggal_kembali;
        
        $barang_pinjam = $request->barang_pinjam;
        $hasil = implode(';',$barang_pinjam);
        $peminjaman->barang_pinjam = $hasil;
        $peminjaman->user_id = $idUser;
        $peminjaman->save();
        
        $kunci = new KunciController;
        $kunci->bikinKunci($idPeminjaman);

        return redirect()->route('admin.peminjaman.index');
        // return "mamang";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        abort_if(Gate::denies('peminjaman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peminjaman = Peminjaman::findorFail($id);
        // dd($peminjaman);
        return view('admin.peminjaman.edit', compact('peminjaman'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload(Request $request)
    {
        if($request->hasFile('photo')) {
            
        }
    }

    public function rangeReport(Request $request)
    {
        //INISIASI 30 HARI RANGE SAAT INI JIKA HALAMAN PERTAMA KALI DI-LOAD
        //KITA GUNAKAN STARTOFMONTH UNTUK MENGAMBIL TANGGAL 1
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        //DAN ENDOFMONTH UNTUK MENGAMBIL TANGGAL TERAKHIR DIBULAN YANG BERLAKU SAAT INI
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        //JIKA USER MELAKUKAN FILTER MANUAL, MAKA PARAMETER DATE AKAN TERISI
        if (request()->date != '') {
            //MAKA FORMATTING TANGGALNYA BERDASARKAN FILTER USER
            $date = explode(' - ' ,request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }

        //BUAT QUERY KE DB MENGGUNAKAN WHEREBETWEEN DARI TANGGAL FILTER
        $peminjamans = Peminjaman::whereBetween('created_at', [$start, $end])->get();
        dd($peminjamans[0]);
    }
}
