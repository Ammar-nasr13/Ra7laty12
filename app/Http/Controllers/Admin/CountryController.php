<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('slug')->paginate(20);
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(CountryRequest $request)
    {
        Country::create($request->validated());

        return redirect()->route('admin.countries.index')
            ->with('success', __('admin.country_created'));
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(CountryRequest $request, Country $country)
    {
        $country->update($request->validated());

        return redirect()->route('admin.countries.index')
            ->with('success', __('admin.country_updated'));
    }

    public function destroy(Country $country)
    {
        if ($country->destinations()->exists()) {
            return back()->with('error', __('admin.country_has_destinations'));
        }

        $country->delete();

        return redirect()->route('admin.countries.index')
            ->with('success', __('admin.country_deleted'));
    }
}
