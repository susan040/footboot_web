<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VendorController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Vendor';
        $this->resources = 'superadmin.vendors.';
        parent::__construct();
        $this->route = 'superadmin.vendors.';
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'vendor')->orderBy('id', 'DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($data) {
                    $imgUrl = $data->getImage() ? asset($data->getImage()) : asset('images/placeholder-image.jpg');
                    return '<a target="_blank" href="' . $imgUrl . '"><img style="height: 60%; width: 60%; object-fit: contain" src="' . $imgUrl . '" alt="logo"></a>';
                })
                ->editColumn('phone', function ($data) {
                    return $data->phone ?: '-';
                })
                ->editColumn('address', function ($data) {
                    return $data->address ?: '-';
                })
                ->addColumn('action', function ($data) {
                    return view('templates.index_actions', [
                        'id' => $data->id, 'route' => $this->route
                    ])->render();
                })
                ->rawColumns(['action', 'image', 'address', 'phone'])
                ->make(true);
        }

        $info = $this->crudInfo();
        return view($this->indexResource(), $info);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $info = $this->crudInfo();
        $info['routeName'] = "Create";

        return view($this->createResource(), $info);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'password' => 'required|min:8'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $vendor = new User($data);
        $vendor->save();

        if ($request->image) {
            $vendor->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()->route($this->indexRoute())->with('success', 'Vendor added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = $this->crudInfo();
        $info['item'] = User::findOrFail($id);

        return view($this->showResource(), $info);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = $this->crudInfo();
        $info['item'] = User::findOrFail($id);
        $info['routeName'] = 'Edit';

        return view($this->editResource(), $info);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:10000'
        ]);

        if ($request->password != null) {
            $data = $request->all();
        } else {
            $data = $request->except(['password']);
        }
        $vendor = User::findOrFail($id);
        $vendor->update($data);

        if ($request->image) {
            $vendor->clearMediaCollection();
            $vendor->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()->route($this->indexRoute())->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = User::findOrFail($id);
        $vendor->clearMediaCollection();
        $vendor->delete();

        return redirect()->route($this->indexRoute())->with('success', 'Vendor deleted successfully.');
    }
}
