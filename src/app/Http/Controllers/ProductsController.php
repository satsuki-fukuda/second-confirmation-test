<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->filled('keyword')) {
            $query->where('name', 'LIKE', '%' . $request->input('keyword') . '%');
        }
        if ($request->input('sort') === 'price_asc') {
            $query->orderBy('price', 'asc');
        }
        elseif ($request->input('sort') === 'price_desc') {
            $query->orderBy('price', 'desc');
        }
        $products = $query->paginate(6)->appends($request->query());
        return view('index', compact('products'));
    }

    public function create()
    {
        $seasons = Season::all();
        return view('register', compact('seasons'));
    }


    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();
        DB::transaction(function () use ($request) {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
            }
            $product = Product::create([
                'name'        => $request->name,
                'price'       => $request->price,
                'description' => $request->description,
                'image'       => $imagePath,
            ]);
            if ($request->has('seasons')) {
                $product->seasons()->sync($request->seasons);
            }
        });
        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    public function detail(Request $request,$productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();
        return view('detail', compact('product', 'seasons'));
    }

    public function update(RegisterRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);
        DB::transaction(function () use ($request, $product) {
            $data = [
                'name'        => $request->name,
                'price'       => $request->price,
                'description' => $request->description,
            ];
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('images', 'public');
            }
            $product->update($data);
            $product->seasons()->sync($request->seasons);
        });
        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();
        return redirect()->route('products.index')->with('success', '削除しました');
    }
}
