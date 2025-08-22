<?php

namespace Database\Seeders;

use App\Models\Accessibilities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AccessibilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $acccessibilites_json = '
            [
                {
                "access_id": 25,
                "sml_id": 122,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 26,
                "sml_id": 123,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 27,
                "sml_id": 124,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 29,
                "sml_id": 126,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 30,
                "sml_id": 127,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 31,
                "sml_id": 128,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 59,
                "sml_id": 156,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 60,
                "sml_id": 157,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 61,
                "sml_id": 158,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 62,
                "sml_id": 159,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 80,
                "sml_id": 175,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 81,
                "sml_id": 178,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 82,
                "sml_id": 179,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 83,
                "sml_id": 180,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 85,
                "sml_id": 181,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 86,
                "sml_id": 187,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 87,
                "sml_id": 189,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 88,
                "sml_id": 191,
                "user_id": 1,
                "date_created": "04\/25\/2022",
                "created_at": "04\/25\/2022",
                "updated_at": "04\/25\/2022"
                },
                {
                "access_id": 159,
                "sml_id": 203,
                "user_id": 1,
                "date_created": "05\/18\/2022",
                "created_at": "05\/18\/2022",
                "updated_at": "05\/18\/2022"
                },
                {
                "access_id": 160,
                "sml_id": 204,
                "user_id": 1,
                "date_created": "05\/18\/2022",
                "created_at": "05\/18\/2022",
                "updated_at": "05\/18\/2022"
                },
                {
                "access_id": 161,
                "sml_id": 205,
                "user_id": 1,
                "date_created": "05\/18\/2022",
                "created_at": "05\/18\/2022",
                "updated_at": "05\/18\/2022"
                },
                {
                "access_id": 162,
                "sml_id": 206,
                "user_id": 1,
                "date_created": "05\/18\/2022",
                "created_at": "05\/18\/2022",
                "updated_at": "05\/18\/2022"
                },
                {
                "access_id": 163,
                "sml_id": 207,
                "user_id": 1,
                "date_created": "05\/18\/2022",
                "created_at": "05\/18\/2022",
                "updated_at": "05\/18\/2022"
                },
                {
                "access_id": 165,
                "sml_id": 209,
                "user_id": 1,
                "date_created": "05\/20\/2022",
                "created_at": "05\/20\/2022",
                "updated_at": "05\/20\/2022"
                },
                {
                "access_id": 166,
                "sml_id": 211,
                "user_id": 1,
                "date_created": "05\/22\/2022",
                "created_at": "05\/22\/2022",
                "updated_at": "05\/22\/2022"
                },
                {
                "access_id": 167,
                "sml_id": 212,
                "user_id": 1,
                "date_created": "05\/22\/2022",
                "created_at": "05\/22\/2022",
                "updated_at": "05\/22\/2022"
                },
                {
                "access_id": 168,
                "sml_id": 213,
                "user_id": 1,
                "date_created": "05\/22\/2022",
                "created_at": "05\/22\/2022",
                "updated_at": "05\/22\/2022"
                },
                {
                "access_id": 170,
                "sml_id": 215,
                "user_id": 1,
                "date_created": "05\/22\/2022",
                "created_at": "05\/22\/2022",
                "updated_at": "05\/22\/2022"
                },
                {
                "access_id": 171,
                "sml_id": 216,
                "user_id": 1,
                "date_created": "05\/22\/2022",
                "created_at": "05\/22\/2022",
                "updated_at": "05\/22\/2022"
                },
                {
                "access_id": 175,
                "sml_id": 217,
                "user_id": 1,
                "date_created": "05\/24\/2022",
                "created_at": "05\/24\/2022",
                "updated_at": "05\/24\/2022"
                },
                {
                "access_id": 176,
                "sml_id": 219,
                "user_id": 1,
                "date_created": "05\/24\/2022",
                "created_at": "05\/24\/2022",
                "updated_at": "05\/24\/2022"
                },
                {
                "access_id": 177,
                "sml_id": 197,
                "user_id": 1,
                "date_created": "05\/24\/2022",
                "created_at": "05\/24\/2022",
                "updated_at": "05\/24\/2022"
                },
                {
                "access_id": 178,
                "sml_id": 220,
                "user_id": 1,
                "date_created": "05\/25\/2022",
                "created_at": "05\/25\/2022",
                "updated_at": "05\/25\/2022"
                },
                {
                "access_id": 179,
                "sml_id": 221,
                "user_id": 1,
                "date_created": "05\/25\/2022",
                "created_at": "05\/25\/2022",
                "updated_at": "05\/25\/2022"
                },
                {
                "access_id": 180,
                "sml_id": 223,
                "user_id": 1,
                "date_created": "05\/31\/2022",
                "created_at": "05\/31\/2022",
                "updated_at": "05\/31\/2022"
                },
                {
                "access_id": 181,
                "sml_id": 225,
                "user_id": 1,
                "date_created": "06\/01\/2022",
                "created_at": "06\/01\/2022",
                "updated_at": "06\/01\/2022"
                },
                {
                "access_id": 182,
                "sml_id": 226,
                "user_id": 1,
                "date_created": "06\/01\/2022",
                "created_at": "06\/01\/2022",
                "updated_at": "06\/01\/2022"
                },
                {
                "access_id": 183,
                "sml_id": 227,
                "user_id": 1,
                "date_created": "06\/01\/2022",
                "created_at": "06\/01\/2022",
                "updated_at": "06\/01\/2022"
                },
                {
                "access_id": 184,
                "sml_id": 228,
                "user_id": 1,
                "date_created": "06\/01\/2022",
                "created_at": "06\/01\/2022",
                "updated_at": "06\/01\/2022"
                },
                {
                "access_id": 189,
                "sml_id": 202,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 190,
                "sml_id": 201,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 191,
                "sml_id": 195,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 192,
                "sml_id": 193,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 193,
                "sml_id": 174,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 194,
                "sml_id": 232,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 195,
                "sml_id": 234,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 196,
                "sml_id": 235,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 197,
                "sml_id": 236,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 198,
                "sml_id": 237,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 199,
                "sml_id": 238,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 200,
                "sml_id": 239,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 201,
                "sml_id": 240,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 202,
                "sml_id": 241,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 203,
                "sml_id": 242,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 204,
                "sml_id": 244,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 205,
                "sml_id": 245,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 206,
                "sml_id": 246,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 207,
                "sml_id": 247,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 208,
                "sml_id": 248,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 209,
                "sml_id": 250,
                "user_id": 1,
                "date_created": "06\/02\/2022",
                "created_at": "06\/02\/2022",
                "updated_at": "06\/02\/2022"
                },
                {
                "access_id": 210,
                "sml_id": 255,
                "user_id": 1,
                "date_created": "06\/06\/2022",
                "created_at": "06\/06\/2022",
                "updated_at": "06\/06\/2022"
                },
                {
                "access_id": 211,
                "sml_id": 256,
                "user_id": 1,
                "date_created": "06\/06\/2022",
                "created_at": "06\/06\/2022",
                "updated_at": "06\/06\/2022"
                },
                {
                "access_id": 212,
                "sml_id": 259,
                "user_id": 1,
                "date_created": "06\/06\/2022",
                "created_at": "06\/06\/2022",
                "updated_at": "06\/06\/2022"
                },
                {
                "access_id": 213,
                "sml_id": 260,
                "user_id": 1,
                "date_created": "06\/13\/2022",
                "created_at": "06\/13\/2022",
                "updated_at": "06\/13\/2022"
                },
                {
                "access_id": 214,
                "sml_id": 262,
                "user_id": 1,
                "date_created": "06\/13\/2022",
                "created_at": "06\/13\/2022",
                "updated_at": "06\/13\/2022"
                },
                {
                "access_id": 215,
                "sml_id": 263,
                "user_id": 1,
                "date_created": "06\/22\/2022",
                "created_at": "06\/22\/2022",
                "updated_at": "06\/22\/2022"
                },
                {
                "access_id": 216,
                "sml_id": 265,
                "user_id": 1,
                "date_created": "06\/24\/2022",
                "created_at": "06\/24\/2022",
                "updated_at": "06\/24\/2022"
                },
                {
                "access_id": 217,
                "sml_id": 267,
                "user_id": 1,
                "date_created": "08\/31\/2022",
                "created_at": "08\/31\/2022",
                "updated_at": "08\/31\/2022"
                },
                {
                "access_id": 218,
                "sml_id": 268,
                "user_id": 1,
                "date_created": "09\/06\/2022",
                "created_at": "09\/06\/2022",
                "updated_at": "09\/06\/2022"
                },
                {
                "access_id": 219,
                "sml_id": 269,
                "user_id": 1,
                "date_created": "09\/06\/2022",
                "created_at": "09\/06\/2022",
                "updated_at": "09\/06\/2022"
                },
                {
                "access_id": 220,
                "sml_id": 214,
                "user_id": 1,
                "date_created": "09\/06\/2022",
                "created_at": "09\/06\/2022",
                "updated_at": "09\/06\/2022"
                },
                {
                "access_id": 221,
                "sml_id": 125,
                "user_id": 1,
                "date_created": "09\/06\/2022",
                "created_at": "09\/06\/2022",
                "updated_at": "09\/06\/2022"
                },
                {
                "access_id": 222,
                "sml_id": 208,
                "user_id": 1,
                "date_created": "09\/29\/2023",
                "created_at": "09\/29\/2023",
                "updated_at": "09\/29\/2023"
                },
                {
                "access_id": 223,
                "sml_id": 270,
                "user_id": 1,
                "date_created": "09\/19\/2023",
                "created_at": "09\/20\/2023",
                "updated_at": "09\/19\/2023"
                },
                {
                "access_id": 224,
                "sml_id": 271,
                "user_id": 1,
                "date_created": "10\/03\/2023",
                "created_at": "10\/03\/2023",
                "updated_at": "10\/03\/2023"
                },
                {
                "access_id": 225,
                "sml_id": 276,
                "user_id": 1,
                "date_created": "12\/06\/2023",
                "created_at": "10\/03\/2023",
                "updated_at": "10\/03\/2023"
                },
                {
                "access_id": 264,
                "sml_id": 277,
                "user_id": 1,
                "date_created": "03\/15\/2024",
                "created_at": "03\/15\/2024",
                "updated_at": "03\/15\/2024"
                },

                {
                "access_id": 341,
                "sml_id": 275,
                "user_id": 1,
                "date_created": "10\/14\/2024",
                "created_at": "10\/14\/2024",
                "updated_at": "10\/14\/2024"
                },
                {
                "access_id": 342,
                "sml_id": 279,
                "user_id": 1,
                "date_created": "11\/05\/2024",
                "created_at": "11\/05\/2024",
                "updated_at": "11\/05\/2024"
                },
                {
                "access_id": 343,
                "sml_id": 280,
                "user_id": 1,
                "date_created": "11\/05\/2024",
                "created_at": "11\/05\/2024",
                "updated_at": "11\/05\/2024"
                },
                {
                "access_id": 344,
                "sml_id": 278,
                "user_id": 1,
                "date_created": "11\/05\/2024",
                "created_at": "11\/05\/2024",
                "updated_at": "11\/05\/2024"
                },
                {
                "access_id": 345,
                "sml_id": 281,
                "user_id": 1,
                "date_created": "04\/23\/2025",
                "created_at": "04\/23\/2025",
                "updated_at": "04\/23\/2025"
                },
                {
                "access_id": 368,
                "sml_id": 282,
                "user_id": 1
                },
                {
                "access_id": 374,
                "sml_id": 283,
                "user_id": 1
                },
                {
                "access_id": 375,
                "sml_id": 284,
                "user_id": 1
                },
                {
                "access_id": 376,
                "sml_id": 285,
                "user_id": 1
                }
            ]';
        $data = json_decode($acccessibilites_json, true);
        try {
            DB::transaction(function () use ($data) {
                collect($data)->map(function (array $row) {
                    return Arr::only($row, ['sml_id', 'access_id', 'user_id']);
                })->chunk(1000)
                    ->each(function (Collection $chunk) {
                        Accessibilities::upsert($chunk->toArray(), ['sml_id', 'access_id', 'user_id']);
                    });
            });
        } catch (\Exception $e) {
            var_dump(['message' => 'Transcation Failed', 'error' => $e->getMessage()]);
        }
    }
}
