<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Venue';
        $this->resources = 'vendors.venues.';
        parent::__construct();
        $this->route = 'vendor.venues.';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->crudInfo();

        $data['venues'] = Venue::where('vendor_id', auth()->user()->id)->get();

        return view($this->indexResource(), $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $info = $this->crudInfo();
        $info['routeName'] = "Create";

        return view($this->createResource(), $info);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();
        $data['vendor_id'] = auth()->user()->id;
        $venue = new Venue($data);
        $venue->save();

        if ($request->image) {
            $venue->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()->route($this->indexRoute())->with('success', 'Venue added successfully.');

    }

    /**
     * Display the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        $info = $this->crudInfo();
        $info['item'] = Venue::findOrFail($id);

        return view($this->showResource(), $info);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        $info = $this->crudInfo();
        $info['item'] = Venue::findOrFail($id);
        $info['routeName'] = 'Edit';

        return view($this->editResource(), $info);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $venue = Venue::findOrFail($id);
        $data = $request->all();
        $venue->update($data);

        if ($request->image) {
            $venue->clearMediaCollection();
            $venue->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()->route($this->indexRoute())->with('success', 'Venue updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->clearMediaCollection();
        $venue->delete();

        return redirect()->route($this->indexRoute())->with('success', 'Venue deleted successfully.');

    }
}
