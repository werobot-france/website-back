<?php

use Cocur\Slugify\Slugify;
use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $this->table('posts')->truncate();
        $faker = Faker\Factory::create('FR_fr');

        $images = require __DIR__ . '/data/images.php';
        $markdown = require __DIR__ . '/data/markdown.php';

        $posts = [];

        $identifiers = [];
        for ($i = 0; $i < 10; $i++) {
            $identifiers[] = uniqid();
        }

        $identifier = 0;
        $locale = false;
        $slugger = new Slugify();
        for ($i = 0; $i < 20; $i++) {
            if ($locale) {
                $locale = 'fr';
            } else {
                $locale = 'en';
            }
            $title = $faker->sentence();
            $posts[] = [
                'id' => uniqid(),
                'identifier' => $identifiers[$identifier],
                'locale' => $locale,
                'title' => $title,
                'slug' => $slugger->slugify($title),
                'description' => $faker->text(190),
                'image' => $faker->randomElement($images),
                'content' => $markdown,
                'created_at' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeThisYear->format('Y-m-d H:i:s')
            ];
            if ($i % 2) {
                $locale = false;
                $identifier++;
            }
        }
        $this->insert('posts', $posts);
    }
}
