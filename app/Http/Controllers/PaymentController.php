<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
   // دالة عرض جميع المدفوعات
   public function index()
   {
       $payments = Payment::all(); // جلب جميع المدفوعات من قاعدة البيانات
       return view('payments.index', compact('payments')); // عرض صفحة المدفوعات وتمرير البيانات
   }

   // دالة إضافة دفع جديد
   public function create()
   {
       return view('payments.create'); // عرض صفحة إضافة دفع جديد
   }

   // دالة تخزين دفع جديد
   public function store(Request $request)
   {
       $payment = new Payment();
       $payment->order_id = $request->order_id;
       $payment->payment_method_id = $request->payment_method_id;
       $payment->amount_paid = $request->amount_paid;
       $payment->payment_date = now();
       $payment->save();
       
       return redirect()->route('payments.index')->with('success', 'تم إضافة الدفع بنجاح');
   }

   // دالة عرض تفاصيل دفع معين
   public function show($id)
   {
       $payment = Payment::findOrFail($id); // جلب الدفع باستخدام المعرف
       return view('payments.show', compact('payment')); // عرض صفحة تفاصيل الدفع
   }

   // دالة تعديل دفع
   public function edit($id)
   {
       $payment = Payment::findOrFail($id); // جلب الدفع الذي نرغب بتعديله
       return view('payments.edit', compact('payment')); // عرض صفحة تعديل الدفع
   }

   // دالة تخزين التعديلات على دفع معين
   public function update(Request $request, $id)
   {
       $payment = Payment::findOrFail($id);
       $payment->amount_paid = $request->amount_paid;
       $payment->save();
       
       return redirect()->route('payments.index')->with('success', 'تم تعديل الدفع بنجاح');
   }

   // دالة حذف دفع
   public function destroy($id)
   {
       $payment = Payment::findOrFail($id);
       $payment->delete();
       
       return redirect()->route('payments.index')->with('success', 'تم حذف الدفع بنجاح');
   }

   // دالة البحث عن مدفوعات بناءً على معرف الطلب
   public function search(Request $request)
   {
       $query = $request->input('query');
       $payments = Payment::where('order_id', 'LIKE', "%{$query}%")->get(); // البحث حسب معرف الطلب
       
       return view('payments.index', compact('payments'));
   }
}
