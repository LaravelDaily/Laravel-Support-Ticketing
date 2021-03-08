<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePeminjamanRequest;
use App\User;
use App\Peminjaman;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
        // $validated = $request->all();

        // dd($validated);
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
}
