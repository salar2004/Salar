<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{

// دالة عرض جميع عناصر الطلب
public function index()
{
    $orderItems = OrderItem::all(); // جلب جميع عناصر الطلب من قاعدة البيانات
    return view('order_items.index', compact('orderItems')); // عرض صفحة قائمة عناصر الطلبات مع تمرير البيانات
}

// دالة عرض نموذج إضافة عنصر طلب جديد
public function create()
{
    return view('order_items.create'); // عرض صفحة إنشاء عنصر طلب جديد
}

// دالة إضافة عنصر طلب جديد
public function store(Request $request)
{
    $orderItem = new OrderItem();
    $orderItem->order_id = $request->order_id;
    $orderItem->product_id = $request->product_id;
    $orderItem->quantity = $request->quantity;
    $orderItem->price = $request->price;
    $orderItem->save();
    
    return redirect()->route('order-items.index')->with('success', 'تم إضافة عنصر الطلب بنجاح');
}

// دالة عرض تفاصيل عنصر طلب معين
public function show($id)
{
    $orderItem = OrderItem::findOrFail($id); // جلب بيانات عنصر الطلب باستخدام المعرف
    return view('order_items.show', compact('orderItem')); // عرض صفحة تفاصيل عنصر الطلب
}

// دالة عرض نموذج تعديل عنصر طلب
public function edit($id)
{
    $orderItem = OrderItem::findOrFail($id); // جلب بيانات عنصر الطلب المراد تعديله
    return view('order_items.edit', compact('orderItem')); // عرض صفحة تعديل عنصر الطلب
}

// دالة تعديل عنصر طلب
public function update(Request $request, $id)
{
    $orderItem = OrderItem::findOrFail($id);
    $orderItem->quantity = $request->quantity;
    $orderItem->price = $request->price;
    $orderItem->save();
    
    return redirect()->route('order-items.index')->with('success', 'تم تعديل عنصر الطلب بنجاح');
}

// دالة حذف عنصر طلب
public function destroy($id)
{
    $orderItem = OrderItem::findOrFail($id);
    $orderItem->delete();
    
    return redirect()->route('order-items.index')->with('success', 'تم حذف عنصر الطلب بنجاح');
}

// دالة البحث عن عناصر الطلب بناءً على المنتج أو الطلب
public function search(Request $request)
{
    $query = $request->input('query');
    $orderItems = OrderItem::where('product_id', 'LIKE', "%{$query}%")
                            ->orWhere('order_id', 'LIKE', "%{$query}%")
                            ->get();
    
    return view('order_items.index', compact('orderItems'));
}
   
}
