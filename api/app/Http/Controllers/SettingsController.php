<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    private $tracks;
    private $settingModel;

    public function __construct(Setting $settingModel)
    {
        $this->settingModel = $settingModel;
    }

    public function Get()
    {
        $user = Cache::get('user');
        $settings = $this->settingModel
            ->select('key', 'name', 'value')
            ->where('user_id', $user->id)
            ->orderby('id')
            ->get();
        return response()->json($settings);
    }

    public function Update(Request $request)
    {
        try {
            $user = Cache::get('user');
            $settings = $request->input('settings');
            foreach ($settings as $setting) {
                $settings = $this->settingModel
                    ->where('key', $setting['key'])
                    ->where('user_id', $user->id)
                    ->first();
                $settings->update([
                    'value' => $setting['value'],
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating settings'], 500);
        }
        return response()->json(['message' => 'Settings updated'], 200);
    }
}
