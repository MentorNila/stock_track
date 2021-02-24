<?php namespace App\Modules\Filing\Logic;

use App\Modules\Filing\Models\FilingTag;
use Illuminate\Support\Facades\Log;

class Tags {
    protected const labelTypes = [
        "terseLabel"    =>  "Terse Label",
        "verboseLabel"  =>  "Verbose Label",
        "negatedLabel"  =>  "Negated Label",
        "positiveLabel" =>  "Positive Label",
        "positiveTerseLabel"    =>  "Positive Terse Label",
        "positiveVerboseLabel"  =>  "positive Verbose Label",
        "negativeLabel" =>  "Negative Label",
        "negativeTerseLabel"    =>  "Negative Terse Label",
        "negativeVerboseLabel"  =>  "Negative Verbose Label",
        "zeroLabel" =>  "Zero Label",
        "zeroTerseLabel"    =>  "Zero Terse Label",
        "zeroVerboseLabel"  =>  "Zero Verbose Label",
        "totalLabel"    =>  "Total Label",
        "negatedTotalLabel" =>  "Negated Total Label",
        "periodStartLabel"  =>  "Period Start Label",
        "negatedPeriodStartLabel"   =>  "Negated Period Start Label",
        "periodEndLabel"    =>  "Period End Label",
        "negatedPeriodEndLabel" =>  "Negated Period End Label",
    ];

    private $filingId;
    private $tagId;
    private $attributes;

    public function __construct($filingId = null, $tagId = null, $attributes = null) {
        $this->attributes = $attributes;
        $this->filingId = $filingId;
        $this->tagId = $tagId;
    }

    public function storeFilingTags(){
        $filingTags = new FilingTag();
        try {
            if (isset($this->tagId) && !is_null($this->tagId)) {
                $filingTags = FilingTag::find($this->tagId);
                if (isset($filingTags->attributes['section_id'])){
                    $this->attributes['level'] = $filingTags->attributes['level'];
                    $this->attributes['section_id'] = $filingTags->attributes['section_id'];
                }
                $this->validateDimensions();
                $filingTags->update(['attributes' => $this->attributes]);
            } else {
                if ($this->attributes['level'] < 4 && isset($this->attributes['section']) && $this->attributes['section'] !== ''){
                    $this->attributes['section_id'] = true;
                }
                $this->validateDimensions();
                $filingTags = $filingTags->store($this->filingId, $this->attributes);
            }
        } catch (\Exception $exception) {

            Log::error($exception->getMessage());
        }

        return $filingTags->id;
    }

    public function validateDimensions(){
        if (isset($this->attributes['dimensions']) && !empty($this->attributes['dimensions'])){
            foreach ($this->attributes['dimensions'] as $key => $dimension){
                if (!isset($dimension['axis']) || !isset($dimension['domain'])){
                    unset($this->attributes['dimensions'][$key]);
                }
            }
        }
    }

    public function getModalContent(){
        if ($this->attributes){
            return $this->prepareEmptyModal();
        } else if ($this->tagId){
            return $this->prepareModalContent();
        }

        return '';
    }

    public function prepareModalContent(){
        $filingTag = FilingTag::where('id', $this->tagId)->first();

        if ($filingTag){
            $this->attributes = $filingTag->attributes;
            return (string)view('Editor::partials.tag-modal')->with($this->attributes)->with('labelsTypes', self::labelTypes);
        } else {
            return false;
        }
    }

    public function prepareEmptyModal(){
        return (string)view('Editor::partials.tag-modal')->with($this->attributes)->with('empty', 'true')->with('labelsTypes', self::labelTypes);
    }

    public function deleteTag(){
        try {
            FilingTag::find($this->tagId)->delete();
            return true;
        } catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return false;
    }

    public function getFilingTags(){
        $tags = [];
        $sections = FilingTag::where('filing_id', $this->filingId)->where([['attributes->section_id', 'true']])->get();
        if (!empty($sections)){
            foreach ($sections as $section){
                $tags[$section->id]['attributes'] = $section['attributes'];
                $tags[$section->id]['tags'] = FilingTag::where([['attributes->section_id', $section->id]])->get()->toArray();
            }
        }
        return $tags;
    }

}
