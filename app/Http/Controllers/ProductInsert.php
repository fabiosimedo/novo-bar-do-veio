<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ProductInsert extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('components.admin-components.insert-products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $products = [
            'product_name' => request()->input('product_name'),
            'product_qtty' => request()->input('product_qtty'),
            'product_cost_price' => request()->input('product_cost_price'),
            'product_price' => request()->input('product_price')
        ];


        Product::create($products);

        return redirect('checkstorage')
                 ->with('cadastrado', 'Produto cadastrado com sucesso!');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('components.admin-components.product-detail', [
            'products' => $product->all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('products.edit', [
            'product' => Product::where('product_id', $id)->first()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_qtty' => 'required|integer|min:0',
            'product_cost_price' => 'required|numeric|min:0',
            'product_price' => 'required|numeric|min:0',
        ]);

        $product = Product::where('product_id', $id)->firstOrFail();

        $product->update($validated);

        return redirect()->route('checkstorage', ['product' => $product->product_id])
                        ->with('success', 'Produto atualizado com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $nomeProduto = $product->product_name;

        Product::where('product_id', $product->product_id)->delete();

        return redirect('/checkstorage')
            ->with('deleted', "Produto (<strong>{$nomeProduto}</strong>) deletado com sucesso!");
    }
}
