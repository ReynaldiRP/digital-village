<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventRepository implements EventRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        try {
            $query = Event::where(function ($query) use ($search) {
                if ($search) {
                    $query->search($search);
                }
            });

            if ($limit) {
                $query->take($limit);
            }

            if ($execute) {
                return $query->get();
            }

            return $query;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllPaginated(
        ?string $search,
        int $rowPerPage
    ) {
        try {
            $query = $this->getAll(
                $search,
                $rowPerPage,
                false
            );

            return $query->paginate($rowPerPage);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getById(
        string $id
    ) {
        $query = Event::where('id', $id);

        return $query->first();
    }

    public function create(
        array $data
    ) {
        DB::beginTransaction();

        try {
            $event = new Event();
            if (isset($data['thumbnail'])) {
                $event->thumbnail = $data['thumbnail'];
            }
            $event->name = $data['name'];
            $event->description = $data['description'];
            $event->price = $data['price'];
            $event->date = $data['date'];
            $event->time = $data['time'];
            $event->is_active = $data['is_active'];

            $event->save();
            DB::commit();

            return $event;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function update(
        string $id,
        array $data
    ) {
        DB::beginTransaction();

        try {
            $event = Event::find($id);

            if (isset($data['thumbnail'])) {
                $event->thumbnail = $data['thumbnail'];
            }
            $event->name = $data['name'] ?? $event->name;
            $event->description = $data['description'] ?? $event->description;
            $event->price = $data['price'] ?? $event->price;
            $event->date = $data['date'] ?? $event->date;
            $event->time = $data['time'] ?? $event->time;
            $event->is_active = $data['is_active'] ?? $event->is_active;
            $event->save();

            DB::commit();

            return $event;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(
        string $id
    ) {
        DB::beginTransaction();

        try {
            $event = Event::find($id);
            $event->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
