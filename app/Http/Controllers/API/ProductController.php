<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
        {
                return Product::all();
        }

    public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'image' => 'required|image|max:2048'
                 ]);

     $path = $request->file('image')->store('products', 'public');

     $product = Product::create([
         'name' => $request->name,
        'quantity' => $request->quantity,
         'price' => $request->price,
         'image' => $path
         ]);

         return response()->json($product, 201);
        }

    public function show($id)
         {
         return Product::findOrFail($id);
      }
}
