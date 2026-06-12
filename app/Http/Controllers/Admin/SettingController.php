<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(UpdateSettingsRequest $request)
    {
        foreach ($request->validated()['settings'] as $key => $value) {
            Setting::where('key', '=', $key)->update(['value' => $value]);
        }

        Cache::forget('site_settings');

        return back()->with('success', 'تم حفظ الإعدادات بنجاح.');
    }
}
