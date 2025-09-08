<?php

namespace App\Repositories;

use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Models\FamilyMember;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class FamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        $query = FamilyMember::where(function ($query) use ($search) {
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
        $query = FamilyMember::where('id', $id)->with('headOfFamily');

        return $query->first();
    }

    public function create(
        array $data
    ) {
        DB::beginTransaction();

        try {
            $userRepository = new UserRepository();

            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);


            $familyMember = new FamilyMember();
            $familyMember->head_of_family_id = $data['head_of_family_id'];
            $familyMember->user_id = $user->id;
            $familyMember->profile_picture = $data['profile_picture'];
            $familyMember->identify_number = $data['identify_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->birth_date = $data['birth_date'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->occupation = $data['occupation'];
            $familyMember->marital_status = $data['marital_status'];
            $familyMember->relation = $data['relation'];
            $familyMember->save();

            DB::commit();

            return $familyMember;
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
            $familyMember = $this->getById($id);

            if (!$familyMember) {
                throw new Exception('Anggota keluarga tidak ditemukan');
            }

            $familyMember->head_of_family_id = $data['head_of_family_id'] ?? $familyMember->head_of_family_id;
            $familyMember->user_id = $data['user_id'] ?? $familyMember->user_id;
            $familyMember->profile_picture = $data['profile_picture'] ?? $familyMember->profile_picture;
            $familyMember->identify_number = $data['identify_number'] ?? $familyMember->identify_number;
            $familyMember->gender = $data['gender'] ?? $familyMember->gender;
            $familyMember->birth_date = $data['birth_date'] ?? $familyMember->birth_date;
            $familyMember->phone_number = $data['phone_number'] ?? $familyMember->phone_number;
            $familyMember->occupation = $data['occupation'] ?? $familyMember->occupation;
            $familyMember->marital_status = $data['marital_status'] ?? $familyMember->marital_status;
            $familyMember->relation = $data['relation'] ?? $familyMember->relation;

            $familyMember->save();

            DB::commit();

            return $familyMember;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function destroy(
        string $id
    ) {
        DB::beginTransaction();

        try {
            $familyMember = $this->getById($id);

            if (!$familyMember) {
                throw new Exception('Anggota keluarga tidak ditemukan');
            }

            $familyMember->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
