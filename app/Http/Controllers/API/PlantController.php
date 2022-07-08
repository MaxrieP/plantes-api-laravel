<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plants = DB::table('plants')
            ->join('genuses', 'genuses.id', '=', 'plants.genusId')
            ->join('families', 'families.id', '=', 'plants.familyId')
            ->join('orders', 'orders.id', '=', 'plants.orderId')
            ->countries()
            ->get()
            ->toArray();

        $countries = DB::table('countries')
            ->join('plants', 'countries.plantId', '=', 'plants.id')
            ->select('countries.*', 'plants.plantName')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success',
            'data' => $plants,
            'data' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'plantName' => 'required|max:100',
            'plantHeight' => 'required|max:100',
            'plantPhoto' => 'required|max:100',
            'genusId' => 'required',
            'familyId' => 'required',
            'orderId' => 'required',
            'countryId' => 'required',
        ]);

        $fileName='';
        if($request->hasFile('plantPhoto')) {

            //Récupération nom du fichier, résultat : "photo.jpg"
            $filenameWithExt = $request->file('plantPhoto')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //Récupération extension du fichier, résultat : ".jpg"
            $extension = $request->file('photoplayer')->getClientOriginalExtension();

            //Création nv fichier avec nom+date+extension
            $fileName = $filenameWithoutExt . '_' . time() . '.' . $extension;

            //Enregistrement fichier à la racine /uploads
            $path = $request->file('plantPhoto')->storeAs('public/uploads', $fileName);

        }else{
            $fileName = null;
        }

        $plant = Plant::create([
            'plantName' => $request->plantName,
            'plantHeight' => $request->plantHeight,
            'plantPhoto' => $fileName,
            'genusId' => $request->genusId,
            'familyId' => $request->familyId,
            'orderId' => $request->orderId,
        ]);

        //Récupérer pays dans formulaire
        $countries = $request->countryId;
        for ($i=0; $i<count($countries); $i++)
        {
            $country = Country::find($countries[$i]);
            $plant->country()->attach($country);
        }

        return response()->json([
            'status' => 'Plante enregistrée',
            'data' => $plant
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show(Plant $plant)
    {
        return response()->json($plant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plant $plant)
    {
        $this->validate($request, [
            'plantName' => 'required|max:100',
            'plantHeight' => 'required|max:100',
            'genusId' => 'required',
            'familyId' => 'required',
            'orderId' => 'required',
            'countryId' => 'required',
        ]);

        $plant->update([
            'plantName' => $request->plantName,
            'plantHeight' => $request->plantHeight,
            'genusId' => $request->genusId,
            'familyId' => $request->familyId,
            'orderId' => $request->orderId,
            'countryId' => $request->countryId,
        ]);

        return response()->json([
            'status' => 'Plante modifiée',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plant $plant)
    {
        $plant->delete();

        return response()->json([
            'status' => 'Plante supprimée'
        ]);
    }
}
