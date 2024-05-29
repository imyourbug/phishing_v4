<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class Setting extends Component
{
    use WithFileUploads;

    public $bot_id;
    public $group_id;
    public $favicon_icon;
    public $banner_welcome;
    public $welcome_lock;
    public $path_welcome_page;
    public $path_login_page;
    public $path_confirm_page;

    public $redirect_url;

    public function mount()
    {
        $settings = Cache::rememberForever('settings', function () {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });
        $this->bot_id = $settings['bot_id'];
        $this->group_id = $settings['group_id'];
        $this->path_welcome_page = $settings['path_welcome_page'];
        $this->path_login_page = $settings['path_login_page'];
        $this->path_confirm_page = $settings['path_confirm_page'];
        $this->redirect_url = $settings['redirect_url'];
    }

    public function render()
    {
        $settings = Cache::rememberForever('settings', function () {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });
        $keyToLabels = [
            'banner_welcome' => 'Banner in Home page',
            'welcome_lock' => 'Lock image in Home page',
            'path_welcome_page' => 'Path of Welcome Page',
            'path_login_page' => 'Path of Login Page',
            'path_confirm_page' => 'Path of Confirm Page',
            'redirect_url' => 'Redirect Url',
            'bot_id' => 'Bot Id',
            'group_id' => 'Group Id (Group Telegram bot will send message)',
            'favicon_icon' => 'Favicon'
        ];
        return view('livewire.setting', [
            'settings' => $settings,
            'keyToLabels' => $keyToLabels
        ]);
    }

    public function getGroupId()
    {
        $this->resetErrorBag();
        $client = new Client();
        $response = $client->get("https://api.telegram.org/bot$this->bot_id/getUpdates");
        $response = $response->getBody();
        $response = json_decode($response, true);
        if (!$response || !$response['ok']) {
            $this->addError('error_bot_group_id', 'Unable to get bot information. Please check your Bot Id again');
            return false;
        }
        if (empty($response['result'])) {
            $this->addError('empty_result_group_id', 'You have not started the bot or have not added the bot to the group or have added the bot to the group for too long. Please start the bot and add the bot back to the group');
            return false;
        }
        $groupId = '';
        foreach ($response['result'] as $message) {
            if (!isset($message['message'])) {
                continue;
            }
            if (!isset($message['message']['chat'])) {
                continue;
            }
            $groupId = $message['message']['chat']['id'];
        }
        if ($groupId === '') {
            $this->addError('empty_result_group_id', 'You have not started the bot or have not added the bot to the group or have added the bot to the group for too long. Please start the bot and add the bot back to the group');
            return false;
        }
        $this->group_id = $groupId;
    }

    public function edit()
    {
        $this->validate([
            'path_welcome_page' => 'required|string',
            'path_login_page' => 'required|string',
            'path_confirm_page' => 'required|string',
            'redirect_url' => 'required|string',
            'bot_id' => 'nullable|string',
            'group_id' => 'nullable',
            'banner_welcome' => 'nullable|image|max:4096', // 4MB Max
            'welcome_lock' => 'nullable|image|max:4096', // 4MB Max
            'favicon_icon' => 'nullable|image|max:1024',
        ]);
        if ($this->banner_welcome) {
            $bannerUrl = $this->banner_welcome->storePublicly('photos');
            \App\Models\Setting::where('key', 'banner_welcome')->update([
                'value' => asset('/storage/' . $bannerUrl)
            ]);
        }
        if ($this->welcome_lock) {
            $welcomeUrl = $this->welcome_lock->storePublicly('photos');
            \App\Models\Setting::where('key', 'welcome_lock')->update([
                'value' => asset('/storage/' . $welcomeUrl)
            ]);
        }

        if ($this->bot_id) {
            \App\Models\Setting::where('key', 'bot_id')->update([
                'value' => $this->bot_id
            ]);
        }
        if ($this->group_id) {
            \App\Models\Setting::where('key', 'group_id')->update([
                'value' => $this->group_id
            ]);
        }
        if ($this->favicon_icon) {
            $faviconUrl = $this->favicon_icon->storePublicly('photos');
            \App\Models\Setting::where('key', 'favicon_icon')->update([
                'value' => asset('/storage/' . $faviconUrl)
            ]);
        }
        \App\Models\Setting::where('key', 'path_welcome_page')->update([
            'value' => $this->path_welcome_page
        ]);
        \App\Models\Setting::where('key', 'path_login_page')->update([
            'value' => $this->path_login_page
        ]);
        \App\Models\Setting::where('key', 'path_confirm_page')->update([
            'value' => $this->path_confirm_page
        ]);
        \App\Models\Setting::where('key', 'redirect_url')->update([
            'value' => $this->redirect_url
        ]);


        Cache::forget('settings');

        session()->flash('message', 'Labels successfully updated.');
        return redirect()->intended(route('settings'));
    }
}
