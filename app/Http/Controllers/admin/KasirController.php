<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kasir;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $kasirs = Kasir::with('user')->get();

        return view('admin.kasir.index', compact('kasirs'));
    }




    public function edit($id)
    {
        $kasir = Kasir::with('user')->findOrFail($id);

        return view('admin.kasir.edit', compact('kasir'));
    }

    //edit dan update data users
    public function update(Request $request, $id)
    {
        $kasir = Kasir::findOrFail($id);

        $data = [
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ];


        $kasir->update($data);

        return redirect()->route('kasir.index')->with('success', 'Cashier account successfully edited');
    }






public function destroy($id)
{
    $kasir = Kasir::findOrFail($id);

    $user = $kasir->user;

    $kasir->delete();

    if ($user) {
        $user->delete();
    }

    return redirect()->back();
}
}
