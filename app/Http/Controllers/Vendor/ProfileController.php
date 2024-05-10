<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Profile';
        $this->resources = 'vendors.profile.';
        parent::__construct();
        $this->route = 'vendor.profile.';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->crudInfo();
        $data['hideCreate'] = true;
        $data['item'] = User::findOrFail(auth()->user()->id);
        return view($this->indexResource(), $data);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        $data = $this->crudInfo();
        $data['item'] = User::findOrFail($id);
        return view($this->editResource(), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => 'required | unique:users,email,' . auth()->id(),
            'profile_image' => 'mimes:jpeg,jpg,png|max:10000',

        ]);
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->phone = $request->input('phone_number');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->role = 'vendor';

        if ($request->image) {
            $user->clearMediaCollection();
            $user->addMediaFromRequest('image')->toMediaCollection();
        }

        $user->update();

        return redirect()->route($this->indexRoute())->with('success', 'Profile Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
