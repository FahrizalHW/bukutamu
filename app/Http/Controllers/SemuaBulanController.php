<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;
use Carbon\Carbon;
class SemuaBulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('dasboard.index', compact('data'));
    }

    public function index1()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont1', compact('data'));
    }
    public function index2()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont2', compact('data'));
    }
    public function index3()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont3', compact('data'));
    }
    public function index4()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont4', compact('data'));
    }
    public function index5()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont5', compact('data'));
    }
    public function index6()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont6', compact('data'));
    }
    public function index7()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont7', compact('data'));
    }
    public function index8()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont8', compact('data'));
    }
    public function index9()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont9', compact('data'));
    }
    public function index10()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont10', compact('data'));
    }
    public function index11()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont11', compact('data'));
    }
    public function index12()
    {
        // Retrieve all data for the initial view
        $data = Tamu::all();

        return view('table.mont12', compact('data'));
    }

    

    public function filterByMonth($month)
    {
        // Retrieve data filtered by month
        $filteredData = Tamu::whereMonth('created_at', $month)->get();

        return view('dasboard.filter', compact('filteredData'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tamu $tamu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tamu $tamu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, tamu $tamu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tamu $tamu)
    {
        //
    }
    public function filter(Request $request)
{
    $month = $request->month;
    $users = Tamu::whereMonth('created_at', $month)->paginate(10);
    // Your logic to filter the table based on the month parameter
}
}
