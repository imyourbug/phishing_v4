<?php

namespace App\Http\Livewire;

use App\Models\Label;
use App\Models\Language;
use Livewire\Component;

class Labels extends Component
{
    public $size = 10;
    public $search = '';
    public $lang = '';

    protected $queryString = ['search' => ['except' => ''], 'size', 'lang'];

    public function render()
    {
        $pageSizes = [
            10,
            20,
            30
        ];
        $positions = [
            'common' => 'Pages',
            'welcome' => 'Welcome',
            'confirm' => 'Confirm',
            'login' => 'Login',
            'identity_send' => 'Identity Send',
            'review_requested' => 'Review Requested',
            'complete' => 'Complete',
            'enter_mobile_number' => 'Enter Mobile Number',
            'enter_otp' => 'Enter Otp',
            'fa' => 'FA',
            'comment' => 'Comment',
            'avatar' => 'Avatar',
            'name' => 'Name',
            'introduce' => 'Introduce',
            'home' => 'Home',
            // 'home' => 'Home',
        ];
        $size = $this->size ?? 10;
        $search = $this->search ?? '';
        $lang = $this->lang ?? '-1';
        if (!in_array($size, $pageSizes)) {
            $size = 10;
        }
        $activeLanguages = Language::where('status', 1)->orderBy('name', 'ASC')->get();
        $currentLanguage = Language::where('code', $lang)->where('status', 1)->first();
        if (!$currentLanguage) {
            $currentLanguage = $activeLanguages->first();
        }

        $labels = $activeLanguages->isNotEmpty() ? Label::when($search !== '', function ($q) {
            return $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })->where('language_id', $currentLanguage->id)
            ->orderBy('position', 'DESC')
            ->paginate($size)
            ->withQueryString() : [];

        return view('livewire.labels', [
            'languages' => $activeLanguages,
            'currentLanguage' => $currentLanguage,
            'labels' => $labels,
            'positions' => $positions,
            'pageSizes' => $pageSizes
        ]);
    }

    public function changeLanguage($language)
    {
        $this->lang = $language['code'];
        return redirect()->intended('/labels');
    }
}
