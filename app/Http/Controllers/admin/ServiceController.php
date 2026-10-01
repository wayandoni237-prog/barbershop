<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {



        $request->validate([
            'nama_service' => 'required|string',
            'harga' => 'required|integer',
            'estimasi_menit' => 'required|integer',
        ]);

        Service::create([
            'nama_service' => $request->nama_service,
            'harga' => $request->harga,
            'estimasi_menit' => $request->estimasi_menit,
            'is_active' => 1
        ]);

        return redirect()->route('services.index')->with('toast', 'service_added')->with('success', 'Successfully added new service');
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('toast', 'service_add_error')->with('error', 'Failed to add a new service');
        }
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {


        $request->validate([
            'nama_service' => 'required|string',
            'harga' => 'required|integer',
            'estimasi_menit' => 'required|integer',
            'is_active' => 'required|integer',
        ]);

        $service = Service::findOrFail($id);

        $data = [
            'nama_service' => $request->nama_service,
            'harga' => $request->harga,
            'estimasi_menit' => $request->estimasi_menit,
            'is_active' => $request->is_active
        ];

        $service->update($data);

        return redirect()->route('services.index')->with('toast','service_edit')->with('success', 'Successfully edited service data');
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('toast','service_edit_error')->with('error', 'Failed to update data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {


        $service = Service::findOrFail($id);
        
        $service->update([
            'is_active' => 0,
        ]);

        return redirect()->route('services.index')->with('toast', 'service_inactive')->with('success','Successfully inactived service data');
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('toast', 'service_inactive_error')->with('error','Failed to inacvtived service');
        }
    }

    public function active($id)
    {
        try {


        $service = Service::findOrFail($id);

        $service->update([
            'is_active' => 1,
        ]);

        return redirect()->route('services.index')->with('toast', 'service_active')->with('success','successfully activated service data');
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('toast', 'service_active_error')->with('error','Failed to activated service');
        }
    }
}
