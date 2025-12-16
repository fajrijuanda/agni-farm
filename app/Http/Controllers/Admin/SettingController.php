<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        // Get all settings as key-value array
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'site_logo', 'site_favicon']);

        // Handle text inputs
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        // Handle Logo Upload
        if ($request->hasFile('site_logo')) {
            $request->validate(['site_logo' => 'image|max:2048']);

            // Delete old logo if exists
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::set('site_logo', $path);
        }

        // Handle Favicon Upload
        if ($request->hasFile('site_favicon')) {
            $request->validate(['site_favicon' => 'image|max:1024']);

            // Delete old favicon
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon) {
                Storage::disk('public')->delete($oldFavicon);
            }

            $path = $request->file('site_favicon')->store('settings', 'public');
            Setting::set('site_favicon', $path);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
