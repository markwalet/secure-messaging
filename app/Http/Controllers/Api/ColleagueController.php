<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColleagueCollectionResource;
use App\Models\Colleague;

class ColleagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ColleagueCollectionResource
     */
    public function index(): ColleagueCollectionResource
    {
        return new ColleagueCollectionResource(
            Colleague::all(),
        );
    }
}
