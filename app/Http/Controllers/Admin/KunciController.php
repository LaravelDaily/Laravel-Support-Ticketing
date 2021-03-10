<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kunci;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class KunciController extends Controller
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
        $kuncis = Kunci::with('peminjaman')->get();

        return view('admin.kunci.index', compact('kuncis'));
        // foreach ($users as $table2record) {
        //     // echo $table2record->id; //access table2 data
        //     echo $table2record->peminjaman->email; //access table1 data
        // }
        // dd($users);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function bikinKunci($idPeminjaman)
    {
        $kunci = new Kunci;
        $key = md5(uniqid(rand(), true));

        $kunci->kunci = $key;
        $kunci->peminjaman_id = $idPeminjaman;
        $kunci->save();
    }
}
