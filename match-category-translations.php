<?php
/**
 * Script to match and fix category translations based on old site data
 * The old site has Arabic names that should match our current categories
 * This will update category translations to ensure correct AR/EN names
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                                                                  ║\n";
echo "║          MATCHING CATEGORY TRANSLATIONS FROM OLD SITE           ║\n";
echo "║                                                                  ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// Old site category data (ID => Arabic Name from ec_product_categories)
$oldSiteCategories = [
    84 => 'خالي جلوتين',
    85 => 'خالي سكر',
    86 => 'كيتو',
    87 => 'سوبر فود',
    88 => 'أغذية رياضيين',
    89 => 'خالي لاكتوز',
    90 => 'نباتي',
    91 => 'قليل البروتين',
    95 => 'أغذية عضوية',
    96 => 'عروض',
    97 => 'كورن فلكس / شوفان',
    98 => 'بسكوت / ويفر',
    99 => 'شيبس/ سوس/ مارشملو',
    100 => 'شكولاتة',
    101 => 'مخبوزات',
    102 => 'طحين / خليط كيك',
    103 => 'معكرونة',
    104 => 'طعام / صوصات',
    105 => 'بهارات/ حبوب/ ماجي',
    106 => 'خالي سكر مضاف',
    107 => 'محليات',
    108 => 'محليات طبيعية',
    109 => 'بسكوت / ويفر',
    110 => 'شكولاتة / حلوى',
    111 => 'مشروبات',
    112 => 'رايس كيك /شوفان',
    113 => 'متنوع',
    114 => 'أرز/ ملح/ زيت رش',
    115 => 'خل/ زيوت',
    116 => 'محليات طبيعية',
    117 => 'طحين / خليط كيك',
    118 => 'مشروبات',
    119 => 'متنوع',
    120 => 'حليب',
    121 => 'أجبان',
    122 => 'متنوع',
    123 => 'سناكات',
    124 => 'رايس كيك /شوفان',
    125 => 'مشروبات',
    126 => 'متنوع',
    127 => 'مكملات',
    130 => 'واي بروتين',
    131 => 'ايزو بروتين',
    132 => 'حوارق دهون',
    133 => 'بيف بروتين',
    134 => 'كرياتين',
    135 => 'ماس',
    136 => 'بري ورك اوت',
    137 => 'هيدرو بروتين',
    138 => 'نباتي بروتين',
    139 => 'كارب',
    140 => 'احماض امينية',
    141 => 'كولاجين& فيتامين',
    142 => 'عروض',
];

// English translations (manual mapping)
$englishTranslations = [
    'خالي جلوتين' => 'Gluten Free',
    'خالي سكر' => 'Sugar Free',
    'كيتو' => 'Keto',
    'سوبر فود' => 'Super Food',
    'أغذية رياضيين' => 'Sports Nutrition',
    'خالي لاكتوز' => 'Lactose Free',
    'نباتي' => 'Vegan',
    'قليل البروتين' => 'Low Protein',
    'أغذية عضوية' => 'Organic Food',
    'عروض' => 'Offers',
    'كورن فلكس / شوفان' => 'Corn Flakes / Oats',
    'بسكوت / ويفر' => 'Biscuits / Wafer',
    'شيبس/ سوس/ مارشملو' => 'Chips / Snacks / Marshmallow',
    'شكولاتة' => 'Chocolate',
    'مخبوزات' => 'Bakery',
    'طحين / خليط كيك' => 'Flour / Cake Mix',
    'معكرونة' => 'Pasta',
    'طعام / صوصات' => 'Food / Sauces',
    'بهارات/ حبوب/ ماجي' => 'Spices / Grains / Maggi',
    'خالي سكر مضاف' => 'No Added Sugar',
    'محليات' => 'Sweeteners',
    'محليات طبيعية' => 'Natural Sweeteners',
    'شكولاتة / حلوى' => 'Chocolate / Sweets',
    'مشروبات' => 'Beverages',
    'رايس كيك /شوفان' => 'Rice Cakes / Oats',
    'متنوع' => 'Miscellaneous',
    'أرز/ ملح/ زيت رش' => 'Rice / Salt / Spray Oil',
    'خل/ زيوت' => 'Vinegar / Oils',
    'حليب' => 'Milk',
    'أجبان' => 'Cheese',
    'سناكات' => 'Snacks',
    'مكملات' => 'Supplements',
    'واي بروتين' => 'Whey Protein',
    'ايزو بروتين' => 'Iso Protein',
    'حوارق دهون' => 'Fat Burners',
    'بيف بروتين' => 'Beef Protein',
    'كرياتين' => 'Creatine',
    'ماس' => 'Mass Gainer',
    'بري ورك اوت' => 'Pre Workout',
    'هيدرو بروتين' => 'Hydro Protein',
    'نباتي بروتين' => 'Vegan Protein',
    'كارب' => 'Carbs',
    'احماض امينية' => 'Amino Acids',
    'كولاجين& فيتامين' => 'Collagen & Vitamins',
];

echo "Step 1: Matching categories by ID and updating names...\n";
echo "========================================================\n";

$matched = 0;
$updated = 0;
$notFound = 0;

foreach ($oldSiteCategories as $oldId => $arabicName) {
    // Check if category with this ID exists in our database
    $category = DB::table('categories')->where('id', $oldId)->first();
    
    if ($category) {
        echo "\n✅ Found ID $oldId: $arabicName\n";
        
        // Update the main name field
        DB::table('categories')
            ->where('id', $oldId)
            ->update(['name' => $arabicName]);
        
        // Update or create Arabic translation
        DB::table('category_translations')->updateOrInsert(
            ['category_id' => $oldId, 'lang_code' => 'ar'],
            ['name' => $arabicName]
        );
        
        // Update or create English translation
        $englishName = $englishTranslations[$arabicName] ?? $category->name;
        DB::table('category_translations')->updateOrInsert(
            ['category_id' => $oldId, 'lang_code' => 'en'],
            ['name' => $englishName]
        );
        
        echo "   📝 AR: $arabicName\n";
        echo "   📝 EN: $englishName\n";
        
        $matched++;
        $updated++;
    } else {
        echo "⚠️  ID $oldId not found in current database: $arabicName\n";
        $notFound++;
    }
}

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                                                                  ║\n";
echo "║                    TRANSLATION UPDATE COMPLETE                   ║\n";
echo "║                                                                  ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

echo "Summary:\n";
echo "--------\n";
echo "✅ Categories matched by ID: $matched\n";
echo "✅ Categories updated: $updated\n";
echo "⚠️  Categories not found: $notFound\n";

echo "\nVerification Sample:\n";
echo "====================\n";
$samples = DB::table('categories')
    ->whereIn('id', [84, 88, 127, 134])
    ->get();

foreach ($samples as $cat) {
    $arTrans = DB::table('category_translations')
        ->where('category_id', $cat->id)
        ->where('lang_code', 'ar')
        ->first();
    $enTrans = DB::table('category_translations')
        ->where('category_id', $cat->id)
        ->where('lang_code', 'en')
        ->first();
    
    echo "\nID {$cat->id}: {$cat->name}\n";
    echo "  AR: " . ($arTrans->name ?? 'N/A') . "\n";
    echo "  EN: " . ($enTrans->name ?? 'N/A') . "\n";
}

echo "\n✅ Translation matching complete!\n";
