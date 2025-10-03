<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\DevelopmentApplicants\DevelopmentApplicantStoreRequest;
use App\Http\Requests\DevelopmentApplicants\DevelopmentApplicantUpdateRequest;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Http\Resources\PaginatedResource;
use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DevelopmentApplicantController extends Controller
{
    private DevelopmentApplicantRepositoryInterface $developmentApplicantRepository;

    public function __construct(DevelopmentApplicantRepositoryInterface $developmentApplicantRepository)
    {
        $this->developmentApplicantRepository = $developmentApplicantRepository;
    }

    /**
     * Display a listing of the development applicants.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil mengambil data pendaftar development',
                DevelopmentApplicantResource::collection($developmentApplicants),
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
     * Get all development applicants paginated.
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


            $developmentApplicants = $this->developmentApplicantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(
                true,
                'Data Development Berhasil Diambil',
                new PaginatedResource($developmentApplicants, DevelopmentApplicantResource::class),
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
     * Store a newly created development applicant in storage.
     * @param DevelopmentApplicantStoreRequest $request
     * @return JsonResponse
     */
    public function store(DevelopmentApplicantStoreRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $developmentApplicant = $this->developmentApplicantRepository->create($request);
            return ResponseHelper::jsonResponse(
                true,
                'Berhasil menambahkan data pendaftar development',
                new DevelopmentApplicantResource($developmentApplicant),
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
     * Display the specified development applicant.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(
                    false,
                    'Data pendaftar development tidak ditemukan',
                    null,
                    404
                );
            }

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil mengambil data pendaftar development',
                new DevelopmentApplicantResource($developmentApplicant),
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
     * Update the specified development applicants in storage.
     * @param DevelopmentApplicantUpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(DevelopmentApplicantUpdateRequest $request, string $id): JsonResponse
    {
        $request = $request->validated();
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);
            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(
                    false,
                    'Data pendaftar development tidak ditemukan',
                    null,
                    404
                );
            }
            $developmentApplicant = $this->developmentApplicantRepository->update($id, $request);
            return ResponseHelper::jsonResponse(
                true,
                'Berhasil memperbarui data pendaftar development',
                new DevelopmentApplicantResource($developmentApplicant),
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
     * Remove the specified development applicant from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(
                    false,
                    'Data pendaftar development tidak ditemukan',
                    null,
                    404
                );
            }

            $developmentApplicant = $this->developmentApplicantRepository->delete($id);

            return ResponseHelper::jsonResponse(
                true,
                'Berhasil menghapus data pendaftar development',
                new DevelopmentApplicantResource($developmentApplicant),
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
