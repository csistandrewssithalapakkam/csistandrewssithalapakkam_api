<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Verse;
use Carbon\Carbon;

$kjvVerses = [
    'John 3:16 - For God so loved the world, that he gave his only begotten Son, that whosoever believeth in him should not perish, but have everlasting life.',
    'Psalm 23:1 - The Lord is my shepherd; I shall not want.',
    'Philippians 4:13 - I can do all things through Christ which strengtheneth me.',
    'Romans 8:28 - And we know that all things work together for good to them that love God.',
    'Proverbs 3:5 - Trust in the Lord with all thine heart; and lean not unto thine own understanding.',
    'Matthew 5:9 - Blessed are the peacemakers: for they shall be called the children of God.',
    'Isaiah 41:10 - Fear thou not; for I am with thee: be not dismayed; for I am thy God.',
    'Psalm 46:1 - God is our refuge and strength, a very present help in trouble.',
    'Psalm 27:1 - The Lord is my light and my salvation; whom shall I fear?',
    'Jeremiah 29:11 - For I know the thoughts that I think toward you, saith the Lord, thoughts of peace, and not of evil.',
    'Psalm 119:105 - Thy word is a lamp unto my feet, and a light unto my path.',
    'Hebrews 11:1 - Now faith is the substance of things hoped for, the evidence of things not seen.',
    'Galatians 5:22 - But the fruit of the Spirit is love, joy, peace, longsuffering, gentleness, goodness, faith.',
    '1 Corinthians 13:4 - Charity suffereth long, and is kind; charity envieth not; charity vaunteth not itself, is not puffed up.',
    'Ephesians 2:8 - For by grace are ye saved through faith; and that not of yourselves: it is the gift of God.',
    'Colossians 3:23 - And whatsoever ye do, do it heartily, as to the Lord, and not unto men;',
    'Micah 6:8 - He hath shewed thee, O man, what is good; and what doth the Lord require of thee?',
    'Matthew 6:33 - But seek ye first the kingdom of God, and his righteousness; and all these things shall be added unto you.',
    'Luke 12:34 - For where your treasure is, there will your heart be also.',
    'John 14:6 - Jesus saith unto him, I am the way, the truth, and the life: no man cometh unto the Father, but by me.'
];

$start = Carbon::today();
$end = Carbon::create(2026, 12, 31);

$inserted = 0;
$skipped = 0;

for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
    $d = $date->toDateString();
    $exists = Verse::where('week_date', $d)->exists();
    if ($exists) {
        $skipped++;
        continue;
    }

    $rand = $kjvVerses[array_rand($kjvVerses)];
    $ref = preg_match('/^[A-Za-z0-9 ]+:\d+/', $rand, $matches) ? $matches[0] : '';
    $tamil = ($ref ? "தமிழ்: " . $ref . " (தமிழ் மொழிபெயர்ப்பு)" : "தமிழ்: (தமிழ் மொழிபெயர்ப்பு)");

    Verse::create([
        'week_date' => $d,
        'verse_tamil' => $tamil,
        'verse_english' => $rand,
        'verse_status' => '1',
        'created_by' => 1,
    ]);
    $inserted++;
    echo "Inserted $d\n";
}

echo "Done. Inserted: $inserted. Skipped (already existing): $skipped\n";
