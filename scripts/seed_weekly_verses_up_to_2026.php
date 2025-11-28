<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Verse;
use Carbon\Carbon;

// Get current max date
$max = \Illuminate\Support\Facades\DB::table('tbl_verse')->max('week_date');
if (!$max) {
    $start = Carbon::parse('2025-11-30');
} else {
    $start = Carbon::parse($max);
}

$start = $start->addDays(7); // start from next week
$end = Carbon::create(2026, 12, 27); // last Sunday of 2026 to include

$created = 0;
while ($start->lte($end)) {
    $date = $start->toDateString();

    // Check if exists
    $exists = Verse::where('week_date', $date)->exists();
    if (!$exists) {
        Verse::create([
            'week_date' => $date,
            'verse_tamil' => "TBD verse for $date (Tamil)",
            'verse_english' => "TBD verse for $date (English)",
            'verse_status' => '1',
            'created_by' => 1,
        ]);
        $created++;
        echo "Inserted verse for $date\n";
    } else {
        echo "Already exists for $date, skipping\n";
    }

    $start->addDays(7);
}

echo "Done. Inserted $created records.\n";

