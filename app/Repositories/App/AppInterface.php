<?php


namespace App\Repositories\App;


interface AppInterface
{
    public function getSystemData(string $deviceToken);

    public function saveFavorites(array $data);

    public function removeFavorites(array $data);

    public function getFavorites(int $deviceId, $latestArticleOffset, $limit = 10);

    public function updatePersonalSettings(array $data, int $deviceId);

    public function getPersonalSettings(int $deviceId);
}
