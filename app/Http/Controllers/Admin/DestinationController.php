<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestinationRequest;
use App\Models\Country;
use App\Models\Destination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::with('country')->orderBy('sort_order')->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        $countries = Country::orderBy('slug')->get();
        return view('admin.destinations.create', compact('countries'));
    }

    public function store(DestinationRequest $request)
    {
        $destination = Destination::create($request->validated());

        if ($request->hasFile('image')) {
            $destination->addMediaFromRequest('image')->toMediaCollection('image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $destination->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.destinations.index')
            ->with('success', __('admin.destination_created'));
    }

    public function edit(Destination $destination)
    {
        $countries = Country::orderBy('slug')->get();
        return view('admin.destinations.edit', compact('destination', 'countries'));
    }

    public function update(DestinationRequest $request, Destination $destination)
    {
        $destination->update($request->validated());

        if ($request->hasFile('image')) {
            $destination->clearMediaCollection('image');
            $destination->addMediaFromRequest('image')->toMediaCollection('image');
        }

        foreach ($request->input('gallery_delete', []) as $mediaId) {
            Media::find($mediaId)?->delete();
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $destination->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.destinations.index')
            ->with('success', __('admin.destination_updated'));
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();
        return redirect()->route('admin.destinations.index')
            ->with('success', __('admin.destination_deleted'));
    }
}
