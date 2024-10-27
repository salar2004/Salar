<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingCard;

class CartController extends Controller
{
    // دالة عرض جميع سلال التسوق
    public function index()
    {
        $carts = ShoppingCart::all(); // جلب جميع سلال التسوق من قاعدة البيانات
        return view('carts.index', compact('carts')); // عرض صفحة قائمة سلال التسوق مع تمرير البيانات
    }

    // دالة عرض نموذج إضافة سلة تسوق جديدة
    public function create()
    {
        return view('carts.create'); // عرض صفحة إنشاء سلة تسوق جديدة
    }

    // دالة إضافة سلة تسوق جديدة
    public function store(Request $request)
    {
        $cart = new ShoppingCart(); // تأكد من أنك تستخدم الموديل الصحيح
        $cart->customer_id = $request->customer_id;
        $cart->creation_date = now();
        $cart->save();
        
        return redirect()->route('carts.index')->with('success', 'تم إضافة سلة التسوق بنجاح');
    }

    // دالة عرض تفاصيل سلة تسوق معينة
    public function show($id)
    {
        $cart = ShoppingCart::findOrFail($id); // جلب بيانات سلة التسوق باستخدام المعرف
        return view('carts.show', compact('cart')); // عرض صفحة تفاصيل سلة التسوق
    }

    // دالة عرض نموذج تعديل سلة تسوق
    public function edit($id)
    {
        $cart = ShoppingCart::findOrFail($id); // جلب بيانات سلة التسوق المراد تعديلها
        return view('carts.edit', compact('cart')); // عرض صفحة تعديل سلة التسوق
    }

    // دالة تعديل سلة تسوق
    public function update(Request $request, $id)
    {
        $cart = ShoppingCart::findOrFail($id);
        $cart->customer_id = $request->customer_id;
        $cart->save();
        
        return redirect()->route('carts.index')->with('success', 'تم تعديل سلة التسوق بنجاح');
    }

    // دالة حذف سلة تسوق
    public function destroy($id)
    {
        $cart = ShoppingCart::findOrFail($id);
        $cart->delete();
        
        return redirect()->route('carts.index')->with('success', 'تم حذف سلة التسوق بنجاح');
    }

    // دالة البحث عن سلال التسوق بناءً على معرف العميل
    public function search(Request $request)
    {
        $query = $request->input('query');
        $carts = ShoppingCart::where('customer_id', 'LIKE', "%{$query}%")->get(); // البحث في سلال التسوق حسب معرف العميل
        
        return view('carts.index', compact('carts'));
    }
}
