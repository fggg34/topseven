<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds all countries from database/data/countries_seed.json (ISO-2, name, phone code, region).
 * Run: php artisan db:seed --class=WorldCountriesSeeder
 * Safe to re-run: matches by iso_alpha2 or case-insensitive name, updates codes and region label.
 */
class WorldCountriesSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/countries_seed.json');
        if (! is_file($path)) {
            $this->command?->warn('Missing database/data/countries_seed.json — download from dr5hn/countries-states-cities-database or run wget; skipping WorldCountriesSeeder.');

            return;
        }

        $json = file_get_contents($path);
        if ($json === false) {
            return;
        }

        $rows = json_decode($json, true);
        if (! is_array($rows)) {
            $this->command?->error('countries_seed.json is not valid JSON.');

            return;
        }

        foreach ($rows as $row) {
            $iso2 = strtoupper(trim((string) ($row['iso2'] ?? '')));
            if (strlen($iso2) !== 2) {
                continue;
            }

            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $rawPhone = $row['phonecode'] ?? null;
            $calling = $rawPhone !== null && $rawPhone !== ''
                ? preg_replace('/\D+/', '', (string) $rawPhone)
                : null;
            if ($calling === '') {
                $calling = null;
            }

            $region = trim((string) ($row['region'] ?? ''));
            $subtitle = $region !== '' ? $region : 'World';

            $country = Country::query()
                ->where('iso_alpha2', $iso2)
                ->first()
                ?? Country::query()
                    ->whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower($name)])
                    ->first();

            if ($country) {
                $country->iso_alpha2 = $iso2;
                if ($calling !== null) {
                    $country->calling_code = $calling;
                }
                if (trim((string) $country->country) === '' || $country->country === 'Destination') {
                    $country->country = $subtitle;
                }
                $country->save();

                continue;
            }

            $baseSlug = Str::slug($name).'-'.mb_strtolower($iso2);
            $slug = $baseSlug;
            $n = 1;
            while (Country::query()->where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$n;
                $n++;
            }

            Country::query()->create([
                'name' => $name,
                'slug' => $slug,
                'iso_alpha2' => $iso2,
                'calling_code' => $calling,
                'country' => $subtitle,
                'is_active' => true,
            ]);
        }
    }
}
