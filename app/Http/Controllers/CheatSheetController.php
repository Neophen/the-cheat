<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheatSheetRequest;
use App\Http\Requests\UpdateCheatSheetRequest;
use App\Models\CheatSheet;
use Inertia\Inertia;

class CheatSheetController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Inertia::render('CheatSheetsIndex', [
      'sheets' => CheatSheet::with('user')->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return Inertia::render('CheatSheetsCreate');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreCheatSheetRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreCheatSheetRequest $request)
  {
    $data = $request->validated();

    $sheet = CheatSheet::create([
      'title' => $data['title'],
      'description' => $data['description'],
      'user_id' => auth()->id(),
    ]);

    return redirect()->route('cheat-sheets.show', $sheet)->with('success', 'Cheat sheet created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\CheatSheet  $cheatSheet
   * @return \Illuminate\Http\Response
   */
  public function show(CheatSheet $cheatSheet)
  {
    return Inertia::render('CheatSheetsShow', [
      'sheet' => $cheatSheet,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\CheatSheet  $cheatSheet
   * @return \Illuminate\Http\Response
   */
  public function edit(CheatSheet $cheatSheet)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateCheatSheetRequest  $request
   * @param  \App\Models\CheatSheet  $cheatSheet
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateCheatSheetRequest $request, CheatSheet $cheatSheet)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\CheatSheet  $cheatSheet
   * @return \Illuminate\Http\Response
   */
  public function destroy(CheatSheet $cheatSheet)
  {
    //
  }
}
