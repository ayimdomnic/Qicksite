<?php

namespace Ayimdomnic\QuickSite\Traits;

use Ayimdomnic\QuickSite\Models\Translation;

trait Translatable
{
    public function translation($lang)
    {
        return Translation::where('entity_id', $this->id)
            ->where('entity_type', get_class($this))
            ->where('entity_data->lang', $lang)
            ->first();
    }

    public function translationData($lang)
    {
        $translation = $this->translation($lang);

        if ($translation) {
            return json_decode($translation->entity_data);
        }
    }

    public function getTranslationsAttribute()
    {
        $translationData = [];
        $translations = Translation::where('entity_id', $this->id)->where('entity_type', get_class($this))->get();

        foreach ($translations as $translation) {
            $translationData[] = $translation->data->attributes;
        }

        return $translationData;
    }

    public function throwExceptionOnFail()
    {
        try{
            $this->translationData($lang);
        } catch($e){
            $e = echo "We are not ready";
        }
    }
}
