<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
   
    // دالة عرض جميع طرق الدفع
    public function index()
    {
        $paymentMethods = PaymentMethod::all(); // جلب جميع طرق الدفع من قاعدة البيانات
        return view('payment_methods.index', compact('paymentMethods')); // عرض صفحة طرق الدفع وتمرير البيانات
    }

    // دالة عرض صفحة إضافة طريقة دفع جديدة
    public function create()
    {
        return view('payment_methods.create'); // عرض صفحة إضافة طريقة دفع جديدة
    }

    // دالة تخزين طريقة دفع جديدة
    public function store(Request $request)
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->name = $request->name;
        $paymentMethod->details = $request->details;
        $paymentMethod->save();
        
        return redirect()->route('payment-methods.index')->with('success', 'تم إضافة طريقة الدفع بنجاح');
    }

    // دالة عرض تفاصيل طريقة دفع معينة
    public function show($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id); // جلب طريقة الدفع باستخدام المعرف
        return view('payment_methods.show', compact('paymentMethod')); // عرض صفحة تفاصيل طريقة الدفع
    }

    // دالة عرض صفحة تعديل طريقة الدفع
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id); // جلب طريقة الدفع التي نريد تعديلها
        return view('payment_methods.edit', compact('paymentMethod')); // عرض صفحة تعديل طريقة الدفع
    }

    // دالة تخزين التعديلات على طريقة دفع معينة
    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->name = $request->name;
        $paymentMethod->details = $request->details;
        $paymentMethod->save();
        
        return redirect()->route('payment-methods.index')->with('success', 'تم تعديل طريقة الدفع بنجاح');
    }

    // دالة حذف طريقة دفع
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();
        
        return redirect()->route('payment-methods.index')->with('success', 'تم حذف طريقة الدفع بنجاح');
    }

    // دالة البحث عن طرق الدفع بناءً على الاسم
    public function search(Request $request)
    {
        $query = $request->input('query');
        $paymentMethods = PaymentMethod::where('name', 'LIKE', "%{$query}%")->get(); // البحث حسب الاسم
        
        return view('payment_methods.index', compact('paymentMethods'));
    }
}
