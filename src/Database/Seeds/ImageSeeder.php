<?php

use Phinx\Seed\AbstractSeed;

class ImageSeeder extends AbstractSeed
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
        $this->table('images')->truncate();
        $faker = Faker\Factory::create('FR_fr');
        $baseImages = require __DIR__ . '/data/images.php';
        $http = new \GuzzleHttp\Client();
        $imagesToInsert = [];
        // generate 50 images by usings images links
        $count = 8;
        for ($i = 0; $i < $count; $i++) {
            // for each image put content in image path
            // generate different size
            $id = uniqid();
            $url = $faker->randomElement($baseImages);
            $response = $http->get($url);
            $extension = \App\ImageHelper::MIMETypeToExtension($response->getHeader('Content-Type')[0]);
            $filePath = getenv('IMAGE_PATH') . '/' . $id . '/original.' . $extension;
            mkdir(getenv('IMAGE_PATH') . '/' . $id);
            file_put_contents($filePath, $response->getBody()->getContents());
            \App\ImageHelper::import($filePath);
            $imagesToInsert[] = [
                'id' => $id,
                'caption' => $faker->sentence(8),
                'extension' => $extension,
                'type' => $response->getHeader('Content-Type')[0],
                'created_at' => $faker->dateTimeThisDecade->format('Y-m-d H:i:s')
            ];
        }
        $this->insert('images', $imagesToInsert);
    }
}
