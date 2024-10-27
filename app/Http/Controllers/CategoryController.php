<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // دالة عرض جميع الفئات
    public function index()
    {
        $categories = Category::all(); // جلب جميع الفئات من قاعدة البيانات
        return view('categories.index', compact('categories')); // عرض صفحة قائمة الفئات مع تمرير البيانات
    }

    // دالة عرض نموذج إضافة فئة جديدة
    public function create()
    {
        return view('categories.create'); // عرض صفحة إنشاء فئة جديدة
    }

    // دالة إضافة فئة
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        
        return redirect()->route('categories.index')->with('success', 'تم إضافة الفئة بنجاح');
    }

    // دالة عرض تفاصيل فئة معينة
    public function show($id)
    {
        $category = Category::findOrFail($id); // جلب الفئة باستخدام المعرف
        return view('categories.show', compact('category')); // عرض صفحة تفاصيل الفئة
    }

    // دالة عرض نموذج تعديل فئة
    public function edit($id)
    {
        $category = Category::findOrFail($id); // جلب الفئة التي نرغب بتعديلها
        return view('categories.edit', compact('category')); // عرض صفحة تعديل الفئة
    }

    // دالة تعديل فئة
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        
        return redirect()->route('categories.index')->with('success', 'تم تعديل الفئة بنجاح');
    }

    // دالة حذف فئة
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return redirect()->route('categories.index')->with('success', 'تم حذف الفئة بنجاح');
    }

    // دالة البحث عن فئات بناءً على الاسم
    public function search(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::where('name', 'LIKE', "%{$query}%")->get(); // البحث حسب الاسم
        
        return view('categories.index', compact('categories'));
    }
}
