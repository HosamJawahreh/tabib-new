<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Font extends Model
{
    protected $fillable = ['is_default','font_family','font_value','language'];
    protected $table    = 'fonts';

    public $timestamps  = false;
    
    /**
     * Get the default font for a specific language
     */
    public static function getDefaultFont($language = 'both')
    {
        return cache()->remember("default_font_{$language}", 3600, function () use ($language) {
            return self::where('is_default', 1)
                ->where(function($query) use ($language) {
                    $query->where('language', $language)
                          ->orWhere('language', 'both');
                })
                ->first();
        });
    }
    
    /**
     * Get separate fonts for Arabic and English
     */
    public static function getBilingualFonts()
    {
        return cache()->remember('bilingual_fonts', 3600, function () {
            // Get default Arabic font
            $arabicFont = self::where('is_default', 1)
                ->where('language', 'ar')
                ->first();
            
            // If no Arabic font, try 'both' language fonts
            if (!$arabicFont) {
                $arabicFont = self::where('is_default', 1)
                    ->where('language', 'both')
                    ->first();
            }
                
            // Get default English font
            $englishFont = self::where('is_default', 1)
                ->where('language', 'en')
                ->first();
            
            // If no English font, try 'both' language fonts
            if (!$englishFont) {
                $englishFont = self::where('is_default', 1)
                    ->where('language', 'both')
                    ->first();
            }
                
            return [
                'arabic' => $arabicFont ?: self::getDefaultFallback('ar'),
                'english' => $englishFont ?: self::getDefaultFallback('en')
            ];
        });
    }
    
    /**
     * Get fallback fonts
     */
    private static function getDefaultFallback($language)
    {
        $defaults = [
            'ar' => (object)[
                'font_family' => 'Cairo',
                'font_value' => 'Cairo',
                'language' => 'ar'
            ],
            'en' => (object)[
                'font_family' => 'Poppins',
                'font_value' => 'Poppins',
                'language' => 'en'
            ]
        ];
        
        return $defaults[$language] ?? $defaults['en'];
    }
}
