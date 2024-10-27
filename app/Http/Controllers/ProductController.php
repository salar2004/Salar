<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produrct;

class ProductController extends Controller
{
     // دالة عرض جميع المنتجات
     public function index()
     {
         $products = Product::all(); // جلب جميع المنتجات من قاعدة البيانات
         return view('products.index', compact('products')); // عرض صفحة قائمة المنتجات مع تمرير البيانات
     }
 
     // دالة عرض نموذج إضافة منتج جديد
     public function create()
     {
         return view('products.create'); // عرض صفحة إنشاء منتج جديد
     }
 
     // دالة إضافة منتج جديد
     public function store(Request $request)
     {
         $product = new Product();
         $product->name = $request->name;
         $product->description = $request->description;
         $product->price = $request->price;
         $product->stock_quantity = $request->stock_quantity;
         $product->category_id = $request->category_id;
         $product->save();
         
         return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح');
     }
 
     // دالة عرض تفاصيل منتج معين
     public function show($id)
     {
         $product = Product::findOrFail($id); // جلب بيانات المنتج باستخدام المعرف
         return view('products.show', compact('product')); // عرض صفحة تفاصيل المنتج
     }
 
     // دالة عرض نموذج تعديل منتج
     public function edit($id)
     {
         $product = Product::findOrFail($id); // جلب بيانات المنتج المراد تعديله
         return view('products.edit', compact('product')); // عرض صفحة تعديل بيانات المنتج
     }
 
     // دالة تعديل منتج
     public function update(Request $request, $id)
     {
         $product = Product::findOrFail($id);
         $product->name = $request->name;
         $product->description = $request->description;
         $product->price = $request->price;
         $product->stock_quantity = $request->stock_quantity;
         $product->category_id = $request->category_id;
         $product->save();
         
         return redirect()->route('products.index')->with('success', 'تم تعديل المنتج بنجاح');
     }
 
     // دالة حذف منتج
     public function destroy($id)
     {
         $product = Product::findOrFail($id);
         $product->delete();
         
         return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');
     }
 
     // دالة بحث عن منتج معين
     public function search(Request $request)
     {
         $query = $request->input('query');
         $products = Product::where('name', 'LIKE', "%{$query}%")
                             ->orWhere('description', 'LIKE', "%{$query}%")
                             ->get();
         
         return view('products.index', compact('products'));
     }
}
