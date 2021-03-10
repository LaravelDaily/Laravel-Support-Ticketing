<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePeminjamanRequest;
use App\Http\Requests\UpdatePeminjamanRequest;
use App\User;
use App\Peminjaman;
use App\Kunci;
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

        if($peminjaman->save()) {
            $kunci = new KunciController;
            $kunci->bikinKunci(Peminjaman::latest()->first()->id);
            return redirect()->route('admin.peminjaman.index')->with(['success' => 'Tambah Data Peminjaman '.$peminjaman->email.' berhasil!']);
        } else {
            return redirect()->route('admin.peminjaman.index')->with(['error' => 'Tambah Data Peminjaman Error']);
        }

        
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
    public function update(UpdatePeminjamanRequest $request, $id)
    {
        $idUser = Auth::user()->id;
        $peminjaman = Peminjaman::find($id);
        
        $peminjaman->nama = $request->nama;
        $peminjaman->email = $request->email;
        $peminjaman->barang_pinjam = $request->barang_pinjam;
        $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
        $peminjaman->tanggal_kembali = $request->tanggal_kembali;
        $peminjaman->user_id = $idUser;
        
        $peminjaman->save();

        // return redirect()->route('admin.peminjaman.index')->withStatus('Your ticket has been submitted, we will be in touch. You can view ticket status');
        return redirect()->route('admin.peminjaman.index')->with(['success' => 'Edit Data Peminjaman '.$peminjaman->email.' berhasil!']);
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
        $peminjaman = Peminjaman::findOrFail($id);

        if($peminjaman->delete()) {
            return redirect()->route('admin.peminjaman.index')->with(['success' => 'Hapus Data Peminjaman berhasil!']);
        } else {
            return redirect()->route('admin.peminjaman.index')->with(['error' => 'Hapus Data Peminjaman error!']);
        }
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
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        //DAN ENDOFMONTH UNTUK MENGAMBIL TANGGAL TERAKHIR DIBULAN YANG BERLAKU SAAT INI
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');

        //JIKA USER MELAKUKAN FILTER MANUAL, MAKA PARAMETER DATE AKAN TERISI
        if (request()->date != '') {
            //MAKA FORMATTING TANGGALNYA BERDASARKAN FILTER USER
            $date = explode(' - ' ,request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d');
            $end = Carbon::parse($date[1])->format('Y-m-d');
        }

        //BUAT QUERY KE DB MENGGUNAKAN WHEREBETWEEN DARI TANGGAL FILTER
        $peminjamans = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])->get();
        // dd($peminjamans[0]);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function pengembalian($id)
    {
        abort_if(Gate::denies('peminjaman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peminjaman = Peminjaman::findOrFail($id);
        // dd($validated);
        return view('admin.peminjaman.pengembalian', compact('peminjaman'));
    }

    public function pengembalianUpdate(Request $request, $id)
    {
        // dd($id);
        $peminjaman = Peminjaman::findOrFail($id);
        $kunci = Kunci::where('peminjaman_id', $id)->first();
        // dd($kunci->kunci);
        if($request->key == $kunci->kunci)
        {
            $peminjaman->tanggal_kembali = $request->tanggal_kembali;
            if($peminjaman->save())
            {
                //update kunci
                $updateKunci = Kunci::where('kunci', $request->key)->first();
                $updateKunci->status = 1;

                if($updateKunci->save())
                {
                    return redirect()->route('admin.peminjaman.index')->with(['success' => 'Pengembalian '.$peminjaman->email.' berhasil!']);
                }
            }
        } else {
            return redirect()->route('admin.peminjaman.index')->with(['error' => 'Pengembalian '.$peminjaman->email.' tidak berhasil. Kunci Salah!']);
        }
        dd($request->all());
    }
}
