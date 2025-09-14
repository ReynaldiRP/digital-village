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

        $query->with('familyMembers')->latest();

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
            $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head-of-families', 'public');
            $headOfFamily->identify_number = $data['identify_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->birth_date = $data['birth_date'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];

            $headOfFamily->save();

            DB::commit();
            return $headOfFamily;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update(
        string $id,
        array $data
    ) {
        DB::beginTransaction();

        try {
            $headOfFamily = HeadOfFamily::find($id);

            $headOfFamily->user_id = $data['user_id'] ?? $headOfFamily->user_id;

            if (isset($data['profile_picture'])) {
                $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head-of-families', 'public');
            }

            $headOfFamily->identify_number = $data['identify_number'] ?? $headOfFamily->identify_number;
            $headOfFamily->gender = $data['gender'] ?? $headOfFamily->gender;
            $headOfFamily->birth_date = $data['birth_date'] ?? $headOfFamily->birth_date;
            $headOfFamily->phone_number = $data['phone_number'] ?? $headOfFamily->phone_number;
            $headOfFamily->occupation = $data['occupation'] ?? $headOfFamily->occupation;
            $headOfFamily->marital_status = $data['marital_status'] ?? $headOfFamily->marital_status;

            $headOfFamily->save();

            DB::commit();

            return $headOfFamily;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function delete(
        string $id
    ) {
        DB::beginTransaction();

        try {
            $headOfFamily = HeadOfFamily::find($id);
            $headOfFamily->delete();

            DB::commit();

            return $headOfFamily;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
