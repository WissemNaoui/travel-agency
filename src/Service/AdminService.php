<?php

namespace App\Services;

use App\Models\Destination;

class AdminService
{
    public function createDestination(array $data): Destination
    {
        return Destination::create($data);
    }

    public function updateDestination(Destination $destination, array $data): Destination
    {
        $destination->update($data);
        return $destination;
    }

    public function deleteDestination(Destination $destination): void
    {
        $destination->delete();
    }
}
