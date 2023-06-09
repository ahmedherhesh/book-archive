<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends MasterController
{
    public function index(Request $request)
    {
        $items = Item::query();

        // filter by:
        //terms
        if ($request->q)
            $items->where('title', 'LIKE', '%' . $request->q . '%')->orWhere('description', 'LIKE', '%' . $request->q . '%');
        //category
        if ($request->cat_id)
            $items->whereCatId($request->cat_id);
        //between date and date
        if ($request->from && $request->to)
            $items->whereBetween('date', [$request->from, $request->to]);
        //from date
        else if ($request->from && !$request->to)
            $items->whereDate('date', '>=',  $request->from);
        //to date
        else if (!$request->from && $request->to)
            $items->whereDate('date', '<=',  $request->to);
        //return date desc
        $items = $items->latest()->paginate(18);
        return view('items.items', ['items' => $items]);
    }


    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $data = $request->all();
        $user = session()->get('user');
        $data['user_id'] = $user->id;
        $item = Item::create($data);
        if ($item)
            return redirect()->back()->with('success', 'تم إضافة الكتاب بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getItem($id)
    {
        $user = session()->get('user');
        $item = Item::whereId($id);
        if ($user->role == 'admin')
            $item = $item->first();
        else
            $item = $item->whereUserId($user->id)->first();
        return $item ? $item : '';
    }
    public function edit(string $id)
    {
        $item = $this->getItem($id);
        if (!$item) return redirect()->back();
        return view('items.edit', ['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemUpdateRequest $request)
    {
        $item = $this->getItem($request->item_id);
        $item->update($request->all());
        if (!$item) return redirect()->back();
        return redirect()->back()->with('success', 'تم تحديث الكتاب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->getItem($id);
        if ($item) {
            $item_delete = $item->delete();
            if ($item_delete)
                return redirect()->back()->with('success', 'تم حذف الكتاب بنجاح');
        }
        return redirect()->back();
    }
}
