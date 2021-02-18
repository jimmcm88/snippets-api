<?php

namespace App\Http\Controllers\Keys;

use Algolia\AlgoliaSearch\Algolia;
use Algolia\AlgoliaSearch\SearchClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlgoliaKeyController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'data' => SearchClient::generateSecuredApiKey(
                config('scout.algolia.key'), [
                    'filters' => 'data.is_public:true'
                ]
            )
        ]);
    }
}
