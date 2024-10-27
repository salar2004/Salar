<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
class OrderController extends Controller
{
    // دالة عرض جميع الطلبات
    public function index()
    {
        $orders = Order::all(); // جلب جميع الطلبات من قاعدة البيانات
        return view('orders.index', compact('orders')); // عرض صفحة قائمة الطلبات مع تمرير البيانات
    }

    // دالة عرض نموذج إضافة طلب جديد
    public function create()
    {
        return view('orders.create'); // عرض صفحة إنشاء طلب جديد
    }

    // دالة إضافة طلب جديد
    public function store(Request $request)
    {
        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->order_date = now(); // تاريخ الطلب هو الوقت الحالي
        $order->order_status = $request->order_status;
        $order->order_total = $request->order_total;
        $order->save();
        
        return redirect()->route('orders.index')->with('success', 'تم إضافة الطلب بنجاح');
    }

    // دالة عرض تفاصيل طلب معين
    public function show($id)
    {
        $order = Order::findOrFail($id); // جلب بيانات الطلب باستخدام المعرف
        return view('orders.show', compact('order')); // عرض صفحة تفاصيل الطلب
    }

    // دالة عرض نموذج تعديل طلب
    public function edit($id)
    {
        $order = Order::findOrFail($id); // جلب بيانات الطلب المراد تعديله
        return view('orders.edit', compact('order')); // عرض صفحة تعديل الطلب
    }

    // دالة تعديل طلب
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->order_total = $request->order_total;
        $order->save();
        
        return redirect()->route('orders.index')->with('success', 'تم تعديل الطلب بنجاح');
    }

    // دالة حذف طلب
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        return redirect()->route('orders.index')->with('success', 'تم حذف الطلب بنجاح');
    }

    // دالة بحث عن طلب معين
    public function search(Request $request)
    {
        $query = $request->input('query');
        $orders = Order::where('order_status', 'LIKE', "%{$query}%")
                        ->orWhere('order_total', 'LIKE', "%{$query}%")
                        ->get();
        
        return view('orders.index', compact('orders'));
    }
}
