<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProductGalleryRequest;
use App\Models\ProductGallery;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProductGallery::with('products')->get();
        return ResponseJson::success($data, 'Data has been picked.');
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
    public function store(ProductGalleryRequest $request)
    {
        // $fileName = time() . "." . $request->file('photo')->extension();
        // $request->file('photo')->move(public_path('img/products'), $fileName);

        $file = $request->photo;
        
        if($file != null) {
            $name = time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            \Image::make($file)->save(public_path('img/products/') . $name);
            $request->merge(['photo' => $name]);

            $data = ProductGallery::create([
                'products_id' => $request->products_id,
                'photo' => $name,
                'is_default' => $request->is_default
            ]);
        }else{
            $data = ProductGallery::create([
                'products_id' => $request->products_id,
                'is_default' => $request->is_default
            ]);
        }

        return ResponseJson::success($data, 'Data has been created.');
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
    public function update(ProductGalleryRequest $request, $id)
    {
        $file = $request->photo;
        $productGallery = ProductGallery::find($id);
        $productGalleryPhoto = $productGallery->photo;
        $pathFileLama = public_path('img/products/') . $productGalleryPhoto;
        
        if($file != $productGalleryPhoto) {
            $name = time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            \Image::make($file)->save(public_path('img/products/') . $name);
            $request->merge(['photo' => $name]);

            if(file_exists($pathFileLama)) {
                unlink($pathFileLama);
            }

            $data = $productGallery->update([
                'products_id' => $request->products_id,
                'photo' => $name,
                'is_default' => $request->is_default
            ]);
        }else{
            $productGallery = ProductGallery::find($id);
            $data = $productGallery->update([
                'products_id' => $request->products_id,
                'is_default' => $request->is_default
            ]);
        }
        
        return ResponseJson::success($data, 'Data has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productGallery = ProductGallery::find($id);
        $data = $productGallery->delete();
        
        $fotoLama = $productGallery->photo;
        $path = public_path('img/products/') . $fotoLama;

        if(file_exists($path)) {
            unlink($path);
        }

        return ResponseJson::success($data, 'Data has been deleted.');
    }
}
