<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RuasJalanController extends Controller
{
    // show all ruas jalan created by the login user
    public function showRuasJalan()
    {
        $token = session('token');

        $response = Http::withToken($token)->get('https://gisapis.manpits.xyz/api/ruasjalan');

        if ($response->successful()) {
            $data = $response->json();

            return view('ruasjalan.master', ['ruasjalanData' => $data['ruasjalan']]);
        } else {
            return view('error');
        }
    }

    // show spesific map
    public function showMap($encodedPolyline)
    {
        return view('ruasjalan.map', ['encodedPolyline' => $encodedPolyline]);
    }

    // create new ruas jalan data
    public function create()
    {
        // region
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mregion');

        // eksisting
        $response2 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/meksisting');

        // kondisi
        $response3 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mkondisi');

        // jenis jalan
        $response4 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mjenisjalan');

        
        $data = $response->json();
        $data2 = $response2->json();
        $data3 = $response3->json();
        $data4 = $response4->json();

        return view('ruasjalan.create', [
            'provinsi' => $data['provinsi'],
            'kabupaten' => $data['kabupaten'],
            'kecamatan' => $data['kecamatan'],
            'desa' => $data['desa'],
            'eksisting' => $data2['eksisting'],
            'kondisi'=> $data3['eksisting'],
            'jenisjalan'=> $data4['eksisting'],
        ]);
    }

    // edit ruas jalan data
    public function edit(Request $request, $id)
    {
        $token = $request->session()->get('token');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get("https://gisapis.manpits.xyz/api/ruasjalan/{$id}");

        // region
        $response1 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mregion');

        // eksisting
        $response2 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/meksisting');

        // kondisi
        $response3 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mkondisi');

        // jenis jalan
        $response4 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mjenisjalan');

        
        $data1 = $response1->json();
        $data2 = $response2->json();
        $data3 = $response3->json();
        $data4 = $response4->json();

        if ($response->successful()) {
            $ruasDetail = $response->json();

            return view('ruasjalan.edit', [
                'ruasDetail' => $ruasDetail,
                'provinsi' => $data1['provinsi'],
                'kabupaten' => $data1['kabupaten'],
                'kecamatan' => $data1['kecamatan'],
                'desa' => $data1['desa'],
                'eksisting' => $data2['eksisting'],
                'kondisi'=> $data3['eksisting'],
                'jenisjalan'=> $data4['eksisting'],
            ]);
        } else {
            abort($response->status(), 'API request failed');
        }   
    }

    // update ruas jalan data
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validatedData = $request->validate([
            'paths' => 'required',
            'desa_id' => 'required',
            'nama_ruas' => 'required',
            'kode_ruas' => 'required',
            'panjang' => 'required',
            'lebar' => 'required|numeric',
            'eksisting_id' => 'required',
            'kondisi_id' => 'required',
            'jenisjalan_id' => 'required',
            'keterangan' => 'required',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->put("https://gisapis.manpits.xyz/api/ruasjalan/{$id}", $validatedData);

        if ($response->successful()) {
            return redirect()->route('ruasjalan.master')->with('success', 'Ruas Jalan created successfully.');
        } else {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->with('error', 'Failed to create Ruas Jalan.')->withErrors($errors)->withInput();
        }    
    }

    // simpan data
    public function store(Request $request)
    {
        //dd($request->all());
        $validatedData = $request->validate([
            'paths' => 'required',
            'desa_id' => 'required',
            'nama_ruas' => 'required',
            'kode_ruas' => 'required',
            'panjang' => 'required',
            'lebar' => 'required|numeric',
            'eksisting_id' => 'required',
            'kondisi_id' => 'required',
            'jenisjalan_id' => 'required',
            'keterangan' => 'required',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->post('https://gisapis.manpits.xyz/api/ruasjalan', $validatedData);

        if ($response->successful()) {
            return redirect()->route('ruasjalan.master')->with('success', 'Ruas Jalan created successfully.');
        } else {
            $errors = json_decode($response->body(), true)['errors'];
            return redirect()->back()->with('error', 'Failed to create Ruas Jalan.')->withErrors($errors)->withInput();
        }
    }

    // show spesific data
    public function showDetails(Request $request, $id)
    {
        $token = $request->session()->get('token');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get("https://gisapis.manpits.xyz/api/ruasjalan/{$id}");

        // region
        $response1 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mregion');

        // eksisting
        $response2 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/meksisting');

        // kondisi
        $response3 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mkondisi');

        // jenis jalan
        $response4 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mjenisjalan');
        
        $data1 = $response1->json();
        $data2 = $response2->json();
        $data3 = $response3->json();
        $data4 = $response4->json();

        if ($response->successful()) {
            $ruasDetail = $response->json();

            return view('ruasjalan.detail', [
                'ruasDetail' => $ruasDetail,
                'desa' => $data1['desa'],
                'eksisting' => $data2['eksisting'],
                'kondisi'=> $data3['eksisting'],
                'jenisjalan'=> $data4['eksisting'],
            ]);
        } else {
            abort($response->status(), 'API request failed');
        }
    }

    // delete data
    public function delete($id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->delete("https://gisapis.manpits.xyz/api/ruasjalan/{$id}");        

        if ($response->successful()) {
            return redirect('/master');
        } else {
            abort($response->status(), 'API request failed');
        }
    }

    // dashboard
    public function dashboard()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/ruasjalan');        

        // region
        $response1 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mregion');

        // eksisting
        $response2 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/meksisting');

        // kondisi
        $response3 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mkondisi');

        // jenis jalan
        $response4 = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
        ])->get('https://gisapis.manpits.xyz/api/mjenisjalan');

        
        $data1 = $response1->json();
        $data2 = $response2->json();
        $data3 = $response3->json();
        $data4 = $response4->json();

        if ($response->successful()) {
            $masterRuas = $response->json();
            //dd($masterRuas['ruasjalan']);

            return view('ruasjalan.dashboard', [
                'masterRuas' => $masterRuas['ruasjalan'],
                'desa' => $data1['desa'],
                'eksisting' => $data2['eksisting'],
                'kondisi'=> $data3['eksisting'],
                'jenisjalan'=> $data4['eksisting'],
            ]);
        } else {
            abort($response->status(), 'API request failed');
        }
    }
}
