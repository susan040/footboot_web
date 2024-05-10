<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Category';
        $this->resources = 'superadmin.categories.';
        parent::__construct();
        $this->route = 'superadmin.categories.';
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::orderBy('id', 'DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('templates.index_actions', [
                        'id' => $data->id, 'route' => $this->route
                    ])->render();
                })
                ->editColumn('image', function ($data) {
                    $imgUrl = $data->getImage() ? asset($data->getImage()) : asset('images/placeholder-image.jpg');
                    return '<a target="_blank" href="' . $imgUrl . '"><img style="height: 60%; width: 60%; object-fit: contain" src="' . $imgUrl . '" alt="logo"></a>';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        $info = $this->crudInfo();
        return view($this->indexResource(), $info);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->crudInfo();
        return view($this->createResource(), $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
        ]);

        $category = new Category([
            'name' => $request->name
        ]);
        $category->save();

        if ($request->image) {
            $category->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()->route($this->indexRoute())->with('success', 'Category added successfully!');
    }

    /**
     * Display the specified resource.
     * @param $id
     */
    public function show($id)
    {
        $data = $this->crudInfo();
        $data['item'] = Category::findorfail($id);
        return view($this->showResource(), $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        $data = $this->crudInfo();
        $data['item'] = Category::findorfail($id);
        return view($this->editResource(), $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     */
    public function update(Request $request, $id)
    {
        $category = Category::findorfail($id);
        $category->name = $request->name;
        $category->update();

        if ($request->image) {
            $category->clearMediaCollection();
            $category->addMediaFromRequest('image')->toMediaCollection();
        }


        return redirect()->route($this->indexRoute())->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     */
    public function destroy($id)
    {
        $category = Category::findorFail($id);
        $category->clearMediaCollection();
        $category->delete();
        return redirect()->route($this->indexRoute())->with('success', 'Category deleted successfully!');
    }
}
