<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the user resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $users = $this->userRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(
                true,
                'Data User Berhasil Diambil',
                UserResource::collection($users),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(
                false,
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Get all users with pagination.
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllPaginated(Request $request): JsonResponse
    {
        try {
            $request = $request->validate([
                'search' => 'nullable|string',
                'row_per_page' => 'required',
            ]);

            $users = $this->userRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(
                true,
                'Data User Berhasil Diambil',
                PaginatedResource::make($users, UserResource::class),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(
                false,
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Store a newly created user in storage.
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $request = $request->validated();

        try {
            $user = $this->userRepository->create($request);

            return ResponseHelper::jsonResponse(
                true,
                'Data User Berhasil Ditambahkan',
                new UserResource($user),
                201
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(
                false,
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $user = $this->userRepository->getById($id);

            if (!$user) {
                return ResponseHelper::jsonResponse(
                    false,
                    'Data User Tidak Ditemukan',
                    null,
                    404
                );
            }

            return ResponseHelper::jsonResponse(
                true,
                'Data User Berhasil Diambil',
                new UserResource($user),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(
                false,
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UserUpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, string $id): JsonResponse
    {
        $request = $request->validated();

        try {
            $user = $this->userRepository->update($id, $request);

            return ResponseHelper::jsonResponse(
                true,
                'Data User Berhasil Diupdate',
                new UserResource($user),
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(
                false,
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->userRepository->destroy($id);

            return ResponseHelper::jsonResponse(
                true,
                'Data User Berhasil Dihapus',
                null,
                204
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(
                false,
                $e->getMessage(),
                null,
                500
            );
        }
    }
}
