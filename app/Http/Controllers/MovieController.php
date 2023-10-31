<?php

namespace App\Http\Controllers;

use App\Adapters\ApiAdapter;
use App\DTO\CreateMovieDTO;
use App\DTO\CreateProducerDTO;
use App\DTO\CreateStudioDTO;
use App\DTO\UpdateMovieDTO;
use App\Http\Requests\StoreUpdateMovieRequest;
use App\Http\Resources\MovieAwardResource;
use App\Http\Resources\MovieResource;
use App\Services\MovieService;
use Illuminate\Http\{
    Request,
    Response
};

class MovieController extends Controller
{
    public function __construct(
        protected MovieService $service,
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $movie = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::toJson($movie);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateMovieRequest $request)
    {
        $needle = array(', ', 'and', 'AND');
        $studios = explode($needle[0], str_replace($needle, $needle[0], $request->studios));

        foreach ($studios as $key => $studioName) {
            $return[] = ['name' => $studioName];
        }

        $movie = $this->service->new(
            CreateMovieDTO::makeFromRequest($request),
            CreateProducerDTO::makeFromRequest($request),
            CreateStudioDTO::makeFromRequest($request),
        );
        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$movie = $this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateMovieRequest $request, string $id)
    {
        $movie = $this->service->update(
            UpdateMovieDTO::makeFromRequest($request, $id),
        );

        if (!$movie) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }


    public function award()
    {
        $awardWinenrs = $this->service->award();

        return new MovieAwardResource($awardWinenrs);
    }
}
