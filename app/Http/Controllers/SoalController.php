<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSoalRequest;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $soals = DB::table('soals')
            ->when($request->input('pertanyaan'), function ($query, $pertanyaan) {
                return $query->where('pertanyaan', 'like', '%' . $pertanyaan . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.soals.index', compact('soals'));
    }

    public function create()
    {
        return view('pages.soals.create');
    }

    public function store(StoreSoalRequest $request)
    {
        $data = $request->all();
        Soal::create($data);
        return redirect()->route('soal.index')->with('success', 'Soal successfully created');
    }


}
