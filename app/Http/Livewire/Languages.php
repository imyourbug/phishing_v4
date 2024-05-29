<?php

namespace App\Http\Livewire;

use App\Helpers\LabelHelper;
use App\Models\Label;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Languages extends Component
{
    public $size = 10;
    public $search = '';
    public $page = 1;

    protected $queryString = ['search' => ['except' => ''], 'size', 'page'];

    public function render()
    {
        $pageSizes = [
            10,
            20,
            30
        ];
        $size = $this->size ?? 10;
        $search = $this->search ?? '';
        if (!in_array($size, $pageSizes)) {
            $size = 10;
        }
        $languages = Language::when($search !== '', function ($q) {
            return $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('native_name', 'like', '%' . $this->search . '%');
        })
            ->orderBy('status', 'DESC')
            ->orderBy('name', 'ASC')
            ->paginate($size)
            ->withQueryString();
        return view('livewire.languages', [
            'languages' => $languages,
            'pageSizes' => $pageSizes
        ]);
    }

    public function changeStatus($language)
    {
        if ($language['has_labels']) {
            Language::where('id', $language['id'])->update([
                'status' => $language['status'] == 0 ? 1 : 0
            ]);
        } else {
            $path = public_path('/base-labels.json');
            $jsonString = file_get_contents($path);
            $labels = json_decode($jsonString, true);
            $now = Carbon::now();
            $labels = array_map(function ($label) use ($language, $now) {
                $label['language_id'] = $language['id'];
                $label['created_at'] = $now;
                $label['updated_at'] = $now;
                return $label;
            }, $labels);
            Label::insert($labels);
            Language::where('id', $language['id'])->update([
                'status' => $language['status'] == 0 ? 1 : 0,
                'has_labels' => 1
            ]);
            LabelHelper::generateLabelByLang($language['code']);
        }
        Cache::forget('active-languages');
        return redirect()->intended(route('languages', ['size' => $this->size, 'search' => $this->search, 'page' => $this->page]));
    }

    public function changeMirroring($language)
    {
        Language::where('id', $language['id'])->update([
            'is_rtl' => $language['is_rtl'] == 0 ? 1 : 0
        ]);
        return redirect()->intended(route('languages', ['size' => $this->size, 'search' => $this->search, 'page' => $this->page]));
    }
}
