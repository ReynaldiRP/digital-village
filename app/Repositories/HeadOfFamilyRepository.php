<?php

namespace App\Repositories;

use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use Exception;
use Illuminate\Support\Facades\DB;

class HeadOfFamilyRepository implements HeadOfFamilyRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        $query = HeadOfFamily::where(function ($query) use ($search) {
            // Apply search filter if provided
            if ($search) {
                $query->search($search);
            }
        });

        $query->latest();

        // Apply limit if provided
        if ($limit) {
            $query->take($limit);
        }

        if ($execute) {
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(
        ?string $search,
        ?int $rowPerPage
    ) {
        $query = $this->getAll(
            $search,
            $rowPerPage,
            false
        );

        return $query->paginate($rowPerPage);
    }

    public function getById(
        string $id
    ) {
        $query = HeadOfFamily::where('id', $id);

        return $query->first();
    }

    public function create(
        array $data
    ) {
        DB::beginTransaction();

        try {
            $headOfFamily = new HeadOfFamily();
            $headOfFamily->user_id = $data['user_id'];
            $headOfFamily->profile_picture = $data['profile_picture'] ?? null;
            $headOfFamily->identify_number = $data['identify_number'] ?? null;
            $headOfFamily->gender = $data['gender'] ?? null;
            $headOfFamily->birth_date = $data['birth_date'] ?? null;
            $headOfFamily->phone_number = $data['phone_number'] ?? null;
            $headOfFamily->occupation = $data['occupation'] ?? null;
            $headOfFamily->marital_status = $data['marital_status'] ?? null;

            $headOfFamily->save();

            DB::commit();
            return $headOfFamily;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
