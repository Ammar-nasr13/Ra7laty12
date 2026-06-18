<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripRequest;
use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereRaw("search", ["%$search%"]);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $trips = $query->orderBy('sort_order')->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        $destinations = Destination::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.trips.create', compact('destinations'));
    }

    public function store(TripRequest $request)
    {
        $validated = $request->validated();
        $validated['currency'] = '$';
        $validated['highlight_images'] = $this->storeHighlightImages($request);

        $trip = Trip::create($validated);

        if ($request->hasFile('image')) {
            $trip->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file) {
                    $trip->addMedia($file)
                        ->toMediaCollection('gallery');
                }
            }
        }

        return redirect()->route('admin.trips.index')
            ->with('success', 'تم إضافة الرحلة بنجاح.');
    }

    public function edit(Trip $trip)
    {
        $destinations = Destination::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.trips.edit', compact('trip', 'destinations'));
    }

    public function update(TripRequest $request, Trip $trip)
    {
        $validated = $request->validated();
        $validated['currency'] = $trip->currency ?: '$';

        $existing = $trip->highlight_images ?? [];
        $validated['highlight_images'] = $this->storeHighlightImages($request, $existing);

        $trip->update($validated);

        if ($request->hasFile('image')) {
            $trip->clearMediaCollection('image');
            $trip->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        if ($request->has('gallery_delete')) {
            foreach ($request->input('gallery_delete', []) as $mediaId) {
                $media = Media::find($mediaId);
                if ($media) {
                    $media->delete();
                }
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file) {
                    $trip->addMedia($file)
                        ->toMediaCollection('gallery');
                }
            }
        }

        return redirect()->route('admin.trips.index')
            ->with('success', 'تم تحديث الرحلة بنجاح.');
    }

    public function destroy(Trip $trip)
    {
        if ($trip->bookings()->exists()) {
            return back()->with('error', 'لا يمكن حذف رحلة لها حجوزات مرتبطة.');
        }

        $trip->delete();

        return redirect()->route('admin.trips.index')
            ->with('success', 'تم حذف الرحلة.');
    }

    public function toggleActive(Trip $trip)
    {
        $trip->update(['is_active' => !$trip->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $trip->is_active,
        ]);
    }

    private function storeHighlightImages(TripRequest $request, array $existing = []): array
    {
        $images = $existing;
        if ($request->hasFile('highlight_images')) {
            foreach ($request->file('highlight_images') as $idx => $file) {
                if ($file) {
                    $images[$idx] = $file->store('highlights', 'public');
                }
            }
        }
        return $images;
    }
}
