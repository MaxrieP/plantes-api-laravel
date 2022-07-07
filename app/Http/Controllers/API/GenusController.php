<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Genus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genuses = DB::table('genuses')
            ->join('families', 'families.id', '=', 'genuses.familyId')
            ->join('orders', 'orders.id', '=', 'genuses.orderId')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success',
            'data' => $genuses
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
            'genusName' => 'required|max:100',
            'familyId' => 'required',
            'orderId' => 'required'
        ]);

        $genus = Genus::create([
            'genusName' => $request->genusName,
            'familyId' => $request->familyId,
            'orderId' => $request->orderId
        ]);

        return response()->json([
            'status' => 'Genre ajouté',
            'data' => $genus
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genus  $genus
     * @return \Illuminate\Http\Response
     */
    public function show(Genus $genus)
    {
        return response()->json($genus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genus  $genus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genus $genus)
    {
        $this->validate($request, [
            'genusName' => 'required|max:100',
            'familyId' => 'required',
            'orderId' => 'required'
        ]);

        $genus->update([
            'genusName' => $request->genusName,
            'familyId' => $request->familyId,
            'orderId' => $request->orderId
        ]);

        return response()->json([
            'status' => 'Genre modifié'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genus  $genus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genus $genus)
    {
        $genus->delete();

        return response()->json([
            'status' => 'Genre supprimé'
        ]);
    }
}
