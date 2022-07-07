<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $families = DB::table('families')
            ->join('orders', 'orders.id', '=', 'families.orderId')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success',
            'data' => $families
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
            'familyName' => 'required|max:100',
            'orderId' => 'required'
        ]);

        $family = Family::create([
            'familyName' => $request->familyName,
            'orderId' => $request->orderId
        ]);

        return response()->json([
            'status' => 'Famille ajouté',
            'data' => $family
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function show(Family $family)
    {
        return response()->json($family);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Family $family)
    {
        $this->validate($request, [
            'familyName' => 'required|max:100',
            'orderId' => 'required'
        ]);

        $family->update([
            'familyName' => $request->familyName,
            'orderId' => $request->orderId
        ]);

        return response()->json([
            'status' => 'Famille modifiée'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family)
    {
        $family->delete();

        return response()->json([
            'status' => 'Famille supprimée'
        ]);
    }
}
