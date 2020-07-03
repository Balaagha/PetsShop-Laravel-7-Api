<?php

namespace App\Http\Controllers\Api;

use App\Adres;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdresController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->apiResponse(ResultType::Success,Adres::All(),'Categories Fetched1',200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $adress = new Adres();
        $adress->adress_title  = $request->adress_title;
        $adress->adress_info  = $request->adress_info;
        $adress->user_id  = $request->user_id;
        $adress->save();
        return $this->apiResponse(ResultType::Success,$adress,'Child Category Created.',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Adres  $adres
     * @return \Illuminate\Http\Response
     */
    public function show(Adres $adres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Adres  $adres
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Adres $adres)
    {
        $adres->adress_title  = $request->adress_title;
        $adres->adress_info  = $request->adress_info;
        $adres->user_id  = $request->user_id;
        $adres->save();
        return $this->apiResponse(ResultType::Success,$adres,'Child Category update.',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Adres  $adres
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $adres = Adres::find($id);
        $adres->delete();
        return $this->apiResponse(ResultType::Success,$adres, 'Category deleted',200);

    }
}
