<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class ProdukController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $this->validate($request, [
            'kode_produk' => "required|unique:produk,kode_produk",
            "nama_produk" => "required",
            "harga" => "required|integer",
        ]);

        try {
            $hasil = Produk::create($validatedData);
    
            return $this->responHasil(201, true, $hasil);
        } catch (Exception $error) {
            return $this->responHasil(500, false, $error);
        }
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $rules =  [
            "nama_produk" => "required",
            "harga" => "required|integer",
        ];

        if(request("kode_produk") != $produk->kode_produk)
        {
            $rules["kode_produk"] = "required|unique:produk,kode_produk";
        }
        $validatedData = $this->validate($request, $rules);

        try {
            $hasil = $produk->update($validatedData);
            return $this->responHasil(200, true, $hasil);
        } catch (Exception $e) {
            return $this->responHasil(404, false, $e);
        }
    }

    public function get(Request $request)
    {
        if($request->has("pagination")) {
            $pagination = $request["pagination"];
        } else $pagination = 50;
        
        $data = Produk::orderBy("kode_produk", "Asc")->paginate((int)$pagination);

        return $this->responHasil(200, true, $data);
    }
    public function show($id)
    {
        $data = Produk::find($id);
        
        if(empty($data)){
            return $this->responHasil(404, false, "data tidak ditemukan");
        }
        return $this->responHasil(200, true, $data);
    }

    public function delete($id)
    {
        $produk = Produk::find($id);

        if(empty($produk)){
            return $this->responHasil(404, false, "produk tidak ditemukan");
        }
        
        $produk->delete();
        return $this->responHasil(202, true, "data berhasil dihapus");
    }
    
}
