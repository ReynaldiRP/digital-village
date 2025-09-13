<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistances\SocialAssistanceStoreRequest;
use App\Http\Requests\SocialAssistances\SocialAssistanceUpdateRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\SocialAssistanceResource;
use App\Interfaces\SocialAssistanceRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialAssistanceController extends Controller
{
    private SocialAssistanceRepositoryInterface $socialAssistanceRepository;

    public function __construct(SocialAssistanceRepositoryInterface $socialAssistanceRepository)
    {
        $this->socialAssistanceRepository = $socialAssistanceRepository;
    }


    /**
     * Display a listing of the social assistance.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $socialAssistances = $this->socialAssistanceRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil mendapatkan data bantuan sosial',
                SocialAssistanceResource::collection($socialAssistances),
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
     * Get all social assistance paginated.
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

            $socialAssistances = $this->socialAssistanceRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil mendapatkan data bantuan sosial',
                PaginatedResource::make($socialAssistances, SocialAssistanceResource::class),
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
     * Store a newly created social assistance in storage.
     * @param SocialAssistanceStoreRequest $request
     * @return JsonResponse
     */
    public function store(SocialAssistanceStoreRequest $request): JsonResponse
    {
        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistanceRepository->create($request);

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil menambahkan data bantuan sosial',
                new SocialAssistanceResource($socialAssistance),
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
     * Display the specified social assistance.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->getById($id);

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(
                    false,
                    'Data bantuan sosial tidak ditemukan',
                    null,
                    404
                );
            }

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil mendapatkan data bantuan sosial',
                new SocialAssistanceResource($socialAssistance),
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
     * Update the specified social assistance in storage.
     * @param SocialAssistanceUpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(SocialAssistanceUpdateRequest $request, string $id): JsonResponse
    {
        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistanceRepository->getById($id);

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(
                    false,
                    'Data bantuan sosial tidak ditemukan',
                    null,
                    404
                );
            }

            $socialAssistance = $this->socialAssistanceRepository->update($id, $request);

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil memperbarui data bantuan sosial',
                new SocialAssistanceResource($socialAssistance),
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
     * Remove the specified social assistance from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->getById($id);

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(
                    false,
                    'Data bantuan sosial tidak ditemukan',
                    null,
                    404
                );
            }

            $this->socialAssistanceRepository->delete($id);

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil menghapus data bantuan sosial',
                new SocialAssistanceResource($socialAssistance),
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
}
