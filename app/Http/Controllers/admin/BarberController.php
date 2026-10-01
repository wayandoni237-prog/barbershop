<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barbers = Barber::all();

        return view('admin.barbers.index', compact('barbers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.barbers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {



        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required',
            'alamat' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        if($request->hasFile('image')) {
            $image = $request->file('image')->store('barbers', 'public');
        } else {
            $image = null;
        }

        Barber::create([
            'nama' =>$request->nama,
            'no_hp' =>$request->no_hp,
            'alamat' =>$request->alamat,
            'image' => $image
        ]);

        return redirect()->route('barbers.index')->with('toast', 'barber_added')->with('success', 'Successfully added a new barber');
        } catch (\Exception $e) {
            return redirect()->route('barbers.index')->with('toast', 'barber_add_error')->with('error', 'Failed to add a new barber');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barber = Barber::findOrFail($id);

        return view('admin.barbers.edit', compact('barber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {


        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required',
            'alamat' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        $barber = Barber::findOrFail($id);

        $data = [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ];

        if($request->hasFile('image')) {
        if($barber->image) {
            Storage::disk('public')->delete($barber->image);
        }

        $data['image'] = $request->file('image')->store('barbers', 'public');

        }
        $barber->update($data);
        

        return redirect()->route('barbers.index')->with('toast', 'barber_edit')->with('success', 'Successfully edited barber data');
        } catch (\Exception $e) {
            return redirect()->route('barbers.index')->with('toast', 'barber_edit_error')->with('error', 'Failed to edit barber data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {


        $barber = Barber::findOrFail($id);

        $barber->delete();
        return redirect()->route('barbers.index')->with('toast', 'barber_delete')->with('success','Successfully deleted barber data');
        } catch(\Exception $e) {
            return redirect()->route('barbers.index')->with('toast', 'barber_delete_error')->with('error','Failed to delete barber data');
        }
    }
}
