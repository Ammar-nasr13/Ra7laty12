<?php

namespace App\Console\Commands;

use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Console\Command;

class SeedMediaImages extends Command
{
    protected $signature = 'media:seed-images {--fresh : Clear existing media before seeding}';
    protected $description = 'Download and attach Unsplash images to trips and destinations';

    // Full Unsplash CDN photo ID (the long numeric hash from images.unsplash.com)
    private function url(string $photoId, int $width = 1200): string
    {
        return "https://images.unsplash.com/photo-{$photoId}?auto=format&fit=crop&w={$width}&q=80";
    }

    public function handle(): int
    {
        $this->seedTrips();
        $this->newLine();
        $this->seedDestinations();
        return 0;
    }

    private function seedTrips(): void
    {
        // Keyed by sort_order (matches TripSeeder). Photo IDs are real Unsplash CDN hashes.
        $tripImages = [
            1  => [ // Magical Hurghada — Red Sea aerial & beach
                'image'   => '1722264219947-725d4e20ef23',
                'gallery' => ['1631276127190-af69f467664a'],
            ],
            2  => [ // Legendary Sharm El-Sheikh — coral reef
                'image'   => '1708649290066-5f617003b93f',
                'gallery' => ['1682687982049-b3d433368cd1'],
            ],
            3  => [ // Luxor & Aswan — pharaonic temples
                'image'   => '1587975844577-56dfe5d3fca8',
                'gallery' => ['1634315426802-e4aa48ec3884'],
            ],
            4  => [ // Paris — Eiffel Tower
                'image'   => '1511739001486-6bfe10ce785f',
                'gallery' => ['1735744150032-3295c3d69969'],
            ],
            5  => [ // Rome — Colosseum
                'image'   => '1552832230-c0197dd311b5',
                'gallery' => ['1460722665083-c2599113f7e0'],
            ],
            6  => [ // Barcelona — Sagrada Família cityscape
                'image'   => '1764107183244-0cef642a99a9',
                'gallery' => ['1745186487192-09eccb385169'],
            ],
            7  => [ // Dubai — Burj Khalifa sunset
                'image'   => '1749273858638-ea678cb48e94',
                'gallery' => ['1753029111752-f12018752cd3'],
            ],
            8  => [ // Istanbul — Ortaköy mosque & Bosphorus
                'image'   => '1759347171702-e9cae049bc01',
                'gallery' => ['1763965367191-6455ef032c79'],
            ],
            9  => [ // Bali — rice terraces
                'image'   => '1557093793-d149a38a1be8',
                'gallery' => ['1559628233-eb1b1a45564b'],
            ],
            10 => [ // New York — Manhattan skyline
                'image'   => '1750074543601-72f7972d5a8b',
                'gallery' => ['1754766621748-2a96cbf56a1f'],
            ],
            11 => [ // Maldives — overwater bungalows
                'image'   => '1602002418209-55d7a55adf42',
                'gallery' => ['1637576308588-6647bf80944d'],
            ],
            12 => [ // Tokyo — bustling street at night
                'image'   => '1749813482475-3c12a8c4a5bd',
                'gallery' => [],
            ],
            13 => [ // Morocco — Marrakech medina
                'image'   => '1611484158632-e7098dac0676',
                'gallery' => [],
            ],
            14 => [ // Greek Islands — Santorini white & blue
                'image'   => '1747933172848-8a02d207facd',
                'gallery' => ['1722581174702-706197ded63d'],
            ],
            15 => [ // Switzerland — Alps snow-capped mountains
                'image'   => '1719663278161-d057d22b5fcf',
                'gallery' => ['1441039995991-e5c1178e605a'],
            ],
            16 => [ // Albania — Ksamil coast
                'image'   => '1584552756041-c09ebcc85e7c',
                'gallery' => ['1563640333984-e78e5039210b'],
            ],
        ];

        $this->info('Seeding trip images...');
        $bar = $this->output->createProgressBar(count($tripImages));
        $bar->start();

        foreach ($tripImages as $sortOrder => $photos) {
            $trip = Trip::where('sort_order', $sortOrder)->first();

            if (! $trip) {
                $this->newLine();
                $this->warn("Trip sort_order={$sortOrder} not found, skipping.");
                $bar->advance();
                continue;
            }

            if ($this->option('fresh')) {
                $trip->clearMediaCollection('image');
                $trip->clearMediaCollection('gallery');
            }

            if (! $trip->hasMedia('image')) {
                $this->addMedia($trip, $this->url($photos['image']), 'image', $photos['image']);
            }

            if ($trip->getMedia('gallery')->isEmpty() && count($photos['gallery'])) {
                foreach ($photos['gallery'] as $id) {
                    $this->addMedia($trip, $this->url($id, 800), 'gallery', $id);
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Trip images done.');
    }

    private function seedDestinations(): void
    {
        // Keyed by sort_order (matches DestinationSeeder).
        $destImages = [
            1 => [ // Hurghada — Red Sea aerial
                'image'   => '1722264219947-725d4e20ef23',
                'gallery' => ['1631276127190-af69f467664a'],
            ],
            2 => [ // Sharm El-Sheikh — coral reef
                'image'   => '1708649290066-5f617003b93f',
                'gallery' => ['1682687982049-b3d433368cd1'],
            ],
            3 => [ // Luxor & Aswan — pharaonic temples
                'image'   => '1587975844577-56dfe5d3fca8',
                'gallery' => ['1634315426802-e4aa48ec3884'],
            ],
            4 => [ // Cairo — Pyramids of Giza aerial
                'image'   => '1541769740-098e80269166',
                'gallery' => [],
            ],
            5 => [ // Marsa Matrouh — Mediterranean coast
                'image'   => '1631276127151-1c9af1286221',
                'gallery' => [],
            ],
            6 => [ // Sinai — desert mountains
                'image'   => '1572422071265-8e53a20366da',
                'gallery' => ['1660153076320-b49cf731ef8a'],
            ],
        ];

        $this->info('Seeding destination images...');
        $bar = $this->output->createProgressBar(count($destImages));
        $bar->start();

        foreach ($destImages as $sortOrder => $photos) {
            $dest = Destination::where('sort_order', $sortOrder)->first();

            if (! $dest) {
                $this->newLine();
                $this->warn("Destination sort_order={$sortOrder} not found, skipping.");
                $bar->advance();
                continue;
            }

            if ($this->option('fresh')) {
                $dest->clearMediaCollection('image');
                $dest->clearMediaCollection('gallery');
            }

            if (! $dest->hasMedia('image')) {
                $this->addMedia($dest, $this->url($photos['image']), 'image', $photos['image']);
            }

            if ($dest->getMedia('gallery')->isEmpty() && count($photos['gallery'])) {
                foreach ($photos['gallery'] as $id) {
                    $this->addMedia($dest, $this->url($id, 800), 'gallery', $id);
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Destination images done.');
    }

    private function addMedia(mixed $model, string $url, string $collection, string $id): void
    {
        try {
            $model->addMediaFromUrl($url)
                  ->usingFileName("{$id}.jpg")
                  ->toMediaCollection($collection);
        } catch (\Throwable $e) {
            $this->newLine();
            $this->warn("  ✗ [{$id}]: " . $e->getMessage());
        }
    }
}
