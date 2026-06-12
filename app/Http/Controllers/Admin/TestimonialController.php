<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(TestimonialRequest $request)
    {
        $testimonial = Testimonial::create($request->validated());

        if ($request->hasFile('avatar')) {
            $testimonial->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم إضافة الرأي بنجاح.');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        $testimonial->update($request->validated());

        if ($request->hasFile('avatar')) {
            $testimonial->clearMediaCollection('avatar');
            $testimonial->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم تحديث الرأي بنجاح.');
    }

    public function toggleActive(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);

        return back()->with('success', $testimonial->is_active
            ? 'تم تفعيل الرأي.'
            : 'تم إخفاء الرأي.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم حذف الرأي.');
    }
}
