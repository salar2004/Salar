<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartItemController extends Controller
{
  // دالة عرض جميع عناصر سلة التسوق
  public function index()
  {
      $cartItems = CartItem::all(); // جلب جميع العناصر من قاعدة البيانات
      return view('cart_items.index', compact('cartItems')); // عرض صفحة قائمة عناصر سلة التسوق مع تمرير البيانات
  }

  // دالة عرض نموذج إضافة عنصر جديد إلى سلة التسوق
  public function create()
  {
      return view('cart_items.create'); // عرض صفحة إنشاء عنصر جديد لسلة التسوق
  }

  // دالة إضافة عنصر إلى سلة التسوق
  public function store(Request $request)
  {
      $cartItem = new CartItem();
      $cartItem->cart_id = $request->cart_id;
      $cartItem->product_id = $request->product_id;
      $cartItem->quantity = $request->quantity;
      $cartItem->price = $request->price;
      $cartItem->save();
      
      return redirect()->route('cart-items.index')->with('success', 'تم إضافة العنصر بنجاح');
  }

  // دالة عرض تفاصيل عنصر معين في سلة التسوق
  public function show($id)
  {
      $cartItem = CartItem::findOrFail($id); // جلب العنصر باستخدام المعرف
      return view('cart_items.show', compact('cartItem')); // عرض صفحة تفاصيل العنصر
  }

  // دالة عرض نموذج تعديل عنصر في سلة التسوق
  public function edit($id)
  {
      $cartItem = CartItem::findOrFail($id); // جلب العنصر الذي نرغب بتعديله
      return view('cart_items.edit', compact('cartItem')); // عرض صفحة تعديل العنصر
  }

  // دالة تعديل عنصر في سلة التسوق
  public function update(Request $request, $id)
  {
      $cartItem = CartItem::findOrFail($id);
      $cartItem->quantity = $request->quantity;
      $cartItem->price = $request->price;
      $cartItem->save();
      
      return redirect()->route('cart-items.index')->with('success', 'تم تعديل العنصر بنجاح');
  }

  // دالة حذف عنصر من سلة التسوق
  public function destroy($id)
  {
      $cartItem = CartItem::findOrFail($id);
      $cartItem->delete();
      
      return redirect()->route('cart-items.index')->with('success', 'تم حذف العنصر بنجاح');
  }

  // دالة البحث عن عناصر سلة التسوق بناءً على المنتج أو سلة التسوق
  public function search(Request $request)
  {
      $query = $request->input('query');
      $cartItems = CartItem::where('product_id', 'LIKE', "%{$query}%")
                           ->orWhere('cart_id', 'LIKE', "%{$query}%")
                           ->get(); // البحث حسب معرف المنتج أو سلة التسوق
      
      return view('cart_items.index', compact('cartItems'));
  }
}
