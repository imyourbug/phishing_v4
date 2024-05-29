<?php

namespace App\Http\Livewire;

use App\Helpers\LabelHelper;
use App\Models\Label;
use App\Models\Language;
use Livewire\Component;

class EditLabel extends Component
{
    public $lang = '';
    public $activeLanguages = [];
    public $currentLanguage;

    public $data = [];

    public function mount($lang)
    {
        $this->lang = $lang;
        $this->activeLanguages = Language::where('status', 1)->orderBy('name', 'ASC')->get();
        if ($this->activeLanguages->isEmpty()) {
            return redirect()->intended('/labels');
        }
        $this->currentLanguage = Language::where('code', $lang)->where('status', 1)->first();
        if (!$this->currentLanguage) {
            $this->currentLanguage = $this->activeLanguages->first();
        }

        $labels = Label::where('language_id', $this->currentLanguage->id)
            ->orderBy('position', 'ASC')
            ->get();

        $data = [];
        foreach ($labels as $label) {
            $data[$label->position . '_' . $label->code] = $label->name;
        }
        $this->data = $data;
    }

    public function render()
    {
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
        ];
        $labels = Label::where('language_id', $this->currentLanguage->id)
            ->orderBy('position', 'ASC')
            ->get();

        $labels = $labels->groupBy('position');

        return view('livewire.edit-label', [
            'positions' => $positions,
            'languages' => $this->activeLanguages,
            'currentLanguage' => $this->currentLanguage,
            'labels' => $labels
        ]);
    }

    public function edit()
    {
        $labels = Label::where('language_id', $this->currentLanguage->id)
            ->orderBy('position', 'ASC')
            ->get();

        $update = [];
        foreach ($labels as $label) {
            $label->name = $this->data[$label->position . '_' . $label->code] ?? '';
            $label->save();
            $update[$label->position][$label->code] = $label->name;
        }
        LabelHelper::updateLabelByLang($this->currentLanguage->code, $update);
        session()->flash('message', 'Labels successfully updated.');
        return redirect()->intended(route('edit-label', ['lang' => $this->currentLanguage->code]));
    }
}
