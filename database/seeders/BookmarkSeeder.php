<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bookmark;
use Illuminate\Support\Facades\DB;

class BookmarkSeeder extends Seeder
{
    public function run()
    {
        if (DB::table('bookmarks')->count() == 0) {
            Bookmark::factory()->count(10000)->create();    
        }
    }
}